<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use PhpOffice\PhpSpreadsheet\IOFactory;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use Throwable;
use Illuminate\Support\Facades\Storage; // <-- Add this line


use Illuminate\Support\Facades\DB;
use App\Models\BadMailCategory;
use App\Models\BadMailList;
use App\Models\MailCampaign;
use App\Models\CampaignRecipient;
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

            // if ($index === 0) {
            //     continue;
            // }


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


        // return redirect()
        //     ->route('user.groups.index')
        //     ->with(
        //         'success',
        //         $message
        //     );
        return redirect()
            ->route('user.groups.contacts.index', ['group' => $group->id])
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
    // public function update(Request $request, Contact $contact)
    // {
    //     abort_if($contact->user_id != auth()->id(),403);

    //     $request->validate([

    //         'group_id'=>'required',

    //         'contact_first_name'=>'required',

    //         'contact_email'=>'required|email',

    //     ]);

    //     $contact->update([

    //         'group_id'=>$request->group_id,

    //         'contact_first_name'=>$request->contact_first_name,

    //         'contact_last_name'=>$request->contact_last_name,

    //         'contact_company_name'=>$request->contact_company_name,

    //         'contact_address'=>$request->contact_address,

    //         'area_interest'=>$request->area_interest,

    //         'contact_email'=>$request->contact_email,

    //         'contact_phone'=>$request->contact_phone,

    //     ]);

    //     return redirect()

    //         //->route('user.groups.contacts.index',$contact->group_id)
    //         ->route('user.groups.contacts.index', ['group' => $contact->group_id])
    //         ->with('success','Contact updated successfully.');
    // }

    // public function update(Request $request, Contact $contact)
    // {
    //     abort_if($contact->user_id != auth()->id(), 403);

    //     $request->validate([
    //         'group_id' => 'required|exists:groups,id',
    //         'contact_first_name' => 'required',
    //         'contact_email' => 'required|email',
    //     ]);

    //     $contact->update([
    //         'contact_first_name' => $request->contact_first_name,
    //         'contact_last_name' => $request->contact_last_name,
    //         'contact_company_name' => $request->contact_company_name,
    //         'contact_address' => $request->contact_address,
    //         'area_interest' => $request->area_interest,
    //         'contact_email' => $request->contact_email,
    //         'contact_phone' => $request->contact_phone,
    //     ]);

    //     // Update contact_group pivot
    //     $contact->groups()->sync([
    //         $request->group_id
    //     ]);

    //     return redirect()
    //         ->route(
    //             'user.groups.contacts.index',
    //             ['group' => $request->group_id]
    //         )
    //         ->with('success', 'Contact updated successfully.');
    // }
    public function update(Request $request, Group $group, Contact $contact)
    {
        abort_if($contact->user_id != auth()->id(), 403);

        $request->validate([
            //'group_id' => 'required',
            'group_id' => ['required', 'array', 'min:1'],
            'group_id.*' => 'exists:contact_groups,id',

            'contact_first_name' => 'required',
            'contact_email' => 'required|email',
        ]);

        $contact->update([
            'contact_first_name' => $request->contact_first_name,
            'contact_last_name' => $request->contact_last_name,
            'contact_company_name' => $request->contact_company_name,
            'contact_address' => $request->contact_address,
            'area_interest' => $request->area_interest,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
        ]);

        // Update contact_group pivot table
        $contact->groups()->sync($request->group_id);

        if ($request->filled('return_group_id')) {

            $redirect = redirect()->route(
                'user.groups.contacts.index',
                ['group' => $request->return_group_id]
            );

        } else {

            $redirect = redirect()->route(
                'user.contacts.assign'
            );
        }

        return $redirect->with(
            'success',
            'Contact updated successfully.'
        );

        // $returnGroupId = $request->return_group_id;
        // // Redirect to first selected group
        // return redirect()
        //     ->route(
        //         'user.groups.contacts.index',
        //         ['group' => $returnGroupId]
        //     )
        //     ->with('success', 'Contact updated successfully.');
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

    // public function unsubscribe(Contact $contact)
    // {
    //     $contact->update([
    //         'user_status' => 'opt-out',
    //         'status' => 1,
    //     ]);

    //     // Update campaign recipient records
    //     DB::table('campaign_recipients')
    //         ->where('contact_id', $contact->id)
    //         ->update([
    //             'status' => 'unsubscribed',
    //             'updated_at' => now(),
    //         ]);

    //     return view(
    //         'frontend.user.contacts.unsubscribe',
    //         compact('contact')
    //     );
    // }

    public function unsubscribe(Contact $contact)
    {
        DB::transaction(function () use ($contact) {

            // Global unsubscribe
            $contact->update([
                'user_status' => 'opt-out',
                'status' => 1,
            ]);

            // Mark this contact as unsubscribed
            // in every campaign where they are a recipient
            DB::table('campaign_recipients')
                ->where('contact_id', $contact->id)
                ->update([
                    'status' => 'unsubscribed',
                    'updated_at' => now(),
                ]);
        });

        return view(
            'frontend.user.contacts.unsubscribe',
            compact('contact')
        );
    }

    
    
    public function PostVerify(Request $request, EmailVerifier $verifier)
    {
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:254',
            ],
        ], [
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.max' => 'Email address cannot exceed 254 characters.',
        ]);

        try {
            $email = strtolower(trim($validated['email']));

            $verification = $verifier->verify($email);

            return redirect()
                ->route('email.verification')
                ->with('verification', [
                    'email'          => $verification->email,
                    'status'         => $verification->status,
                    'syntax_valid'   => $verification->syntax_valid,
                    'domain_exists'  => $verification->domain_exists,
                    'mx_exists'      => $verification->mx_exists,
                    'smtp_status'    => $verification->smtp_status,
                    'smtp_code'      => $verification->smtp_code,
                    'mx_host'        => $verification->mx_host,
                    'message'        => $verification->message,
                ]);

        } catch (Throwable $e) {

            \Log::error('Email verification failed', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Unable to verify the email address. Please try again.');
        }
    }
    public function verify_email()
    {
        return view('frontend.pages.email-verify');
    }
    public function usersValidateEmails()
    {
        return view('frontend.user.email-validate.index');
    }
    public function postUserEmailvalidate(Request $request,EmailVerifier $verifier) 
    {
        $request->validate([
            'email' => [
                'nullable',
                'email',
                'max:254',
                'required_without:email_file',
            ],

            'email_file' => [
                'nullable',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
                'required_without:email',
            ],
        ], [
            'email.required_without' =>
                'Please enter an email address or upload an Excel file.',

            'email_file.required_without' =>
                'Please enter an email address or upload an Excel file.',

            'email_file.mimes' =>
                'Please upload an XLSX, XLS or CSV file.',

            'email_file.max' =>
                'The Excel file cannot be larger than 10 MB.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Do not allow both
        |--------------------------------------------------------------------------
        */

        if ($request->filled('email') && $request->hasFile('email_file')) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Please enter either a single email or upload an Excel file, not both.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | SINGLE EMAIL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('email')) {

            try {

                $email = strtolower(trim($request->email));

                $verification = $verifier->verify($email);

                return redirect()
                    ->route('user.verification.email')
                    ->with('single_result', [
                        'email' => $verification->email,
                        'status' => $verification->status,
                        'syntax_valid' => $verification->syntax_valid,
                        'domain_exists' => $verification->domain_exists,
                        'mx_exists' => $verification->mx_exists,
                        'smtp_status' => $verification->smtp_status,
                        'smtp_code' => $verification->smtp_code,
                        'message' => $verification->message,
                    ]);

            } catch (Throwable $e) {

                Log::error(
                    'Single email verification failed',
                    [
                        'email' => $request->email,
                        'error' => $e->getMessage(),
                    ]
                );

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        'Unable to verify the email address.'
                    );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EXCEL FILE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('email_file')) {

            try {

                /*
                |--------------------------------------------------------------------------
                | Load uploaded spreadsheet
                |--------------------------------------------------------------------------
                */

                $spreadsheet = IOFactory::load(
                    $request->file('email_file')->getRealPath()
                );

                $sheet = $spreadsheet->getActiveSheet();

                $rows = $sheet->toArray(
                    null,
                    true,
                    true,
                    false
                );

                if (empty($rows)) {
                    return back()->with(
                        'error',
                        'The uploaded Excel file is empty.'
                    );
                }

                /*
                |--------------------------------------------------------------------------
                | Create result spreadsheet
                |--------------------------------------------------------------------------
                */

                $resultSpreadsheet = new Spreadsheet();

                $resultSheet = $resultSpreadsheet->getActiveSheet();

                $resultSheet->setTitle('Verification Results');

                /*
                |--------------------------------------------------------------------------
                | Headers
                |--------------------------------------------------------------------------
                */

                $headers = [
                    'First Name',
                    'Last Name',
                    'Company',
                    'City',
                    'Email',
                    'Phone',
                    'Status',
                    'SMTP Status',
                    'SMTP Code',
                    'Message',
                ];

                $resultSheet->fromArray(
                    $headers,
                    null,
                    'A1'
                );

                /*
                |--------------------------------------------------------------------------
                | Header styling
                |--------------------------------------------------------------------------
                */

                $resultSheet
                    ->getStyle('A1:J1')
                    ->getFont()
                    ->setBold(true);

                /*
                |--------------------------------------------------------------------------
                | Highlight verification headers
                |--------------------------------------------------------------------------
                */

                $resultSheet
                    ->getStyle('G1:J1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('FFFFC000');

                /*
                |--------------------------------------------------------------------------
                | Process rows
                |--------------------------------------------------------------------------
                */

                $outputRow = 2;

                foreach ($rows as $index => $row) {

                    /*
                    |--------------------------------------------------------------------------
                    | Get email from 5th column
                    |--------------------------------------------------------------------------
                    |
                    | Excel:
                    |
                    | 0 = First Name
                    | 1 = Last Name
                    | 2 = Company
                    | 3 = City
                    | 4 = Email
                    | 5 = Phone
                    |
                    */

                    $email = strtolower(
                        trim(
                            (string) ($row[4] ?? '')
                        )
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Original six columns
                    |--------------------------------------------------------------------------
                    */

                    $firstName = $row[0] ?? '';
                    $lastName  = $row[1] ?? '';
                    $company   = $row[2] ?? '';
                    $city      = $row[3] ?? '';
                    $phone     = $row[5] ?? '';

                    /*
                    |--------------------------------------------------------------------------
                    | Empty email
                    |--------------------------------------------------------------------------
                    */

                    if ($email === '') {

                        $status = 'invalid';
                        $smtpStatus = 'skipped';
                        $smtpCode = '';
                        $message = 'Email address is empty.';

                    } else {

                        try {

                            $verification = $verifier->verify($email);

                            $status = $verification->status;
                            $smtpStatus = $verification->smtp_status;
                            $smtpCode = $verification->smtp_code;
                            $message = $verification->message;

                        } catch (Throwable $e) {

                            Log::error(
                                'Bulk email verification failed',
                                [
                                    'email' => $email,
                                    'error' => $e->getMessage(),
                                ]
                            );

                            $status = 'unknown';
                            $smtpStatus = 'error';
                            $smtpCode = '';
                            $message = 'Verification failed.';
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Write original data + verification result
                    |--------------------------------------------------------------------------
                    */

                    $resultSheet->fromArray(
                        [
                            $firstName,
                            $lastName,
                            $company,
                            $city,
                            $email,
                            $phone,
                            $status,
                            $smtpStatus,
                            $smtpCode,
                            $message,
                        ],
                        null,
                        'A' . $outputRow
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Highlight verification columns
                    |--------------------------------------------------------------------------
                    */

                    $resultSheet
                        ->getStyle("G{$outputRow}:J{$outputRow}")
                        ->getFill()
                        ->setFillType(Fill::FILL_SOLID)
                        ->getStartColor()
                        ->setARGB(
                            match ($status) {
                                'valid' => 'FFC6EFCE',
                                'invalid' => 'FFFFC7CE',
                                'catch_all' => 'FFFFEB9C',
                                default => 'FFE7E6E6',
                            }
                        );

                    /*
                    |--------------------------------------------------------------------------
                    | Make status bold
                    |--------------------------------------------------------------------------
                    */

                    $resultSheet
                        ->getStyle("G{$outputRow}")
                        ->getFont()
                        ->setBold(true);

                    $outputRow++;
                }

                /*
                |--------------------------------------------------------------------------
                | Auto-size columns
                |--------------------------------------------------------------------------
                */

                foreach (range('A', 'J') as $column) {
                    $resultSheet
                        ->getColumnDimension($column)
                        ->setAutoSize(true);
                }

                /*
                |--------------------------------------------------------------------------
                | Limit very wide message column
                |--------------------------------------------------------------------------
                */

                $resultSheet
                    ->getColumnDimension('J')
                    ->setWidth(45);

                $resultSheet
                    ->getStyle('J:J')
                    ->getAlignment()
                    ->setWrapText(true);

                /*
                |--------------------------------------------------------------------------
                | Freeze header
                |--------------------------------------------------------------------------
                */

                $resultSheet->freezePane('A2');

                /*
                |--------------------------------------------------------------------------
                | Create result directory
                |--------------------------------------------------------------------------
                */

                $directory = 'email-verification-results';

                if (!Storage::disk('local')->exists($directory)) {
                    \Storage::disk('local')->makeDirectory($directory);
                }

                /*
                |--------------------------------------------------------------------------
                | Generate unique file name
                |--------------------------------------------------------------------------
                */

                $fileName =
                    'email-verification-' .
                    now()->format('Y-m-d-H-i-s') .
                    '-' .
                    uniqid() .
                    '.xlsx';

                $filePath = storage_path(
                    'app/private/' . $directory . '/' . $fileName
                );

                /*
                |--------------------------------------------------------------------------
                | Save result Excel
                |--------------------------------------------------------------------------
                */

                $writer = new Xlsx($resultSpreadsheet);

                $writer->save($filePath);

                /*
                |--------------------------------------------------------------------------
                | Only store filename in session
                |--------------------------------------------------------------------------
                */

                return redirect()
                    ->route('user.verification.email')
                    ->with(
                        'bulk_result_file',
                        $fileName
                    );

            } catch (Throwable $e) {

                Log::error(
                    'Excel email verification failed',
                    [
                        'error' => $e->getMessage(),
                    ]
                );

                return back()->with(
                    'error',
                    'Unable to process the Excel file.'
                );
            }
        }

        return back()->with(
            'error',
            'Please enter an email or upload an Excel file.'
        );
    }
    public function downloadResult($fileName)
    {
        /*
        |--------------------------------------------------------------------------
        | Security: allow only generated XLSX filenames
        |--------------------------------------------------------------------------
        */

        if (!preg_match(
            '/^email-verification-[0-9\-]+-[a-zA-Z0-9]+\.xlsx$/',
            $fileName
        )) {
            abort(404);
        }

        $filePath = storage_path(
            'app/private/email-verification-results/' . $fileName
        );

        if (!file_exists($filePath)) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Download and delete after sending
        |--------------------------------------------------------------------------
        */

        return response()
            ->download(
                $filePath,
                $fileName,
                [
                    'Content-Type' =>
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                ]
            )
            ->deleteFileAfterSend(true);
    }

    public function forward(Request $request, CampaignRecipient $recipient)
    {
        return view('frontend.pages.forward', compact(
            'recipient',
            'request'
        ));
    }

    public function sendForward(Request $request, CampaignRecipient $recipient)
    {
        $validated = $request->validate([
            'first_name'   => ['required', 'string', 'max:100'],
            'last_name'    => ['required', 'string', 'max:100'],
            'friend_email' => ['required', 'email', 'max:255'],
            'message'      => ['nullable', 'string', 'max:2000'],
        ]);

        // Get campaign
        $campaign = MailCampaign::findOrFail($recipient->campaign_id);

        // Your email sending logic will go here.

        return back()->with(
            'success',
            'Email has been forwarded successfully.'
        );
    }
    
}