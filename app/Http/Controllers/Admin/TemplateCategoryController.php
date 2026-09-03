<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TemplateCategory;
use App\Models\Template;
use Illuminate\Support\Facades\Log;

class TemplateCategoryController extends Controller
{

    public function index(\Illuminate\Http\Request $request)
    {
        // Start the query for Categories
        $query = \App\Models\TemplateCategory::query();

        // Filter by Search Bar
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('status', 'like', "%{$searchTerm}%");
        }

        // Fetch categories with pagination (5 per page)
        $categories = $query->latest()->paginate(5);

        // THIS is where template_cat is loaded and passed the $categories variable!
        return view('admin.templates.template_cat', compact('categories'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:template_categories,name',
            'status' => 'required|in:Active,Deactive',
        ], [
            'name.unique' => 'This category name already exists.',
        ]);

        try {
            TemplateCategory::create($validatedData);

            return redirect()->route('template-categories.index')->with('success', 'Category created successfully!');

        } catch (\Exception $e) {
            Log::error('Error creating category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while creating the category.')->withInput();
        }
    }


    // public function edit($id)
    // {
    //     // $category = TemplateCategory::findOrFail($id);
    //     // return view('pages.template-categories-edit', compact('category'));
    //     return redirect()->back()->with('info', 'Edit page coming soon!');
    // }

    /**
     * Update the specified category in the database.
     */
    public function update(Request $request, $id)
    {
        // Find the category we are trying to edit
        $category = TemplateCategory::findOrFail($id);

        // Validate the data (Note the unique rule ignores the current category's ID!)
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:template_categories,name,' . $category->id,
            'status' => 'required|in:Active,Deactive',
        ], [
            'name.unique' => 'This category name already exists.',
        ]);

        try {
            // Update the category in the database
            $category->update($validatedData);

            // Redirect back to the list with a success message
            return redirect()->route('template-categories.index')->with('success', 'Category updated successfully!');

        } catch (\Exception $e) {
            // Log the error and return back if something goes wrong
            \Illuminate\Support\Facades\Log::error('Error updating category: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong while updating the category.')->withInput();
        }
    }


    public function destroy($id)
    {
        try {
            $category = TemplateCategory::findOrFail($id);
            $category->delete();

            return redirect()->route('template-categories.index')->with('success', 'Category deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Error deleting category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while deleting the category.');
        }
    }
}