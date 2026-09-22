<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailCampaign;
use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = MailCampaign::with('user');

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email_title', 'LIKE', "%{$search}%")
                    ->orWhere('email_subject', 'LIKE', "%{$search}%");
            });
        }

        $campaigns = $query->latest()->paginate(10);

        return view('admin.campaign.index', compact('campaigns'));
    }


    public function getCampaignContacts($id)
    {
        $campaign = MailCampaign::with('groups')->findOrFail($id);

        $groupIds = $campaign->groups->pluck('id');


        $contacts = \App\Models\Contact::with('group')
            ->whereIn('group_id', $groupIds)
            ->get();

        return response()->json([
            'campaign_title' => $campaign->email_title,
            'contacts' => $contacts
        ]);
    }

    public function create()
    {
        return view('admin.campaign.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_title' => 'required|string|max:255',
            'email_subject' => 'nullable|string|max:255',
        ]);

        MailCampaign::create([
            'email_title' => $request->email_title,
            'email_subject' => $request->email_subject,
            'campaign_status' => 'Draft',
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully!');
    }

    public function edit($id)
    {
        $campaign = MailCampaign::findOrFail($id);
        return view('admin.campaign.edit', compact('campaign'));
    }

    public function update(Request $request, $id)
    {
        $campaign = MailCampaign::findOrFail($id);

        $request->validate([
            'email_title' => 'required|string|max:255',
            'email_subject' => 'nullable|string|max:255',
        ]);

        $campaign->update([
            'email_title' => $request->email_title,
            'email_subject' => $request->email_subject,
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully!');
    }

    public function destroy($id)
    {
        $campaign = MailCampaign::findOrFail($id);
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign deleted successfully!');
    }
}