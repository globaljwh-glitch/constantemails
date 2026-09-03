<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CmsArticle;
use Illuminate\Support\Facades\Log;

class CmsArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = CmsArticle::query();

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('title', 'like', "%{$searchTerm}%");
        }

        $articles = $query->latest()->paginate(10);
        return view('admin.cms.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.cms.form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:cms_articles,title',
            'status' => 'required|in:Active,Deactive',
            'content' => 'required|string',
        ]);

        try {
            CmsArticle::create($validated);
            return redirect()->route('cms-articles.index')->with('success', 'CMS Article created successfully!');
        } catch (\Exception $e) {
            Log::error('CMS Creation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating article.')->withInput();
        }
    }

    public function edit($id)
    {
        $article = CmsArticle::findOrFail($id);
        return view('admin.cms.form', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $article = CmsArticle::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:cms_articles,title,' . $article->id,
            'status' => 'required|in:Active,Deactive',
            'content' => 'required|string',
        ]);

        try {
            $article->update($validated);
            return redirect()->route('cms-articles.index')->with('success', 'CMS Article updated successfully!');
        } catch (\Exception $e) {
            Log::error('CMS Update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error updating article.')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            CmsArticle::findOrFail($id)->delete();
            return redirect()->route('cms-articles.index')->with('success', 'CMS Article deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting CMS article: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong.');
        }
    }
}