<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;
use App\Models\ContactList;

class ContactController extends Controller
{
    /**
     * Display contacts.
     */
    public function index(Group $group)
    {
        abort_if($group->user_id != auth()->id(), 403);

        $contacts = ContactList::where('group_id', $group->id)
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

    public function import(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:contact_groups,id',
            'file'     => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $spreadsheet = IOFactory::load($request->file('file'));

        $rows = $spreadsheet
                    ->getActiveSheet()
                    ->toArray();

        $count = 0;

        foreach ($rows as $index => $row) {

            // Skip blank rows
            if (empty($row[4])) {
                continue;
            }

            // Skip duplicate email in same user's contacts
            $exists = Contact::where('user_id', Auth::id())
                        ->where('contact_email', trim($row[4]))
                        ->exists();

            if ($exists) {
                continue;
            }

            Contact::create([

                'user_id' => Auth::id(),

                'group_id' => $request->group_id,

                'contact_first_name' => trim($row[0]),

                'contact_last_name' => trim($row[1]),

                'contact_company_name' => trim($row[2]),

                'contact_address' => trim($row[3]),

                'contact_email' => trim($row[4]),

                'contact_phone' => trim($row[5]),

                'status' => 1,

                'user_status' => 'opt-in',
            ]);

            $count++;
        }

        return redirect()
                ->route('user.groups.index')
                ->with('success', "{$count} contacts imported successfully.");
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
}