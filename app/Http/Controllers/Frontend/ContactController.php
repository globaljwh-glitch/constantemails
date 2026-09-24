<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use App\Models\BadMailCategory;
use App\Models\BadMailList;
use App\Services\EmailVerifier;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    /**
     * Display contacts.
     */
    public function index(Group $group)
    {
        abort_if($group->user_id != auth()->id(), 403);

        $contacts = $group->contacts()
            ->orderBy('contact_first_name')
            ->paginate(20);

        return view(
            'frontend.user.contacts.index',
            compact('group', 'contacts')
        );
    }

    /**
     * Show Add Contact form.
     */
    public function create(Request $request)
    {
        $groups = Group::where('user_id',auth()->id())
            ->where('status',1)
            ->orderBy('group_name')
            ->get();

        return view(
            'frontend.user.contacts.create',
            compact('groups')
        );
    }

    /**
     * Store manually added contact.
     */
    public function store(Request $request)
    {
        $request->validate([

            'group_id'=>'required|exists:contact_groups,id',

            'contact_first_name'=>'required|max:255',

            'contact_last_name'=>'nullable|max:255',

            'contact_email'=>'required|email',

            'contact_phone'=>'nullable|max:100',

            'contact_company_name'=>'nullable|max:255',

            'contact_address'=>'nullable',

            'area_interest'=>'nullable',

        ]);

        Contact::create([

            'user_id'=>auth()->id(),

            'group_id'=>$request->group_id,

            'contact_first_name'=>$request->contact_first_name,

            'contact_last_name'=>$request->contact_last_name,

            'contact_company_name'=>$request->contact_company_name,

            'contact_address'=>$request->contact_address,

            'area_interest'=>$request->area_interest,

            'contact_email'=>$request->contact_email,

            'contact_phone'=>$request->contact_phone,

            'status'=>1,

            'user_status'=>'opt-in',

        ]);

        return redirect()

            ->route('user.groups.contacts.index',$request->group_id)

            ->with('success','Contact added successfully.');

    }

    /**
     * Show Import Contacts page.
     */
    public function importForm()
    {
        $groups = Group::where('user_id', auth()->id())
            ->where('status', 1)
            ->orderBy('group_name')
            ->get();

        return view('frontend.user.contacts.import', compact('groups'));
    }

    /**
     * Import contacts.
     */
    public function import2(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:contact_groups,id',
            'contacts_file' => 'required|mimes:csv,txt,xls,xlsx|max:10240',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Import Logic
        |--------------------------------------------------------------------------
        | Will implement using Laravel Excel
        |
        | Excel::import(
        |     new ContactImport($request->group_id),
        |     $request->file('contacts_file')
        | );
        |
        */

        return redirect()
            ->route('user.contacts.import.create')
            ->with('success', 'Contacts imported successfully.');
    }

    public function createImport()
    {
        $groups = Group::where('user_id', Auth::id())
            ->where('status', 1)
            ->orderBy('group_name')
            ->get();

        return view('frontend.user.contacts.import', compact('groups'));
    }

    public function import(Request $request, EmailVerifier $verifier)
    {
        $request->validate([
            'group_id' => [
                'required',
                'integer',
                'exists:contact_groups,id',
            ],
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify group belongs to logged-in user
        |--------------------------------------------------------------------------
        */

        $group = Group::where('id', $request->group_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $groupId = $group->id;


        /*
        |--------------------------------------------------------------------------
        | Read spreadsheet
        |--------------------------------------------------------------------------
        */

        $spreadsheet = IOFactory::load(
            $request->file('file')->getRealPath()
        );

        $rows = $spreadsheet
            ->getActiveSheet()
            ->toArray();


        $count = 0;
        $skipped = 0;
        $invalid = 0;


        /*
        |--------------------------------------------------------------------------
        | Import contacts
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $index => $row) {

            /*
            |--------------------------------------------------------------------------
            | Skip header row
            |--------------------------------------------------------------------------
            */

            if ($index === 0) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Get email
            |--------------------------------------------------------------------------
            */

            $email = strtolower(trim($row[4] ?? ''));


            /*
            |--------------------------------------------------------------------------
            | Skip blank email
            |--------------------------------------------------------------------------
            */

            if (empty($email)) {
                $skipped++;
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Find existing contact
            |--------------------------------------------------------------------------
            */

            $contact = Contact::where('user_id', Auth::id())
                ->whereRaw(
                    'LOWER(contact_email) = ?',
                    [$email]
                )
                ->first();


            /*
            |--------------------------------------------------------------------------
            | EXISTING CONTACT
            |--------------------------------------------------------------------------
            |
            | If contact already exists, do NOT create or update it.
            | Just attach it to this group.
            |
            */

            if ($contact) {

                /*
                | Check whether already in this group
                */

                $alreadyInGroup = $contact->groups()
                    ->where('contact_groups.id', $groupId)
                    ->exists();


                if ($alreadyInGroup) {

                    $skipped++;

                    continue;
                }


                /*
                | Attach existing contact to new group
                */

                $contact->groups()->syncWithoutDetaching([
                    $groupId
                ]);

                $count++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | NEW CONTACT
            |--------------------------------------------------------------------------
            |
            | Verify email before creating contact.
            |
            */

            $emailStatus = 'invalid';
            $contactStatus = 0;
            $userStatus = 'opt-out';


            try {

                $verification = $verifier->verify($email);


                /*
                |--------------------------------------------------------------------------
                | Only "valid" emails are treated as valid
                |--------------------------------------------------------------------------
                */

                if ($verification->status === 'valid') {

                    $emailStatus = 'valid';

                    $contactStatus = 1;

                    $userStatus = 'opt-in';
                }

            } catch (\Throwable $e) {

                /*
                |--------------------------------------------------------------------------
                | Verification failed technically
                |--------------------------------------------------------------------------
                */

                Log::error('Email verification failed during import', [
                    'email' => $email,
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage(),
                ]);

                $emailStatus = 'invalid';

                $contactStatus = 0;

                $userStatus = 'opt-out';
            }


            /*
            |--------------------------------------------------------------------------
            | Create NEW contact
            |--------------------------------------------------------------------------
            */

            $contact = Contact::create([

                'user_id' => Auth::id(),

                'contact_first_name' =>
                    trim($row[0] ?? ''),

                'contact_last_name' =>
                    trim($row[1] ?? ''),

                'contact_company_name' =>
                    trim($row[2] ?? ''),

                'contact_address' =>
                    trim($row[3] ?? ''),

                'contact_email' =>
                    $email,

                'contact_phone' =>
                    trim($row[5] ?? ''),

                'status' =>
                    $contactStatus,

                'user_status' =>
                    $userStatus,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Attach new contact to group
            |--------------------------------------------------------------------------
            */

            $contact->groups()->syncWithoutDetaching([
                $groupId
            ]);


            /*
            |--------------------------------------------------------------------------
            | Count result
            |--------------------------------------------------------------------------
            */

            $count++;

            if ($emailStatus !== 'valid') {
                $invalid++;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        $message = "{$count} contacts imported successfully.";

        if ($invalid > 0) {

            $message .=
                " {$invalid} contacts have invalid/unverified email addresses.";
        }


        return redirect()
            ->route('user.groups.index')
            ->with(
                'success',
                $message
            );
    }

    public function import1111(Request $request)
    {
        $request->validate([
            'group_id' => [
                'required',
                'integer',
                'exists:contact_groups,id',
            ],
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Verify group belongs to logged-in user
        |--------------------------------------------------------------------------
        */

        $group = Group::where('id', $request->group_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $groupId = $group->id;


        /*
        |--------------------------------------------------------------------------
        | Read spreadsheet
        |--------------------------------------------------------------------------
        */

        $spreadsheet = IOFactory::load(
            $request->file('file')->getRealPath()
        );

        $rows = $spreadsheet
            ->getActiveSheet()
            ->toArray();


        $count = 0;
        $skipped = 0;


        /*
        |--------------------------------------------------------------------------
        | Import contacts
        |--------------------------------------------------------------------------
        */

        foreach ($rows as $index => $row) {

            /*
            |--------------------------------------------------------------------------
            | Skip header row
            |--------------------------------------------------------------------------
            |
            | If your Excel file has a header row, skip row 0.
            |
            */

            if ($index === 0) {
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Skip blank rows
            |--------------------------------------------------------------------------
            */

            $email = strtolower(trim($row[4] ?? ''));

            if (empty($email)) {
                $skipped++;
                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Find existing contact for this user
            |--------------------------------------------------------------------------
            */

            $contact = Contact::where('user_id', Auth::id())
                ->whereRaw('LOWER(contact_email) = ?', [$email])
                ->first();


            /*
            |--------------------------------------------------------------------------
            | Create contact if it doesn't exist
            |--------------------------------------------------------------------------
            */

            if (!$contact) {

                $contact = Contact::create([

                    'user_id' => Auth::id(),

                    'contact_first_name' =>
                        trim($row[0] ?? ''),

                    'contact_last_name' =>
                        trim($row[1] ?? ''),

                    'contact_company_name' =>
                        trim($row[2] ?? ''),

                    'contact_address' =>
                        trim($row[3] ?? ''),

                    'contact_email' =>
                        $email,

                    'contact_phone' =>
                        trim($row[5] ?? ''),

                    'status' => 1,

                    'user_status' => 'opt-in',
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | Check if contact already belongs to this group
            |--------------------------------------------------------------------------
            */

            $alreadyInGroup = $contact->groups()
                ->where('contact_groups.id', $groupId)
                ->exists();


            if ($alreadyInGroup) {

                $skipped++;

                continue;
            }


            /*
            |--------------------------------------------------------------------------
            | Attach contact to group
            |--------------------------------------------------------------------------
            */

            $contact->groups()->syncWithoutDetaching([
                $groupId
            ]);


            $count++;
        }


        /*
        |--------------------------------------------------------------------------
        | Response
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('user.groups.index')
            ->with(
                'success',
                "{$count} contacts imported successfully."
            );
    }


    public function storeImport(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:contact_groups,id',
            'file' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        DB::beginTransaction();

        try {

            $spreadsheet = IOFactory::load($request->file('file'));

            $rows = $spreadsheet
                ->getActiveSheet()
                ->toArray();

            $imported = 0;

            foreach ($rows as $row) {

                if(empty($row[4])) {
                    continue;
                }

                Contact::updateOrCreate(

                    [
                        'user_id' => auth()->id(),
                        'email'   => trim($row[4]),
                    ],

                    [
                        'group_id'   => $request->group_id,
                        'first_name' => trim($row[0]),
                        'last_name'  => trim($row[1]),
                        'company'    => trim($row[2]),
                        'city'       => trim($row[3]),
                        'phone'      => trim($row[5]),
                        'status'     => 1,
                    ]

                );

                $imported++;

            }

            DB::commit();

            return back()->with(
                'success',
                "{$imported} contacts imported successfully."
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /**
     * Export contacts.
     */
    public function export()
    {
        //
    }

    /**
     * Show Edit Contact page.
     */
    public function edit(Contact $contact)
    {
        abort_if($contact->user_id != auth()->id(),403);

        $groups = Group::where('user_id',auth()->id())
            ->where('status',1)
            ->get();

        return view(
            'frontend.user.contacts.edit',
            compact(
                'contact',
                'groups'
            )
        );
    }

    /**
     * Update Contact.
     */
    public function update(Request $request, Contact $contact)
    {
        abort_if($contact->user_id != auth()->id(),403);

        $request->validate([

            'group_id'=>'required',

            'contact_first_name'=>'required',

            'contact_email'=>'required|email',

        ]);

        $contact->update([

            'group_id'=>$request->group_id,

            'contact_first_name'=>$request->contact_first_name,

            'contact_last_name'=>$request->contact_last_name,

            'contact_company_name'=>$request->contact_company_name,

            'contact_address'=>$request->contact_address,

            'area_interest'=>$request->area_interest,

            'contact_email'=>$request->contact_email,

            'contact_phone'=>$request->contact_phone,

        ]);

        return redirect()

            ->route('user.groups.contacts.index',$contact->group_id)

            ->with('success','Contact updated successfully.');
    }

    /**
     * Delete Contact.
     */
    public function destroy(Contact $contact)
    {
        abort_if($contact->user_id != auth()->id(),403);

        $groupId = $contact->group_id;

        $contact->delete();

        return redirect()

            ->route('user.groups.contacts.index',$groupId)

            ->with('success','Contact deleted successfully.');
    }

    public function activate(Request $request)
    {
        Contact::where('user_id',auth()->id())

            ->whereIn('id',$request->contact_ids ?? [])

            ->update([
                'status'=>1
            ]);

        return back()->with('success','Contacts activated.');
    }

    public function deactivate(Request $request)
    {
        Contact::where('user_id',auth()->id())

            ->whereIn('id',$request->contact_ids ?? [])

            ->update([
                'status'=>0
            ]);

        return back()->with('success','Contacts deactivated.');
    }

    public function bulkDelete(Request $request)
    {
        Contact::where('user_id',auth()->id())

            ->whereIn('id',$request->contact_ids ?? [])

            ->delete();

        return back()->with('success','Contacts deleted successfully.');
    }

    public function assignContacts()
    {
        $userId = auth()->id();

        $contacts = Contact::with('groups')
            ->where('user_id', $userId)
            ->whereNotNull('contact_email')
            ->latest()
            ->paginate(20);

        $groups = Group::where('user_id', $userId)
            ->where('status', 1)
            ->orderBy('group_name')
            ->get();

        return view(
            'frontend.user.contacts.assign_contacts',
            compact('contacts', 'groups')
        );
    }

    public function assignContactsStore(Request $request)
    {
        $request->validate([
            'action' => 'required|in:assign,delete',
            'contact_ids' => 'required|array|min:1',
            'contact_ids.*' => 'integer',
        ]);


        $userId = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | Delete Contacts
        |--------------------------------------------------------------------------
        */

        if ($request->action === 'delete') {

            $contacts = Contact::where('user_id', $userId)
                ->whereIn('id', $request->contact_ids)
                ->get();

            foreach ($contacts as $contact) {

                // Remove group relationships first
                $contact->groups()->detach();

                // Delete contact
                $contact->delete();
            }

            return back()->with(
                'success',
                'Selected contacts have been deleted successfully.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Assign Contacts
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'group_ids' => 'required|array|min:1',
            'group_ids.*' => 'integer',
        ]);


        /*
        * Make sure selected groups belong
        * to the logged-in user.
        */
        $groupIds = Group::where('user_id', $userId)
            ->whereIn('id', $request->group_ids)
            ->pluck('id')
            ->toArray();


        if (empty($groupIds)) {

            return back()
                ->withErrors([
                    'group_ids' => 'Please select a valid Contact Group.',
                ])
                ->withInput();
        }


        /*
        * Get only contacts belonging to
        * the logged-in user.
        */
        $contacts = Contact::where('user_id', $userId)
            ->whereIn('id', $request->contact_ids)
            ->get();


        foreach ($contacts as $contact) {

            /*
            * syncWithoutDetaching means:
            *
            * Existing groups remain.
            * New selected groups are added.
            */
            $contact->groups()->syncWithoutDetaching($groupIds);
        }


        return back()->with(
            'success',
            'Selected contacts have been assigned to the selected groups successfully.'
        );
    }

    public function badContactsReport()
    {
        $userId = auth()->id();

        $reports = BadMailCategory::where('user_id', $userId)
            ->where('status', 'y')
            ->withCount('badContacts')
            ->latest('upload_date')
            ->paginate(20);

        return view(
            'frontend.user.contacts.bad_contacts',
            compact('reports')
        );
    }

    public function badContactsDetails(BadMailCategory $report)
    {
        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        */

        abort_if(
            $report->user_id !== auth()->id(),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Rejected Contacts
        |--------------------------------------------------------------------------
        */

        $badContacts = $report->badContacts()
            ->latest()
            ->paginate(25);


        return view(
            'frontend.user.contacts.bad_contacts_details',
            compact(
                'report',
                'badContacts'
            )
        );
    }

    public function deleteBadContactReports(Request $request)
    {
        $request->validate([
            'report_ids' => [
                'required',
                'array',
                'min:1',
            ],

            'report_ids.*' => [
                'integer',
            ],
        ]);


        $userId = auth()->id();


        /*
        |--------------------------------------------------------------------------
        | Only delete user's own reports
        |--------------------------------------------------------------------------
        */

        $reports = BadMailCategory::where('user_id', $userId)
            ->whereIn('id', $request->report_ids)
            ->get();


        foreach ($reports as $report) {

            /*
            |--------------------------------------------------------------------------
            | Delete rejected contacts
            |--------------------------------------------------------------------------
            */

            $report->badContacts()->delete();


            /*
            |--------------------------------------------------------------------------
            | Delete report
            |--------------------------------------------------------------------------
            */

            $report->delete();
        }


        return redirect()
            ->route('user.contacts.bad-report')
            ->with(
                'success',
                'Selected bad contact reports have been deleted successfully.'
            );
    }

    public function unsubscribe(Contact $contact)
    {
        $contact->update([
            'user_status' => 'opt-out',
            'status' => 0,
        ]);

        return view(
            'frontend.user.contacts.unsubscribe',
            compact('contact')
        );
    }
    
}