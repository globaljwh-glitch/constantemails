<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SaveTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserTemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = SaveTemplate::with('user');

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('template_title', 'like', "%{$searchTerm}%");
        }

        $templates = $query->latest()->paginate(10);
        return view('admin.user_templates.index', compact('templates'));
    }

    public function create()
    {
        $users = User::where('is_admin', 0)->get(); // Fetch regular users for dropdown
        return view('admin.user_templates.form', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_title' => 'required|string|max:255',
            'template_content' => 'required|string',
            'user_id' => 'nullable|exists:users,id', // null means for all users
            'status' => 'required|in:Active,Deactive',
        ]);

        try {
            SaveTemplate::create([
                'user_id' => $validated['user_id'] ?? null,
                'template_title' => $validated['template_title'],
                'template_content' => $validated['template_content'],
                'status' => $validated['status'],
                'session_id' => session()->getId(),
            ]);

            return redirect()->route('admin.user-templates.index')->with('success', 'User Template created successfully!');
        } catch (\Exception $e) {
            Log::error('User Template Creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating user template.')->withInput();
        }
    }

    public function edit($id)
    {
        $template = SaveTemplate::findOrFail($id);
        $users = User::where('is_admin', 0)->get();
        return view('admin.user_templates.form', compact('template', 'users'));
    }

    public function update(Request $request, $id)
    {
        $template = SaveTemplate::findOrFail($id);

        $validated = $request->validate([
            'template_title' => 'required|string|max:255',
            'template_content' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'status' => 'required|in:Active,Deactive',
        ]);

        try {
            $template->update([
                'user_id' => $validated['user_id'] ?? null,
                'template_title' => $validated['template_title'],
                'template_content' => $validated['template_content'],
                'status' => $validated['status'],
            ]);

            return redirect()->route('admin.user-templates.index')->with('success', 'User Template updated successfully!');
        } catch (\Exception $e) {
            Log::error('User Template Update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating user template.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $template = SaveTemplate::findOrFail($id);
            $template->delete();
            return redirect()->route('admin.user-templates.index')->with('success', 'User Template deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting user template: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}