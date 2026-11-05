<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactQueryController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('contact_messages'); // Assuming your table name is 'contacts'

        // Handle Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('organization', 'LIKE', "%{$search}%");
            });
        }

        $queries = $query->latest()->paginate(10);

        return view('admin.contact_queries.index', compact('queries'));
    }

    public function destroy($id)
    {
        DB::table('contact_messages')->where('id', $id)->delete();
        return redirect()->route('admin.contact-queries.index')->with('success', 'Contact query deleted successfully!');
    }

    public function advanceFormEnqueries(Request $request)
    {
        $query = DB::table('contact_enquiries')
            ->leftJoin('mail_campaign', 'contact_enquiries.campaign_id', '=', 'mail_campaign.id')
            ->leftJoin('users', 'mail_campaign.user_id', '=', 'users.id')
            ->select(
                'contact_enquiries.*',
                'mail_campaign.email_title as campaign_name',
                'users.name as user_name',
                'users.email as user_email'
            );

       
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('contact_enquiries.first_name', 'LIKE', "%{$search}%")
                    ->orWhere('contact_enquiries.last_name', 'LIKE', "%{$search}%")
                    ->orWhere('contact_enquiries.email', 'LIKE', "%{$search}%")
                    ->orWhere('mail_campaign.email_title', 'LIKE', "%{$search}%")
                    ->orWhere('users.name', 'LIKE', "%{$search}%");
            });
        }

        $queries = $query->orderBy('contact_enquiries.created_at', 'desc')->paginate(10);

        return view('admin.advance_form.index', compact('queries'));
    }
}