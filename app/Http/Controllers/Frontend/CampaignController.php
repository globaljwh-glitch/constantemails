<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MailCampaign;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Template;
use App\Models\MailTemplate;
use Illuminate\Support\Facades\DB;
use App\Models\CampaignRecipient;
use Carbon\Carbon;
use App\Jobs\SendCampaignJob;
use TijsVerkoyen\CssToInlineStyles\CssToInlineStyles;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = MailCampaign::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.user.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('frontend.user.campaigns.create');
    }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'subject'        => 'required|max:255',
    //         'from_name'      => 'required|max:255',
    //         'campaign_name'  => 'required|max:255',
    //         'from_email'     => 'required|email|max:255',
    //     ]);

    //     $validated['user_id'] = auth()->id();

    //     MailCampaign::create($validated);

    //     return redirect()
    //         ->route('user.campaigns.index')
    //         ->with('success', 'Campaign created successfully.');
    // }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'email_subject' => 'required|max:255',
            'from_name'     => 'required|max:255',
            'email_title'   => 'required|max:255',
            'from_email'    => 'required|email',
        ]);

        $campaign = MailCampaign::create([
            'user_id'       => auth()->id(),
            'email_title'   => $validated['email_title'],
            'from_name'     => $validated['from_name'],
            'email_subject' => $validated['email_subject'],

            // Existing table defaults
            'campaign_status' => 'active',
            'send_status'     => 0,
            'save_option'     => 1,
        ]);

        // return redirect()
        //     ->route('user.campaigns.index')
        //     ->with('success', 'Message header saved successfully.');
        return redirect()->route('user.campaigns.groups', $campaign);
    }

    public function show(MailCampaign $campaign)
    {
        //
    }

    // public function edit(MailCampaign $campaign)
    // {
    //     abort_unless($campaign->user_id == auth()->id(), 403);

    //     return view('frontend.user.campaigns.edit', compact('campaign'));
    // }
    public function edit(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        return view('frontend.user.campaigns.edit', compact('campaign'));
    }

    // public function update(Request $request, MailCampaign $campaign)
    // {
    //     abort_unless($campaign->user_id == auth()->id(), 403);

    //     $validated = $request->validate([
    //         'subject'        => 'required|max:255',
    //         'from_name'      => 'required|max:255',
    //         'campaign_name'  => 'required|max:255',
    //         'from_email'     => 'required|email|max:255',
    //     ]);

    //     $campaign->update($validated);

    //     return redirect()
    //         ->route('user.campaigns.index')
    //         ->with('success', 'Campaign updated successfully.');
    // }

    public function update(Request $request, MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $validated = $request->validate([
            'email_subject' => 'required|max:255',
            'from_name'     => 'required|max:255',
            'email_title'   => 'required|max:255',
        ]);

        $campaign->update($validated);

        //return back()->with('success', 'Campaign updated successfully.');
        return redirect()->route('user.campaigns.groups', $campaign);
    }

    public function destroy(MailCampaign $campaign)
    {
        abort_unless($campaign->user_id == auth()->id(), 403);

        $campaign->delete();

        return back()->with('success', 'Campaign deleted successfully.');
    }

    public function groups(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(),403);

        $groups = Group::withCount('contacts')
            ->where('user_id',auth()->id())
            ->where('status',1)
            ->orderBy('group_name')
            ->get();

        return view(
            'frontend.user.campaigns.groups',
            compact('campaign','groups')
        );
    }

    public function saveGroups(Request $request, MailCampaign $campaign)
    {
        $request->validate([
            'group_ids'   => 'required|array|min:1',
            'group_ids.*' => 'exists:contact_groups,id'
        ]);

        $campaign->groups()->sync($request->group_ids);

        return redirect()->route(
            'user.campaigns.templates',
            $campaign
        );
    }

    public function templates(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $defaultTemplates = Template::where('status', 'Active')->get();

        $userTemplates = MailTemplate::where('status', 'Active')
            ->where('user_id', auth()->id()) // if your table has user_id
            ->get();

        return view(
            'frontend.user.campaigns.templates',
            compact('campaign', 'defaultTemplates', 'userTemplates')
        );
    }

    // public function saveTemplate(Request $request, MailCampaign $campaign)
    // {
    //     abort_if($campaign->user_id != auth()->id(), 403);

    //     $request->validate([
    //         'template_type' => 'required'
    //     ]);

    //     $campaign->update([
    //         'template_id' => $request->template_id
    //     ]);

    //     return redirect()->route(
    //         'user.campaigns.editor',
    //         $campaign
    //     );
    // }

    public function saveTemplate(Request $request, MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $request->validate([
            'template_type' => 'required',
        ]);

        [$type, $id] = explode('_', $request->template_type);

        if ($type === 'default') {

            $campaign->update([
                'template_id' => $id,
                'template_type' => 'default',
            ]);

        } else {

            // User-created template
            $campaign->update([
                'template_id' => $id,
                'template_type' => 'user',
            ]);
        }

        return redirect()->route('user.campaigns.editor', $campaign);
    }

    // public function editor(MailCampaign $campaign)
    // {
    //     abort_if($campaign->user_id != auth()->id(), 403);

    //     $groups = Group::where('user_id', auth()->id())
    //         ->where('status', 1)
    //         ->orderBy('group_name')
    //         ->get();

    //     return view(
    //         'frontend.user.campaigns.editor',
    //         compact('campaign', 'groups')
    //     );
    // }

