<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ContactCategory;
use Illuminate\Support\Facades\Log;

class ContactCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactCategory::query();

        // Professional Search Logic
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('status', 'like', "%{$searchTerm}%");
        }

        // Paginate by 5
        $categories = $query->latest()->paginate(5);

        return view('admin.contactcategory.contact_cat', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:contact_categories,name',
            'status' => 'required|in:Active,Deactive',
        ], [
            'name.unique' => 'This contact category name already exists.',
        ]);

        try {
            ContactCategory::create($validatedData);
            return redirect()->route('contact-categories.index')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating contact category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while creating the category.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $category = ContactCategory::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:contact_categories,name,' . $category->id,
            'status' => 'required|in:Active,Deactive',
        ], [
            'name.unique' => 'This contact category name already exists.',
        ]);

        try {
            $category->update($validatedData);
            return redirect()->route('contact-categories.index')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating contact category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while updating the category.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $category = ContactCategory::findOrFail($id);
            $category->delete();
            return redirect()->route('contact-categories.index')->with('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting contact category: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while deleting the category.');
        }
    }
}