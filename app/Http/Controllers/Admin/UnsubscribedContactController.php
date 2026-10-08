<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnsubscribedContactController extends Controller
{
    /**
     * Display unsubscribed contacts.
     */
    public function index()
    {
        $contacts = DB::table('contact_lists')
            ->where('status', 1)
            ->where('user_status', 'opt-out')
            ->orderByDesc('updated_at')
            ->paginate(8);

        return view('admin.unsubscribed-contacts.index', compact('contacts'));
    }

    /**
     * Subscribe a contact again.
     */
    public function subscribe($id)
    {
        $contact = DB::table('contact_lists')
            ->where('id', $id)
            ->where('status', 1)
            ->where('user_status', 'opt-out')
            ->first();

        if (!$contact) {
            return redirect()
                ->route('unsubscribed-contacts.index')
                ->with('error', 'Contact not found or already subscribed.');
        }

        DB::table('contact_lists')
            ->where('id', $id)
            ->update([
                'user_status' => 'opt-in',
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('unsubscribed-contacts.index')
            ->with('success', $contact->contact_email . ' has been subscribed successfully.');
    }
}