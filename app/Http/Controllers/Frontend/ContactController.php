<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display contacts.
     */
    public function index()
    {
        //
    }

    /**
     * Show Add Contact form.
     */
    public function create()
    {
        //
    }

    /**
     * Store manually added contact.
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update Contact.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Delete Contact.
     */
    public function destroy($id)
    {
        //
    }
}