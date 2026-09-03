<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\ResourceArticle;
use App\Models\ResourceCategory;
use Illuminate\Support\Facades\Storage;

class ResourceArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = ResourceArticle::with('category');
        if ($request->filled('category_id'))
            $query->where('category_id', $request->category_id);
        if ($request->filled('search'))
            $query->where('name', 'like', "%{$request->search}%");

        $articles = $query->latest()->paginate(10);
        return view('admin.resources.articles_list', compact('articles'));
    }

    public function create()
    {
        $categories = ResourceCategory::where('status', 'Active')->get();
        return view('admin.resources.article_form', compact('categories'));
    }

    public function edit($id)
    {
        $article = ResourceArticle::findOrFail($id);
        $categories = ResourceCategory::where('status', 'Active')->get();
        return view('admin.resources.article_form', compact('article', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:resource_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:Active,Deactive',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('resources/thumbs', 'public');
        }

        ResourceArticle::create($data);
        return redirect()->route('resource-articles.index')->with('success', 'Article saved!');
    }

    public function update(Request $request, $id)
    {
        $article = ResourceArticle::findOrFail($id);
        $data = $request->validate([
            'category_id' => 'required|exists:resource_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'content' => 'required|string',
            'status' => 'required|in:Active,Deactive',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail)
                Storage::disk('public')->delete($article->thumbnail);
            $data['thumbnail'] = $request->file('thumbnail')->store('resources/thumbs', 'public');
        }

        $article->update($data);
        return redirect()->route('resource-articles.index')->with('success', 'Article updated!');
    }

    public function destroy($id)
    {
        $article = ResourceArticle::findOrFail($id);
        if ($article->thumbnail)
            Storage::disk('public')->delete($article->thumbnail);
        $article->delete();
        return back()->with('success', 'Article deleted!');
    }
}