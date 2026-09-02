<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactCategory;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with(['category'])
            ->withCount('contacts')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.user.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = ContactCategory::where('status', 1)
                        ->orderBy('category_name')
                        ->get();

        return view('frontend.user.groups.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:contact_categories,id',
            'group_name' => [
                'required',
                'max:255',
                Rule::unique('contact_groups', 'group_name')
                    ->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
        ]);

        Group::create([
            'group_name'            => $request->group_name,
            'category_id'           => $request->category_id,
            'user_id'               => Auth::id(),
            'mail_campaign_footer'  => 0,
            'status'                => 1,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Contact group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        abort_if($group->user_id != auth()->id(), 403);

        $categories = ContactCategory::where('status',1)
            ->orderBy('category_name')
            ->get();

        return view('frontend.user.groups.edit', compact('group', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    public function update(Request $request, Group $group)
    {
        abort_if($group->user_id != auth()->id(), 403);

        $request->validate([
            'group_name' => 'required|max:255',
            'category_id' => 'required|exists:contact_categories,id',
        ]);

        $group->update([
            'group_name' => $request->group_name,
            'category_id' => $request->category_id,
        ]);

        return redirect()
            ->route('user.groups.index')
            ->with('success','Group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        abort_if($group->user_id != auth()->id(),403);

        $group->delete();

        return back()->with('success','Group deleted successfully.');
    }

    public function activate(Request $request)
    {
        if (!$request->filled('group_ids')) {
            return back()->with('error', 'Please select at least one group.');
        }

        Group::whereIn('id', $request->group_ids)
            ->where('user_id', auth()->id())
            ->update([
                'status' => 1,
            ]);

        return redirect()
            ->route('user.groups.index')
            ->with('success', 'Selected groups activated successfully.');
    }

    public function deactivate(Request $request)
    {
        if (!$request->filled('group_ids')) {
            return back()->with('error', 'Please select at least one group.');
        }

        Group::whereIn('id', $request->group_ids)
            ->where('user_id', auth()->id())
            ->update([
                'status' => 0,
            ]);

        return redirect()
            ->route('user.groups.index')
            ->with('success', 'Selected groups deactivated successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!$request->filled('group_ids')) {
            return back()->with('error', 'Please select at least one group.');
        }

        Group::whereIn('id', $request->group_ids)
            ->where('user_id', auth()->id())
            ->delete();

        return redirect()
            ->route('user.groups.index')
            ->with('success', 'Selected groups deleted successfully.');
    }

}
