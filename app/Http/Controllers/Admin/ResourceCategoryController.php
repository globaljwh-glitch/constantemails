<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ResourceCategory;

class ResourceCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = ResourceCategory::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }
        $categories = $query->latest()->paginate(5);
        return view('admin.resources.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:resource_categories,name',
            'description' => 'required|string',
            'status' => 'required|in:Active,Deactive',
        ]);
        ResourceCategory::create($data);
        return back()->with('success', 'Category saved!');
    }

    public function update(Request $request, $id)
    {
        $category = ResourceCategory::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:resource_categories,name,' . $id,
            'description' => 'required|string',
            'status' => 'required|in:Active,Deactive',
        ]);
        $category->update($data);
        return back()->with('success', 'Category updated!');
    }

    public function destroy($id)
    {
        ResourceCategory::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted!');
    }
}