//     public function editor(MailCampaign $campaign)
//     {
//         abort_if($campaign->user_id != auth()->id(), 403);

//         $template = null;

//         $groups = Group::where('user_id', auth()->id())
//             ->where('status', 1)
//             ->orderBy('group_name')
//             ->get();
// //dd($campaign);
//         if ($campaign->template_type === 'default') {
//             $template = Template::find($campaign->template_id);
//         } else {
//             $template = MailTemplate::find($campaign->template_id);
//         }

//         return view('frontend.user.campaigns.editor', compact('campaign', 'groups', 'template'));
//     }

    public function editor(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $template = null;

        if ($campaign->template_type === 'default') {
            $template = Template::find($campaign->template_id);
        } elseif ($campaign->template_type === 'user') {
            $template = MailTemplate::find($campaign->template_id);
        }

        if (!$template) {
            abort(404, 'Template not found.');
        }

        $templateContent = $template->content ?? '';

        /*
        |--------------------------------------------------------------------------
        | Convert CSS to inline styles
        |--------------------------------------------------------------------------
        */

        // $cssToInline = new CssToInlineStyles();

        // $inlinedHtml = $cssToInline->convert($templateContent);
// dd([
//     'template_id' => $campaign->template_id,
//     'template_type' => $campaign->template_type,
//     'content_length' => strlen($templateContent),
//     'content' => $templateContent,
// ]);
        

$templateContent = $template->content ?? '';

$editorContent = '';

if (!empty(trim($templateContent))) {

    $cssToInline = new CssToInlineStyles();

    // Convert CSS rules into inline styles
    $inlinedHtml = $cssToInline->convert($templateContent);

    /*
    |--------------------------------------------------------------------------
    | Extract BODY while preserving BODY attributes/style
    |--------------------------------------------------------------------------
    */

    if (preg_match(
        '/<body\b([^>]*)>(.*?)<\/body>/is',
        $inlinedHtml,
        $matches
    )) {

        $bodyAttributes = $matches[1];
        $bodyContent    = $matches[2];

        // Preserve body attributes/style inside editor
        $editorContent =
            '<div' . $bodyAttributes . '>' .
                $bodyContent .
            '</div>';

    } else {

        $editorContent = $inlinedHtml;
    }
}



        $groups = Group::where('user_id', auth()->id())
            ->where('status', 1)
            ->orderBy('group_name')
            ->get();

        return view(
            'frontend.user.campaigns.editor',
            compact(
                'campaign',
                'template',
                'editorContent', 'groups'
            )
        );
    }

    public function saveEditor(Request $request, MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $validated = $request->validate([
            'group_ids'                => 'required|array',
            'group_ids.*'              => 'exists:contact_groups,id',

            'additional_recipients'    => 'nullable|string|max:1000',

            'email_title'              => 'required|string|max:255',

            'message'                  => 'required|string',

            'attachment'               => 'nullable|file|max:10240',

            'save_option'              => 'required|boolean',

            'campaign_footer'          => 'required|boolean',
        ]);

        // Upload attachment
        if ($request->hasFile('attachment')) {

            $validated['attachment'] = $request->file('attachment')
                ->store('campaign-attachments', 'public');
        }

        // Update campaign
        $campaign->update([
            'email_title'            => $validated['email_title'],
            'additional_recipients'  => $validated['additional_recipients'],
            'message'                => $validated['message'],
            'attachment'             => $validated['attachment'] ?? $campaign->attachment,
            'save_option'            => $validated['save_option'],
            'campaign_footer'        => $validated['campaign_footer'],
        ]);

        // Update selected groups
        $campaign->groups()->sync($validated['group_ids']);

        // Optional: Save as user's reusable template
        if ($validated['save_option']) {

            MailTemplate::create([
                'user_id'               => auth()->id(),
                'mail_template_name'    => $campaign->email_title,
                'mail_template_content' => $campaign->message,
                'mail_template_image'   => null,
                'status'                => 'Active',
            ]);
        }

        return redirect()->route('user.campaigns.send', $campaign);
    }

    public function send(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        return view('frontend.user.campaigns.send', compact('campaign'));
    }

    // public function sendCampaign(Request $request, MailCampaign $campaign)
    // {
    //     abort_if($campaign->user_id != auth()->id(), 403);

    //     $rules = [
    //         'scheduler' => 'required|in:send_now,schedule_now',
    //     ];

    //     if ($request->scheduler == 'schedule_now') {

    //         $rules['schedule_date'] = 'required|date|after_or_equal:today';
    //         $rules['schedule_hour'] = 'required|integer|min:0|max:23';
    //         $rules['schedule_minute'] = 'required|integer|min:0|max:59';
    //     }

    //     $validated = $request->validate($rules);

    //     $campaign->update($validated);

    //     // TODO:
    //     // If send_now -> dispatch email job immediately.
    //     // If schedule_now -> schedule the job using queue.

    //     return redirect()
    //         ->route('user.campaigns.index')
    //         ->with('success', 'Campaign saved successfully.');
    // }

    public function sendCampaign(Request $request, MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $rules = [
            'scheduler' => 'required|in:send_now,schedule_now',
        ];

        if ($request->scheduler == 'schedule_now') {

            $rules['schedule_date'] = 'required|date|after_or_equal:today';
            $rules['schedule_hour'] = 'required|integer|min:0|max:23';
            $rules['schedule_minute'] = 'required|integer|min:0|max:59';
        }

        $validated = $request->validate($rules);

        $campaign->update($validated);

        if ($validated['scheduler'] == 'send_now') {

            // Build recipient snapshot
            DB::transaction(function () use ($campaign, $validated) {

                $this->processCampaign($campaign);

                $campaign->update([
                    'campaign_status' => 'queued',
                ]);

                // Queue sending
            
                SendCampaignJob::dispatch($campaign);
            });

            return redirect()
                ->route('user.campaigns.index')
                ->with('success', 'Campaign has been queued for sending.');
        }

        $this->processCampaign($campaign);

        // Schedule
        $campaign->update([
            'campaign_status' => 'queued',
        ]);

        return redirect()
            ->route('user.campaigns.index')
            ->with('success', 'Campaign has been scheduled successfully.');
    }

    // protected function processCampaign(MailCampaign $campaign): void
    // {
    //     //abort_if($campaign->user_id != auth()->id(), 403);

    //     $campaign->load('groups.contacts');

    //     if ($campaign->groups->isEmpty()) {
    //         throw ValidationException::withMessages([
    //             'groups' => 'Please select at least one contact group.',
    //         ]);
    //     }

    //     DB::transaction(function () use ($campaign) {

    //         $campaign->recipients()->delete();

    //         $recipients = [];

    //         foreach ($campaign->groups as $group) {

    //             foreach ($group->contacts as $contact) {

    //                 if (empty($contact->email)) {
    //                     continue;
    //                 }

    //                 // Prevent duplicates
    //                 $recipients[strtolower($contact->email)] = $contact;
    //             }
    //         }

    //         foreach ($recipients as $contact) {

    //             CampaignRecipient::create([
    //                 'campaign_id' => $campaign->id,
    //                 'contact_id'  => $contact->id,
    //                 'email'       => $contact->email,
    //                 'first_name'  => $contact->first_name,
    //                 'last_name'   => $contact->last_name,
    //                 'status'      => 'queued',
    //                 'queued_at'   => now(),
    //             ]);
    //         }

    //         // $campaign->update([
    //         //     'campaign_status' => 'queued',
    //         // ]);
    //     });

    //     // return redirect()
    //     //     ->route('user.campaigns.index')
    //     //     ->with('success', 'Campaign has been queued successfully.');
    // }

    protected function processCampaign(MailCampaign $campaign): void
    {
        $campaign->load('groups.contacts');

        if ($campaign->groups->isEmpty()) {
            throw ValidationException::withMessages([
                'groups' => 'Please select at least one contact group.',
            ]);
        }

        DB::transaction(function () use ($campaign) {

            // Remove old recipient snapshot
            $campaign->recipients()->delete();

            $recipients = [];

            foreach ($campaign->groups as $group) {

                foreach ($group->contacts as $contact) {

                    if (empty($contact->contact_email)) {
                        continue;
                    }

                    // Prevent duplicate email addresses
                    $email = strtolower(trim($contact->contact_email));

                    $recipients[$email] = $contact;
                }
            }

            foreach ($recipients as $contact) {

                CampaignRecipient::create([
                    'campaign_id' => $campaign->id,
                    'contact_id'  => $contact->id,
                    'email'       => $contact->contact_email,
                    'first_name'  => $contact->contact_first_name,
                    'last_name'   => $contact->contact_last_name,
                    'status'      => 'queued',
                    'queued_at'   => now(),
                ]);
            }
        });
    }

}