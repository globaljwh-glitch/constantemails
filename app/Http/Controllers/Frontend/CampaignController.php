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
use App\Models\SaveTemplate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $campaignId = session('campaign_draft.campaign_id');
        // dd([
        //     'campaign_id_from_session' => session('campaign_draft.campaign_id'),
        //     'email_title_from_request' => $request->email_title,

        //     'existing_campaigns' => \DB::table('mail_campaign')
        //         ->where('email_title', $request->email_title)
        //         ->get(['id', 'email_title']),
        // ]);
        $validated = $request->validate([
            //'email_subject' => 'required|max:255',
            'email_subject' => [
                'required',
                'max:255',
                Rule::unique('mail_campaign', 'email_subject')
                    ->ignore($campaignId, 'id'),
            ],
            'from_name'     => 'required|max:255',
            'email_title' => [
                'required',
                'max:255',
                Rule::unique('mail_campaign', 'email_title')
                ->ignore($campaignId, 'id'),
            ],
            'from_email'    => 'required|email',
        ]);

        if ($campaignId) {

            // Existing campaign
            $campaign = MailCampaign::where('id', $campaignId)
                ->where('user_id', auth()->id())
                ->first();

            if ($campaign) {

                $campaign->update([
                    'email_title'   => $validated['email_title'],
                    'from_name'     => $validated['from_name'],
                    'email_subject' => $validated['email_subject'],
                    'from_email'    => $validated['from_email'],
                ]);

            } else {

                // Session campaign doesn't exist anymore
                $campaign = MailCampaign::create([
                    'user_id'       => auth()->id(),
                    'email_title'   => $validated['email_title'],
                    'from_name'     => $validated['from_name'],
                    'email_subject' => $validated['email_subject'],
                    'from_email'    => $validated['from_email'],

                    'campaign_status' => 'active',
                    'send_status'     => 0,
                    'save_option'     => 1,
                ]);
            }

        } else {

            // First time - create campaign
            $campaign = MailCampaign::create([
                'user_id'       => auth()->id(),
                'email_title'   => $validated['email_title'],
                'from_name'     => $validated['from_name'],
                'email_subject' => $validated['email_subject'],
                'from_email'    => $validated['from_email'],

                'campaign_status' => 'active',
                'send_status'     => 0,
                'save_option'     => 1,
            ]);
        }

        // Keep current campaign in session
        session()->put('campaign_draft.campaign_id', $campaign->id);
        session()->put('campaign_draft.email_subject', $validated['email_subject']);
        session()->put('campaign_draft.email_title', $validated['email_title']);
        session()->put('campaign_draft.from_name', $validated['from_name']);
        session()->put('campaign_draft.from_email', $validated['from_email']);

        return redirect()->route(
            'user.campaigns.groups',
            $campaign
        );
    }

    public function show(MailCampaign $campaign)
    {
        //
    }

    public function edit(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        return view('frontend.user.campaigns.edit', compact('campaign'));
    }

    public function update(Request $request, MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $campaignId = session('campaign_draft.campaign_id');
            // dd([
            //     'campaign_id_from_session' => session('campaign_draft.campaign_id'),
            //     'email_title_from_request' => $request->email_title,

            //     'existing_campaigns' => \DB::table('mail_campaign')
            //         ->where('email_title', $request->email_title)
            //         ->get(['id', 'email_title']),
            // ]);
            
            $validated = $request->validate([
            'email_subject' => 'required|max:255',
            'from_name'     => 'required|max:255',
            'email_title' => [
                'required',
                'max:255',
                Rule::unique('mail_campaign', 'email_title')
                ->ignore($campaignId, 'id'),
            ],
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
            ->orderBy('id', 'desc')
            ->get();

        return view(
            'frontend.user.campaigns.groups',
            compact('campaign','groups')
        );
    }

    public function saveGroups(Request $request, MailCampaign $campaign)
    {
        $request->validate([
            'group_ids'   => 'nullable|array|min:1',
            'group_ids.*' => 'exists:contact_groups,id',
        ]);

        $groupIds = $request->group_ids;

        // If request doesn't contain groups, get from session
        if (empty($groupIds)) {
            $groupIds = session('campaign_draft.group_ids', []);
        }

        if (empty($groupIds)) {
            return back()->withErrors([
                'group_ids' => 'Please select at least one group.',
            ]);
        }

        // Check whether campaign_group already has records
        $hasGroups = $campaign->groups()->exists();

        if (!$hasGroups) {
            // campaign_group is empty, so insert session/request groups
            $campaign->groups()->sync($groupIds);
        }

        session()->put('campaign_draft.group_ids', $groupIds);

        return redirect()->route(
            'user.campaigns.templates',
            $campaign
        );
    }

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

            session()->put('campaign_draft.template_id', $id);
            session()->put('campaign_draft.template_type', 'default');

        } else {

            // User-created template
            $campaign->update([
                'template_id' => $id,
                'template_type' => 'user',
            ]);

            session()->put('campaign_draft.template_id', $id);
            session()->put('campaign_draft.template_type', 'user');
        }

        return redirect()->route('user.campaigns.editor', $campaign);
    }

    public function editor(MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $template = null;

        if ($campaign->template_type === 'default') {
            $template = Template::find($campaign->template_id);

            $templateContent = $template->content ?? '';
        } elseif ($campaign->template_type === 'user') {
            //$template = MailTemplate::find($campaign->template_id);
            $template = SaveTemplate::where('id', $campaign->template_id)
                ->where('user_id', auth()->id())
                ->where('status', 'Active')
                ->firstOrFail();

            $templateContent = $template->template_content ?? '';
        }else {

            //abort(404, 'Template type is invalid.');
            // add log here for template type mismatch
            $templateContent = '';    
        }

        if (!$template) {
            abort(404, 'Template not found.');
        }

        

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
        

        //$templateContent = $template->content ?? '';

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

    public function sendCampaign(Request $request, MailCampaign $campaign)
    {
        abort_if($campaign->user_id != auth()->id(), 403);

        $rules = [
            'scheduler' => 'required|in:send_now,schedule_now',
        ];

        if ($request->scheduler === 'schedule_now') {
            $rules['schedule_date'] = 'required';
            $rules['schedule_hour'] = 'required|integer|min:0|max:23';
            $rules['schedule_minute'] = 'required|integer|min:0|max:59';
        }

        $validated = $request->validate($rules);

        /*
        * SEND NOW
        */
        if ($validated['scheduler'] === 'send_now') {

            $campaign->update([
                'scheduler'       => 'send_now',
                'schedule_date'   => null,
                'schedule_hour'   => null,
                'schedule_minute' => null,
                'campaign_status' => 'queued',
            ]);

            // Create recipient snapshot
            $this->processCampaign($campaign);

            // Dispatch immediately
            SendCampaignJob::dispatch($campaign);

            $result = $this->sendAdditionalRecipients($campaign->id);
            session()->forget('campaign_draft');
            
            return redirect()
                ->route('user.campaigns.index')
                ->with(
                    'success',
                    'Campaign has been queued for sending.'
                );
        }

        /*
        * SCHEDULE EMAIL
        */

        /*
        * Build scheduled date/time.
        *
        * Your UI is showing:
        * 11-09-2026
        *
        * So we explicitly tell Carbon the format.
        */
        try {

            $scheduledAt = Carbon::createFromFormat(
                'Y-m-d H:i',
                $validated['schedule_date'] . ' ' .
                str_pad($validated['schedule_hour'], 2, '0', STR_PAD_LEFT) . ':' .
                str_pad($validated['schedule_minute'], 2, '0', STR_PAD_LEFT),
                config('app.timezone')
            );

        } catch (\Throwable $e) {

            return back()
                ->withErrors([
                    'schedule_date' => 'Invalid scheduled date or time.',
                ])
                ->withInput();
        }

        /*
        * Check scheduled time against current time
        */
        if ($scheduledAt->lte(now(config('app.timezone')))) {

            return back()
                ->withErrors([
                    'schedule_date' => 'The scheduled time must be in the future.',
                ])
                ->withInput();
        }

        /*
        * Save schedule
        */
        $campaign->update([
            'scheduler'       => 'schedule_now',
            'schedule_date'   => $validated['schedule_date'],
            'schedule_hour'   => $validated['schedule_hour'],
            'schedule_minute' => $validated['schedule_minute'],
            'campaign_status' => 'queued',
        ]);

        /*
        * Create recipient snapshot
        */
        $this->processCampaign($campaign);

        /*
        * Dispatch campaign job for future execution
        */
        SendCampaignJob::dispatch($campaign)
            ->delay($scheduledAt);

        $result = $this->sendAdditionalRecipients($campaign->id);

        session()->forget('campaign_draft');

        \Log::info('Campaign scheduled', [
            'campaign_id' => $campaign->id,
            'scheduled_at' => $scheduledAt->toDateTimeString(),
            'timezone' => config('app.timezone'),
        ]);

        return redirect()
            ->route('user.campaigns.index')
            ->with(
                'success',
                'Campaign scheduled successfully for ' .
                $scheduledAt->format('d M Y h:i A')
            );
    }

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
            //$campaign->recipients()->delete();

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
                    //'status'      => 'queued',
                    //'queued_at'   => now(),

                    'status' => $contact->user_status === 'opt-out'
                        ? 'unsubscribed'
                        : 'queued',

                    'queued_at' => $contact->user_status === 'opt-out'
                        ? null
                        : now(),
                ]);
            }
        });
    }

    public function templates(MailCampaign $campaign)
    {
        // Make sure campaign belongs to logged-in user
        abort_if(
            $campaign->user_id !== auth()->id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Default Templates
        |--------------------------------------------------------------------------
        */

        $defaultTemplates = Template::where('status', 'Active')->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | My Saved Templates
        |--------------------------------------------------------------------------
        */

        $userTemplates = SaveTemplate::where(
                'user_id',
                auth()->id()
            )
            ->where('status', 'Active')
            ->latest()
            ->get();


        return view(
            'frontend.user.campaigns.templates',
            compact(
                'campaign',
                'defaultTemplates',
                'userTemplates'
            )
        );
    }

    public function click(
        Request $request,
        CampaignRecipient $recipient
    ) {
        $url = $request->query('url');

        /*
        |--------------------------------------------------------------------------
        | Validate URL
        |--------------------------------------------------------------------------
        */

        if (
            !$url ||
            !filter_var($url, FILTER_VALIDATE_URL) ||
            !in_array(
                strtolower(parse_url($url, PHP_URL_SCHEME)),
                ['http', 'https'],
                true
            )
        ) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Update click information
        |--------------------------------------------------------------------------
        */

        if (!$recipient->clicked_at) {
            $recipient->update([
                'clicked_at' => now(),
                'status' => 'clicked',
                'opened_at' => now(),
            ]);
        }

        //$recipient->increment('click_count');

        /*
        |--------------------------------------------------------------------------
        | Redirect to original URL
        |--------------------------------------------------------------------------
        */

        return redirect()->away($url);
    }

    public function trackOpen(CampaignRecipient $recipient)
    {
        // Only record the first open
        // if (!$recipient->opened_at) {
        //     $recipient->update([
        //         'opened_at' => now(),
        //     ]);
        // }
        if ($recipient->status !== 'opened') {
            $recipient->update([
                'status' => 'opened',
                'opened_at' => now(),
            ]);
        }

        // Transparent 1x1 GIF
        $pixel = base64_decode(
            'R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=='
        );

        return response($pixel, 200)
            ->header('Content-Type', 'image/gif')
            ->header('Content-Length', strlen($pixel))
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function sendAdditionalRecipients($campaignId)
    {
        // 1. Get campaign
        $campaign = MailCampaign::findOrFail($campaignId);

        // 2. Check additional recipients
        if (empty($campaign->additional_recipients)) {
            return [
                'success' => true,
                'message' => 'No additional recipients found.',
                'sent' => 0,
                'skipped' => 0,
            ];
        }

        // 3. Get final campaign HTML and subject
        $html = $campaign->message;
        $subject = $campaign->email_subject;
        $from = $campaign->from_email ?: 'noreply@constantemails.com';

        if (empty($html)) {
            throw new \RuntimeException(
                'Campaign email content is empty.'
            );
        }

        // 4. Parse comma-separated email addresses
        $additionalEmails = collect(
            preg_split(
                '/[,;\r\n]+/',
                $campaign->additional_recipients
            )
        )
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter(fn ($email) => filter_var(
                $email,
                FILTER_VALIDATE_EMAIL
            ))
            ->unique()
            ->values();

        // 5. Get all email addresses belonging to selected groups
        $groupEmails = DB::table('campaign_group')
            ->join(
                'contact_group',
                'campaign_group.group_id',
                '=',
                'contact_group.group_id'
            )
            ->join(
                'contact_lists',
                'contact_group.contact_id',
                '=',
                'contact_lists.id'
            )
            ->where('campaign_group.campaign_id', $campaign->id)
            ->pluck('contact_lists.contact_email')
            ->map(fn ($email) => strtolower(trim($email)))
            ->filter()
            ->unique()
            ->flip();

        $sent = 0;
        $skipped = 0;
        $failed = 0;

        // 6. Send only to addresses not already in selected groups
        foreach ($additionalEmails as $email) {

            // Skip if this email already belongs to a selected group
            if ($groupEmails->has($email)) {
                $skipped++;
                continue;
            }

            // 7. Create or retrieve tracking record
            $recipient = CampaignRecipient::firstOrCreate(
                [
                    'campaign_id' => $campaign->id,
                    'email' => $email,
                ],
                [
                    'status' => 'queued',
                    'queued_at' => now(),
                ]
            );

            // Avoid sending the same campaign twice to this email
            if ($recipient->status === 'sent') {
                $skipped++;
                continue;
            }

            try {

                $recipient->update([
                    'status' => 'sending',
                    'error_message' => null,
                ]);

                // 8. Send using your existing SMTP method
                $this->send_smtp_mail(
                    $email,
                    $from,
                    $subject,
                    $html
                );

                // 9. Update tracking status after successful SMTP response
                $recipient->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'error_message' => null,
                ]);

                $sent++;

            } catch (\Throwable $e) {

                $recipient->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                $failed++;

                \Log::error('Additional campaign recipient failed', [
                    'campaign_id' => $campaign->id,
                    'email' => $email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return [
            'success' => $failed === 0,
            'message' => 'Additional recipients processed.',
            'sent' => $sent,
            'skipped' => $skipped,
            'failed' => $failed,
        ];
    }

    public function send_smtp_mail(
    $to,
    $from,
    $subject,
    $body,
    $attachmentPath = null
    ) {
        $smtpServer = '10.1.15.202';
        $smtpPort   = 25;

        $errno  = 0;
        $errstr = '';

        $fp = fsockopen(
            $smtpServer,
            $smtpPort,
            $errno,
            $errstr,
            10
        );

        if (!$fp) {
            throw new \Exception(
                "SMTP connection failed: {$errstr} ({$errno})"
            );
        }

        stream_set_timeout($fp, 30);

        /*
        |--------------------------------------------------------------------------
        | Read SMTP response
        |--------------------------------------------------------------------------
        */
        $readResponse = function () use ($fp) {

            $response = '';

            while (($line = fgets($fp, 515)) !== false) {

                $response .= $line;

                // End of multiline SMTP response
                if (isset($line[3]) && $line[3] === ' ') {
                    break;
                }
            }

            return $response;
        };

        /*
        |--------------------------------------------------------------------------
        | Send SMTP command
        |--------------------------------------------------------------------------
        */
        $sendCommand = function ($command) use ($fp, $readResponse) {

            fwrite($fp, $command . "\r\n");

            return $readResponse();
        };

        /*
        |--------------------------------------------------------------------------
        | SMTP Greeting
        |--------------------------------------------------------------------------
        */
        $response = $readResponse();

        if (substr($response, 0, 1) !== '2') {

            fclose($fp);

            throw new \Exception(
                "SMTP greeting failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | HELO
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand(
            'HELO constantemails.com'
        );

        if (substr($response, 0, 3) !== '250') {

            fclose($fp);

            throw new \Exception(
                "SMTP HELO failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MAIL FROM
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand(
            "MAIL FROM:<{$from}>"
        );

        if (substr($response, 0, 3) !== '250') {

            fclose($fp);

            throw new \Exception(
                "SMTP MAIL FROM failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | RCPT TO
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand(
            "RCPT TO:<{$to}>"
        );

        if (
            substr($response, 0, 3) !== '250' &&
            substr($response, 0, 3) !== '251'
        ) {

            fclose($fp);

            throw new \Exception(
                "SMTP RCPT TO failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DATA
        |--------------------------------------------------------------------------
        */
        $response = $sendCommand('DATA');

        if (substr($response, 0, 3) !== '354') {

            fclose($fp);

            throw new \Exception(
                "SMTP DATA failed: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MIME Boundary
        |--------------------------------------------------------------------------
        */
        $boundary = '=_ConstantEmails_' . md5(
            uniqid((string) mt_rand(), true)
        );

        /*
        |--------------------------------------------------------------------------
        | Email Headers
        |--------------------------------------------------------------------------
        */
        $message  = "Date: " . date('r') . "\r\n";
        $message .= "From: {$from}\r\n";
        $message .= "To: {$to}\r\n";
        $message .= "Subject: {$subject}\r\n";
        $message .= "MIME-Version: 1.0\r\n";

        /*
        |--------------------------------------------------------------------------
        | Attachment
        |--------------------------------------------------------------------------
        */
        if ($attachmentPath && file_exists($attachmentPath)) {

            $fileName = basename($attachmentPath);

            $mimeType = mime_content_type($attachmentPath);

            if (!$mimeType) {
                $mimeType = 'application/octet-stream';
            }

            $message .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";
            $message .= "\r\n";

            /*
            |--------------------------------------------------------------------------
            | HTML Body
            |--------------------------------------------------------------------------
            */
            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n";
            $message .= "\r\n";

            // Prevent SMTP termination issues
            $body = str_replace(
                ["\r\n.", "\n."],
                ["\r\n..", "\n.."],
                $body
            );

            $message .= $body;
            $message .= "\r\n";

            /*
            |--------------------------------------------------------------------------
            | Attachment
            |--------------------------------------------------------------------------
            */
            $fileContent = file_get_contents($attachmentPath);

            if ($fileContent === false) {

                fclose($fp);

                throw new \Exception(
                    "Unable to read attachment: {$attachmentPath}"
                );
            }

            $encodedFile = chunk_split(
                base64_encode($fileContent),
                76,
                "\r\n"
            );

            $message .= "--{$boundary}\r\n";
            $message .= "Content-Type: {$mimeType}; name=\"{$fileName}\"\r\n";
            $message .= "Content-Disposition: attachment; filename=\"{$fileName}\"\r\n";
            $message .= "Content-Transfer-Encoding: base64\r\n";
            $message .= "\r\n";
            $message .= $encodedFile;
            $message .= "\r\n";

            /*
            |--------------------------------------------------------------------------
            | End MIME
            |--------------------------------------------------------------------------
            */
            $message .= "--{$boundary}--\r\n";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Normal HTML Email Without Attachment
            |--------------------------------------------------------------------------
            */
            $message .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message .= "Content-Transfer-Encoding: 8bit\r\n";
            $message .= "\r\n";

            $body = str_replace(
                ["\r\n.", "\n."],
                ["\r\n..", "\n.."],
                $body
            );

            $message .= $body;
            $message .= "\r\n";
        }

        /*
        |--------------------------------------------------------------------------
        | SMTP End of DATA
        |--------------------------------------------------------------------------
        */
        $message .= ".\r\n";

        fwrite($fp, $message);

        /*
        |--------------------------------------------------------------------------
        | SMTP Response
        |--------------------------------------------------------------------------
        */
        $response = $readResponse();

        if (substr($response, 0, 3) !== '250') {

            fclose($fp);

            throw new \Exception(
                "SMTP message rejected: {$response}"
            );
        }

        /*
        |--------------------------------------------------------------------------
        | QUIT
        |--------------------------------------------------------------------------
        */
        fwrite($fp, "QUIT\r\n");

        $readResponse();

        fclose($fp);

        return true;
    }

}