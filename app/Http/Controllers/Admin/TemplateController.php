<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Template;
use App\Models\TemplateCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        // Start the query and include the category relationship
        $query = \App\Models\Template::with('category');

        // 1. FILTER BY CATEGORY (This is what makes your View button work!)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 2. Filter by Search Bar
        if ($request->filled('search')) {
            $searchTerm = $request->search;

            // Use a grouped where clause so the search doesn't override the category filter
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', function ($subQ) use ($searchTerm) {
                        $subQ->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Fetch templates with pagination
        $templates = $query->latest()->paginate(10);

        // Return your all-templates view
        return view('admin.templates.all-templates', compact('templates'));
    }

    // 2. SHOW CREATE FORM
    public function create()
    {
        $categories = TemplateCategory::where('status', 'Active')->get();
        return view('admin.templates.create-template', compact('categories'));
    }

    // 3. STORE NEW TEMPLATE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:template_categories,id',
            'name' => 'required|string|max:255|unique:templates,name',
            'content' => 'required|string',
            'status' => 'required|in:Active,Deactive',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=140,min_height=200|max:2048',
        ]);

        try {
            if ($request->hasFile('thumbnail')) {
                $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            Template::create($validated);
            return redirect()->route('templates.index')->with('success', 'Template created successfully!');

        } catch (\Exception $e) {
            Log::error('Template creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating template.')->withInput();
        }
    }

    // 4. SHOW EDIT FORM
    public function edit($id)
    {
        $template = Template::findOrFail($id);
        $categories = TemplateCategory::where('status', 'Active')->get();

        // We reuse the create-template blade, passing the $template variable to it
        return view('admin.templates.create-template', compact('template', 'categories'));
    }

    // 5. UPDATE EXISTING TEMPLATE
    public function update(Request $request, $id)
    {
        $template = Template::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:template_categories,id',
            'name' => 'required|string|max:255|unique:templates,name,' . $template->id,
            'content' => 'required|string',
            'status' => 'required|in:Active,Deactive',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|dimensions:min_width=140,min_height=200|max:2048',
        ]);

        try {
            if ($request->hasFile('thumbnail')) {
                if ($template->thumbnail && Storage::disk('public')->exists($template->thumbnail)) {
                    Storage::disk('public')->delete($template->thumbnail);
                }
                $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
            }

            $template->update($validated);
            return redirect()->route('templates.index')->with('success', 'Template updated successfully!');

        } catch (\Exception $e) {
            Log::error('Template update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating template.')->withInput();
        }
    }

    // 6. DELETE TEMPLATE
    public function destroy($id)
    {
        try {
            $template = Template::findOrFail($id);
            if ($template->thumbnail && Storage::disk('public')->exists($template->thumbnail)) {
                Storage::disk('public')->delete($template->thumbnail);
            }
            $template->delete();

            return redirect()->route('templates.index')->with('success', 'Template deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting template: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}