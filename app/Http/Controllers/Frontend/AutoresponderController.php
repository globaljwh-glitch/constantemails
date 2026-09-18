<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AutoResponder;
use App\Models\MailCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AutoresponderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    | Show user's autoresponders
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $autoresponders = AutoResponder::where('user_id', auth()->id())
            ->where('status', '!=', 'deleted')
            ->latest()
            ->paginate(10);

        return view(
            'frontend.user.autoresponder.index',
            compact('autoresponders')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    | Show Add Autoresponder page
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view(
            'frontend.user.autoresponder.add',
            [
                'responder' => session('responder_arr', []),
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SELECT TYPE
    |--------------------------------------------------------------------------
    | First step:
    | New Autoresponder / Existing Email Campaign
    |--------------------------------------------------------------------------
    */

    public function selectType(Request $request)
    {
        $request->validate([
            'auto' => [
                'required',
                'in:new,copy',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | NEW AUTORESPONDER
        |--------------------------------------------------------------------------
        */

        if ($request->auto === 'new') {

            session([
                'responder_arr' => [
                    'auto' => 'new',
                    'subject' => '',
                    'sender_name' => '',
                    'auto_responder_name' => '',
                    'mode' => 'new',
                ],
            ]);

            return redirect()
                ->route('user.autoresponders.create')
                ->with('success', 'New Autoresponder selected.');
        }


        /*
        |--------------------------------------------------------------------------
        | COPY EXISTING CAMPAIGN
        |--------------------------------------------------------------------------
        */

        session([
            'responder_arr' => [
                'auto' => 'copy',
                'subject' => '',
                'sender_name' => '',
                'auto_responder_name' => '',
                'mode' => 'copy',
            ],
        ]);

        return redirect()
            ->route('user.autoresponders.copy');
    }


    /*
    |--------------------------------------------------------------------------
    | COPY
    |--------------------------------------------------------------------------
    | Show existing campaigns which user can copy
    |--------------------------------------------------------------------------
    */

    public function copy()
    {
        $campaigns = MailCampaign::where('user_id', auth()->id())
            ->whereNotIn('campaign_status', [
                'deleted',
                'cancelled',
            ])
            ->latest()
            ->get();

        return view(
            'frontend.user.autoresponder.copy',
            compact('campaigns')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COPY CAMPAIGN
    |--------------------------------------------------------------------------
    | Select an existing campaign and copy its information
    |--------------------------------------------------------------------------
    */

    public function copyCampaign(Request $request)
    {
        $request->validate([
            'campaign_id' => [
                'required',
                'integer',
            ],
        ]);

        $campaign = MailCampaign::where('id', $request->campaign_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        session([
            'responder_arr' => [
                'auto' => 'copy',
                'subject' => $campaign->email_subject ?? '',
                'sender_name' => $campaign->sender_name ?? '',
                'auto_responder_name' => '',
                'mode' => 'copy',
                'campaign_id' => $campaign->id,
            ],
        ]);

        return redirect()
            ->route('user.autoresponders.create');
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    | Save Autoresponder header information
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'sender_name' => [
                'required',
                'string',
                'max:255',
            ],

            'auto_responder_name' => [
                'required',
                'string',
                'max:255',
            ],

            'mode' => [
                'nullable',
                'in:new,copy',
            ],
        ]);


        $sessionData = session('responder_arr', []);

        $creationType = $request->mode
            ?: ($sessionData['auto'] ?? 'new');

        $campaignId = $sessionData['campaign_id'] ?? null;


        /*
        |--------------------------------------------------------------------------
        | Security check for campaign
        |--------------------------------------------------------------------------
        */

        if ($campaignId) {

            $campaignExists = MailCampaign::where('id', $campaignId)
                ->where('user_id', auth()->id())
                ->exists();

            if (!$campaignExists) {
                $campaignId = null;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Create Autoresponder
        |--------------------------------------------------------------------------
        */

        $autoresponder = AutoResponder::create([
            'user_id' => auth()->id(),

            'subject' => $validated['subject'],

            'sender_name' => $validated['sender_name'],

            'auto_responder_name' =>
                $validated['auto_responder_name'],

            'creation_type' => $creationType,

            'campaign_id' => $campaignId,

            'status' => 'draft',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Clear temporary session
        |--------------------------------------------------------------------------
        */

        session()->forget('responder_arr');


        /*
        |--------------------------------------------------------------------------
        | Continue to next step
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'user.autoresponders.edit',
                $autoresponder
            )
            ->with(
                'success',
                'Autoresponder created successfully. Continue setting up your message.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    | Edit autoresponder
    |--------------------------------------------------------------------------
    */

    public function edit(AutoResponder $autoresponder)
    {
        $this->authorizeUser($autoresponder);

        return view(
            'frontend.user.autoresponder.edit',
            compact('autoresponder')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        AutoResponder $autoresponder
    ) {
        $this->authorizeUser($autoresponder);

        $validated = $request->validate([
            'subject' => [
                'required',
                'string',
                'max:255',
            ],

            'sender_name' => [
                'required',
                'string',
                'max:255',
            ],

            'auto_responder_name' => [
                'required',
                'string',
                'max:255',
            ],

            'message' => [
                'nullable',
                'string',
            ],
        ]);


        $autoresponder->update([
            'subject' => $validated['subject'],

            'sender_name' => $validated['sender_name'],

            'auto_responder_name' =>
                $validated['auto_responder_name'],

            'message' =>
                $validated['message'] ?? $autoresponder->message,
        ]);


        return redirect()
            ->route(
                'user.autoresponders.edit',
                $autoresponder
            )
            ->with(
                'success',
                'Autoresponder updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTIVATE
    |--------------------------------------------------------------------------
    */

    public function activate(AutoResponder $autoresponder)
    {
        $this->authorizeUser($autoresponder);

        $autoresponder->update([
            'status' => 'active',
        ]);

        return back()->with(
            'success',
            'Autoresponder activated successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PAUSE
    |--------------------------------------------------------------------------
    */

    public function pause(AutoResponder $autoresponder)
    {
        $this->authorizeUser($autoresponder);

        $autoresponder->update([
            'status' => 'paused',
        ]);

        return back()->with(
            'success',
            'Autoresponder paused successfully.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    | Soft delete by changing status
    |--------------------------------------------------------------------------
    */

    public function destroy(AutoResponder $autoresponder)
    {
        $this->authorizeUser($autoresponder);

        $autoresponder->update([
            'status' => 'deleted',
        ]);

        return redirect()
            ->route('user.autoresponders.index')
            ->with(
                'success',
                'Autoresponder deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DUPLICATE
    |--------------------------------------------------------------------------
    */

    public function duplicate(AutoResponder $autoresponder)
    {
        $this->authorizeUser($autoresponder);

        $copy = $autoresponder->replicate();

        $copy->user_id = auth()->id();

        $copy->auto_responder_name =
            $autoresponder->auto_responder_name . ' Copy';

        $copy->status = 'draft';

        $copy->save();

        return redirect()
            ->route(
                'user.autoresponders.edit',
                $copy
            )
            ->with(
                'success',
                'Autoresponder duplicated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | USER AUTHORIZATION
    |--------------------------------------------------------------------------
    */

    private function authorizeUser(
        AutoResponder $autoresponder
    ): void {
        abort_if(
            $autoresponder->user_id !== auth()->id(),
            403
        );
    }
}