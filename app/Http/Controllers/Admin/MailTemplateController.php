<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $query = MailTemplate::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('mail_template_name', 'like', "%{$searchTerm}%");
        }

        $templates = $query->latest()->paginate(10);
        return view('admin.email_templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.email_templates.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mail_template_name' => 'required|string|max:255|unique:mail_templates,mail_template_name',
            'mail_template_content' => 'required|string',
            'mail_template_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Active,Deactive',
        ]);

        try {
            if ($request->hasFile('mail_template_image')) {
                $validated['mail_template_image'] = $request->file('mail_template_image')->store('email_templates', 'public');
            }

            MailTemplate::create($validated);
            return redirect()->route('email-templates.index')->with('success', 'Email Template created successfully!');
        } catch (\Exception $e) {
            Log::error('Template Creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating template.')->withInput();
        }
    }

    public function edit($id)
    {
        $template = MailTemplate::findOrFail($id);
        return view('admin.email_templates.form', compact('template'));
    }

    public function update(Request $request, $id)
    {
        $template = MailTemplate::findOrFail($id);

        $validated = $request->validate([
            'mail_template_name' => 'required|string|max:255|unique:mail_templates,mail_template_name,' . $template->id,
            'mail_template_content' => 'required|string',
            'mail_template_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:Active,Deactive',
        ]);

        try {
            if ($request->hasFile('mail_template_image')) {
                if ($template->mail_template_image) {
                    Storage::disk('public')->delete($template->mail_template_image);
                }
                $validated['mail_template_image'] = $request->file('mail_template_image')->store('email_templates', 'public');
            }

            $template->update($validated);
            return redirect()->route('email-templates.index')->with('success', 'Email Template updated successfully!');
        } catch (\Exception $e) {
            Log::error('Template Update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating template.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $template = MailTemplate::findOrFail($id);
            if ($template->mail_template_image) {
                Storage::disk('public')->delete($template->mail_template_image);
            }
            $template->delete();
            return redirect()->route('email-templates.index')->with('success', 'Email Template deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting template: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}
