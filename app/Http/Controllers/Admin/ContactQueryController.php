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
        DB::table('contacts')->where('id', $id)->delete();
        return redirect()->route('admin.contact-queries.index')->with('success', 'Contact query deleted successfully!');
    }
}