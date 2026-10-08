<?php

namespace App\Jobs;

use App\Models\MailCampaign;
use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\CampaignRecipient;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class SendCampaignJob implements ShouldQueue
{
    use Queueable;

    public MailCampaign $campaign;

    public function __construct(MailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle(): void
    {
        // Always get the latest campaign data from DB
        $campaign = $this->campaign->fresh();

        if (!$campaign) {
            return;
        }

        // Do not send a cancelled campaign
        if ($campaign->campaign_status === 'cancelled') {
            Log::info('Campaign cancelled, skipping send', [
                'campaign_id' => $campaign->id,
            ]);

            return;
        }

        // Mark campaign as processing
        $campaign->update([
            'campaign_status' => 'processing',
        ]);    

        $groupIds = DB::table('campaign_group')
            ->where('campaign_id', $campaign->id)
            ->pluck('group_id');

        Log::info('Campaign groups', [
            'campaign_id' => $campaign->id,
            'group_ids' => $groupIds->toArray(),
        ]);

        $contacts = Contact::whereHas('groups', function ($query) use ($groupIds) {
            $query->whereIn('contact_groups.id', $groupIds);
        })
        ->whereNotNull('contact_email')
        ->where('user_status', 'opt-in')
        ->select('contact_lists.*')
        ->distinct()
        ->chunkById(100, function ($contacts) use ($campaign) {

                foreach ($contacts as $contact) {

                    try {

                        // Log::info('Campaign email content debug', [
                        //     'campaign_id'     => $campaign->id,
                        //     'message_length'  => strlen($campaign->message ?? ''),
                        //     'message'         => $campaign->message,
                        //     'email_subject'   => $campaign->email_subject,
                        //     'recipient_email' => $contact->contact_email,
                        //     'recipient_name'  => $contact->contact_first_name,
                        // ]);

                        /*
                         * Replace template variables
                         */
                        $replacements = [
                            '[name]'    => trim(
                                ($contact->contact_first_name ?? '') . ' ' .
                                ($contact->contact_last_name ?? '')
                            ),

                            '[first_name]' => $contact->contact_first_name ?? '',

                            '[last_name]' => $contact->contact_last_name ?? '',

                            '[email]' => $contact->contact_email ?? '',

                            '[company]' => $contact->contact_company_name ?? '',

                            '[address]' => $contact->contact_address ?? '',

                            '[area_interest]' => $contact->area_interest ?? '',
                        ];


                        /*
                         * Subject
                         */
                        $subject = strtr(
                            $campaign->email_subject,
                            $replacements
                        );

                        /*
                        * Remove escaped quotes from stored HTML
                        */
                        $html = str_replace(
                            ['\\"', "\\'"],
                            ['"', "'"],
                            $campaign->message
                        );

                        /*
                        * 2. Replace campaign variables
                        */
                        $html = strtr(
                            $html,
                            $replacements
                        );


                        /*
                        * Convert relative image URLs to absolute URLs
                        *
                        * /assets/frontend/images/template/image.gif
                        *
                        * becomes:
                        *
                        * http://10.1.15.210/assets/frontend/images/template/image.gif
                        */
                        $html = preg_replace_callback(
                            '/(<img[^>]+src=["\'])\/([^"\']+)(["\'])/i',
                            function ($matches) {
                                $imageUrl = asset('/' . $matches[2]);

                                Log::info('CAMPAIGN IMAGE URL', [
                                    'original_path' => '/' . $matches[2],
                                    'absolute_url' => $imageUrl,
                                ]);

                                return $matches[1]
                                    . $imageUrl
                                    . $matches[3];

                            },
                            $html
                        );

                        // Adding footer and generate unsubscribe link 
                        $unsubscribeUrl = URL::signedRoute(
                            'unsubscribe',
                            ['contact' => $contact->id]
                        );

                        // $footer = view('frontend.partials.campaign-footer', [
                        //     'footer' => $campaign->footer ?? null,
                        //     'unsubscribeUrl' => $unsubscribeUrl,
                        // ])->render();

                        // $html .= $footer;

                        // Converting links to tracking urls 
                        $recipient = CampaignRecipient::where('campaign_id', $campaign->id)
                            ->where('contact_id', $contact->id)
                            ->first();

                        if (!$recipient) {
                        }else{

                            // New footer part
                            $newfooter = $this->buildEmailFooter(
                                $campaign,
                                $recipient, $unsubscribeUrl
                            );

                            $html .= $newfooter;
                            
                            $html = $this->convertLinks(
                                $html,
                                $recipient->id
                            );

                            // Login for get email opened status
                            $trackingPixel = '<img src="' .
                                route('email.track.open', [
                                    'recipient' => $recipient->id
                                ]) .
                                '" width="1" height="1" style="display:block;border:0;" alt="">';

                            $html .= $trackingPixel;

                            Log::info('Final campaign HTML', [
                                'campaign_id' => $campaign->id,
                                'contact_id' => $contact->id,
                                'recipient_id' => $recipient?->id,
                                'html' => $html,
                            ]);
                        }  

                        /*
                         * Send email old method
                         */
                        // Mail::html($html, function ($mail) use (
                        //     $contact,
                        //     $subject,
                        //     $campaign
                        // ) {

                        //     $mail->to(
                        //         $contact->contact_email,
                        //         trim(
                        //             ($contact->contact_first_name ?? '') . ' ' .
                        //             ($contact->contact_last_name ?? '')
                        //         )
                        //     )->subject($subject);
                         
                        //     // $headers = '';
                        //     // $this->send_smtp_mail($contact->contact_email, "noreply@constantemails.com", $subject, $campaign, $headers);

                        //     // Email successfully handed to the mailer
                        //     CampaignRecipient::where('campaign_id', $campaign->id)
                        //         ->where('contact_id', $contact->id)
                        //         ->update([
                        //             'status' => 'sent',
                        //             'sent_at' => now(),
                        //             'updated_at' => now(),
                        //         ]);

                                
                        //     /*
                        //     |--------------------------------------------------------------------------
                        //     | Attach Campaign File
                        //     |--------------------------------------------------------------------------
                        //     */
                        //     if ($campaign->attachment) {

                        //         // $attachmentPath = storage_path(
                        //         //     'app/public/' . $campaign->attachment
                        //         // );
                        //         $attachmentPath = Storage::disk('public')->path(
                        //             $campaign->attachment
                        //         );

                        //         if (file_exists($attachmentPath)) {

                        //             $mail->attach($attachmentPath);

                        //             Log::info('Campaign attachment added', [
                        //                 'campaign_id' => $campaign->id,
                        //                 'recipient' => $contact->contact_email,
                        //                 'attachment' => $attachmentPath,
                        //             ]);

                        //         } else {

                        //             Log::warning(
                        //                 'Campaign attachment file not found',
                        //                 [
                        //                     'campaign_id' => $campaign->id,
                        //                     'attachment' => $attachmentPath,
                        //                 ]
                        //             );
                        //         }
                        //     }

                        // });

                        // New code for send mail
                        try {

                            $attachmentPath = null;

                            /*
                            |--------------------------------------------------------------------------
                            | Get Campaign Attachment
                            |--------------------------------------------------------------------------
                            */
                            if ($campaign->attachment) {

                                $attachmentPath = Storage::disk('public')->path(
                                    $campaign->attachment
                                );

                                if (!file_exists($attachmentPath)) {

                                    Log::warning('Campaign attachment file not found', [
                                        'campaign_id' => $campaign->id,
                                        'attachment'  => $attachmentPath,
                                    ]);

                                    $attachmentPath = null;
                                }
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | Send Email
                            |--------------------------------------------------------------------------
                            */
                            $this->send_smtp_mail(
                                $contact->contact_email,
                                'noreply@constantemails.com',
                                $subject,
                                $html,
                                $attachmentPath
                            );

                            /*
                            |--------------------------------------------------------------------------
                            | Mark Recipient Sent
                            |--------------------------------------------------------------------------
                            */
                            CampaignRecipient::where('campaign_id', $campaign->id)
                                ->where('contact_id', $contact->id)
                                ->update([
                                    'status'       => 'sent',
                                    'sent_at'      => now(),
                                    'error_message'=> null,
                                    'updated_at'   => now(),
                                ]);

                            Log::info('Campaign email sent successfully', [
                                'campaign_id' => $campaign->id,
                                'recipient'   => $contact->contact_email,
                                'attachment'  => $attachmentPath,
                            ]);

                        } catch (\Throwable $e) {

                            CampaignRecipient::where('campaign_id', $campaign->id)
                                ->where('contact_id', $contact->id)
                                ->update([
                                    'status'        => 'failed',
                                    'error_message' => $e->getMessage(),
                                    'updated_at'    => now(),
                                ]);

                            Log::error('Campaign email failed', [
                                'campaign_id' => $campaign->id,
                                'recipient'   => $contact->contact_email,
                                'error'       => $e->getMessage(),
                            ]);

                            throw $e;
                        }

                        Log::info('Campaign email sent new', [
                            'campaign_id' => $campaign->id,
                            'contact_id' => $contact->id,
                            'email' => $contact->contact_email,
                        ]);

                    } catch (\Throwable $e) {

                        /*
                         * Don't stop the complete campaign
                         * if one email fails.
                         */
                        Log::error('Campaign email failed', [
                            'campaign_id' => $campaign->id,
                            'contact_id' => $contact->id,
                            'email' => $contact->contact_email,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });
            

            // $campaign = MailCampaign::findOrFail($campaign->id);

            // if (!empty($campaign->additional_recipients)) {

            //     $additionalRecipients = collect(
            //         preg_split('/[,;\s]+/', $campaign->additional_recipients)
            //     )
            //     ->map(fn ($email) => strtolower(trim($email)))
            //     ->filter()
            //     ->unique()
            //     ->values();

            //     $normalContactEmails = collect($contacts)
            //         ->pluck('contact_email')
            //         ->map(fn ($email) => strtolower(trim($email)))
            //         ->filter()
            //         ->toArray();

            //     $additionalRecipients = $additionalRecipients
            //         ->reject(fn ($email) => in_array($email, $normalContactEmails))
            //         ->values();

            //     foreach ($additionalRecipients as $email) {

            //         $this->send_smtp_mail(
            //             $email,
            //             'noreply@constantemails.com',
            //             $subject,
            //             $html,
            //             $attachmentPath
            //         );
            //     }
            // }

            // $campaign = MailCampaign::findOrFail($campaign->id);

            // if (!empty($campaign->additional_recipients)) {

            //     $additionalRecipients = collect(
            //         preg_split('/[,;\s]+/', $campaign->additional_recipients)
            //     )
            //     ->map(fn ($email) => strtolower(trim($email)))
            //     ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            //     ->unique()
            //     ->values();

            //     // Normal campaign contact emails
            //     $normalContactEmails = collect($contacts)
            //         ->pluck('contact_email')
            //         ->map(fn ($email) => strtolower(trim($email)))
            //         ->filter()
            //         ->toArray();

            //     // Remove recipients already included in normal contacts
            //     $additionalRecipients = $additionalRecipients
            //         ->reject(fn ($email) => in_array($email, $normalContactEmails))
            //         ->values();

            //     // Send additional recipients
            //     foreach ($additionalRecipients as $email) {

            //         $this->send_smtp_mail(
            //             $email,
            //             'noreply@constantemails.com',
            //             $subject,
            //             $html,
            //             $attachmentPath
            //         );

            //         Log::info('Additional recipient email sent', [
            //             'campaign_id' => $campaign->id,
            //             'recipient'   => $email,
            //         ]);
            //     }
            // }
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

    // public function send_smtp_mail($to, $from, $subject, $body,$headers = '') {
    //     $smtpServer = "10.1.15.202";
    //     $smtpPort   = 25;

    //     $fp = fsockopen($smtpServer, $smtpPort, $errno, $errstr, 10);
    //     if (!$fp) {
    //         die("Connection failed: $errstr ($errno)\n");
    //     }

    //     // helper to read and write
    //     $read = function() use ($fp) {
    //         return fgets($fp, 515);
    //     };
    //     $write = function($cmd) use ($fp) {
    //         fwrite($fp, $cmd . "\r\n");
    //     };

    //     $read(); // server banner
    //     $write("HELO globalchemicalscorp.com");
    //     $read();

    //     $write("MAIL FROM:<$from>");
    //     $read();

    //     $write("RCPT TO:<$to>");
    //     $read();

    //     $write("DATA");
    //     $read();

    //     // $headers  = "From: $from\r\n";
    //     // $headers .= "To: $to\r\n";
    //     // $headers .= "Subject: $subject\r\n";
    //     // $headers .= "X-Mailer: PHP SMTP\r\n";
    //     //$message = $headers . "\r\n" . $body . "\r\n.\r\n";
    //     // $headers  = "From: $from\r\n";
    //     // $headers .= "Reply-To: $from\r\n";
    //     $headers .= "MIME-Version: 1.0\r\n";
    //     $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    //     $headers .= "Content-Transfer-Encoding: 8bit\r\n";
    //     //echo nl2br($headers);die;

    //     $mailBody = "To: $to\r\nSubject: $subject\r\n$headers\r\n$body\r\n.\r\n";
    //     //echo nl2br($mailBody);die;

    //     fwrite($fp, $mailBody);
    //     $read();

    //     $write("QUIT");
    //     fclose($fp);
    //     //writeLog("Mail sent (relayed via $smtpServer:$smtpPort to $to)\n");
    //     //echo "Mail sent (relayed via $smtpServer:$smtpPort)\n";
    // }

    public function writeLog($message, $file = "app.log") {
        $date = date("Y-m-d H:i:s");
        $logMessage = "[" . $date . "] " . $message . PHP_EOL;

        // Append message to log file
        file_put_contents($file, $logMessage, FILE_APPEND);
    }

    private function convertLinks(string $html, int $recipientId): string {
        libxml_use_internal_errors(true);

        $dom = new \DOMDocument();

        $dom->loadHTML(
            '<?xml encoding="UTF-8">' . $html,
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        foreach ($dom->getElementsByTagName('a') as $link) {

            $href = trim($link->getAttribute('href'));

            if (!$href) {
                continue;
            }

            // Ignore # links
            if (str_starts_with($href, '#')) {
                continue;
            }

            // Ignore mailto/tel/javascript
            if (
                str_starts_with(strtolower($href), 'mailto:') ||
                str_starts_with(strtolower($href), 'tel:') ||
                str_starts_with(strtolower($href), 'javascript:')
            ) {
                continue;
            }

            // Don't track unsubscribe links
            if ($link->hasAttribute('data-no-track')) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Create tracking URL
            |--------------------------------------------------------------------------
            */

            $trackingUrl = route('email.track.click', [
                'recipient' => $recipientId,
                'url' => $href,
            ]);

            $link->setAttribute('href', $trackingUrl);
        }

        $html = $dom->saveHTML();

        libxml_clear_errors();

        return $html;
    }

    private function buildEmailFooter($campaign, $recipient, $unsubscribeUrl): string
    {
        /*
        |--------------------------------------------------------------------------
        | Company information
        |--------------------------------------------------------------------------
        | Change these according to where you store your company settings.
        |--------------------------------------------------------------------------
        */

        $user = User::find($campaign->user_id);

        $companyAddress = $user->company_address ?? '';
        $city           = $user->city ?? '';
        $state          = $user->state ?? '';
        $zip            = $user->zip ?? '';

        $companyDetails = implode(' | ', array_filter([
            $companyAddress,
            $city,
            $state,
            $zip,
        ], fn ($value) => !empty(trim($value ?? ''))));

        // $companyAddress = config('app.company_address', '');
        // $city           = config('app.company_city', '');
        // $state          = config('app.company_state', '');
        // $zip             = config('app.company_zip', '');

        /*
        |--------------------------------------------------------------------------
        | Sender
        |--------------------------------------------------------------------------
        */

        $fromEmail = $campaign->from_email ?? config('mail.from.address');

        /*
        |--------------------------------------------------------------------------
        | Recipient
        |--------------------------------------------------------------------------
        */

        $recipientEmail = $recipient->email;

        /*
        |--------------------------------------------------------------------------
        | Unsubscribe URL
        |--------------------------------------------------------------------------
        */

        // $unsubscribeUrl = route('campaign.unsubscribe', [
        //     'campaign' => $campaign->id,
        //     'contact'  => $recipient->contact_id,
        // ]);

        /*
        |--------------------------------------------------------------------------
        | Forward to friend
        |--------------------------------------------------------------------------
        */

        // $forwardUrl = route('forward', [
        //     'campaign' => $campaign->id,
        //     'contact'  => $recipient->contact_id,
        // ]);
        $forwardUrl = URL::signedRoute('forward', [
            'contact'  => $recipient->contact_id,
            'campaign' => $campaign->id,
        ]);
        // $forwardUrl = URL::signedRoute('forward', [
        //     'contact' => $recipient->contact_id,
        // ]);

        /*
        |--------------------------------------------------------------------------
        | Privacy Policy
        |--------------------------------------------------------------------------
        */

        $privacyUrl = route('privacy');

        /*
        |--------------------------------------------------------------------------
        | Update Profile
        |--------------------------------------------------------------------------
        */

        $profileUrl = route('user.account.profile');

        /*
        |--------------------------------------------------------------------------
        | Tracking pixel
        |--------------------------------------------------------------------------
        */

        // $trackingUrl = route('email.track.click', [
        //     'campaign' => $campaign->id,
        //     'contact'  => $recipient->contact_id,
        // ]);

        $trackingUrl = '';

        /*
        |--------------------------------------------------------------------------
        | Footer
        |--------------------------------------------------------------------------
        */

        $footer = '';

        $footer .= '
            <table width="680"
                border="0"
                align="center"
                cellpadding="0"
                cellspacing="0"
                style="
                        text-align:left;
                        padding:10px 10px;
                "
                class="email_temp_footer">
            ';

        /*
        |--------------------------------------------------------------------------
        | Campaign footer enabled
        |--------------------------------------------------------------------------
        */

        if ($campaign->campaign_footer == 1) {

            $footer .= '
            <tr>

                <td align="center" style="padding: 5px 0px; text-align:center;">

                    <table style="width:100%;" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								


						<td style="text-align:center; font-size:10px !important; padding:0px 0 0px 0px !important; line-height:17px; mso-line-height-rule:exactly; margin:0 !important;">
                        This email was sent to
                        <a href="mailto:' . e($recipientEmail) . '">
                            ' . e($recipientEmail) . '
                        </a>
                    </td>
                    </tr>
                    <tr>
                    <td style="font-size:10px !important; padding:0px 0 0px 0px !important; line-height:17px; mso-line-height-rule:exactly; margin:0 !important;">
                        By
                        <a href="mailto:' . e($fromEmail) . '">
                            ' . e($fromEmail) . '
                        </a>
                    </td>
                    </tr>
                    <tr>
                    <td style="font-size:10px !important; padding:0px 0 0px 0px !important; line-height:17px; mso-line-height-rule:exactly; margin:0 !important;">

                        <a href="' . e($unsubscribeUrl) . '">
                            Unsubscribe
                        </a>

                        |

                        <a href="' . e($forwardUrl) . '">
                            Forward to friend
                        </a>

                        |

                        <a href="' . e($privacyUrl) . '">
                            Privacy policy
                        </a>

                        <img
                            src="' . e($trackingUrl) . '"
                            width="1"
                            height="1"
                            style="display:block;border:0;"
                            alt=""
                        >

                    </td>
                    </tr>
                    <tr>
                    <td align="center" style="font-size:9px; padding-top: 12px;">

                    <div style="
                        font-size:9px !important;
                        padding:0 !important;
                        margin:1px !important;
                    ">
                        <b>Powered by</b>
                    </div>

                    <div style="
                        font-size:9px !important;
                        padding:0 !important;
                        margin:2px !important;
                    ">

                        <a href="' . url('/') . '">

                            <img
                                src="' . asset('assets/frontend/images/logo_email.gif') . '"
                                alt="Constant Emails"
                                border="0"
                            >

                        </a>

                    </div>

                    <div style="
                        font-size:9px !important;
                        padding:0 !important;
                        margin:1px !important;
                    ">
                        <b style="color:#75BE06;">
                            Premiere Email Marketing Engine
                        </b>
                    </div>

                </td>
                </tr>
            </table>
                </td>

                

            </tr>
            ';

        } else {

            /*
            |--------------------------------------------------------------------------
            | Footer disabled
            |--------------------------------------------------------------------------
            */

            $footer .= '
            <tr>

                <td
                    align="center"
                    width="620"
                    style="font-size:10px;"
                >

                    This email was sent to

                    <a href="mailto:' . e($recipientEmail) . '">
                        ' . e($recipientEmail) . '
                    </a>

                    by

                    <a href="mailto:' . e($fromEmail) . '">
                        ' . e($fromEmail) . '
                    </a>

                </td>

            </tr>

            <tr>

                <td
                    align="center"
                    style="font-size:10px;"
                >

                    <a href="' . e($unsubscribeUrl) . '">
                        Unsubscribe
                    </a>

                    |

                    <a href="' . e($forwardUrl) . '">
                        Forward to friend
                    </a>

                    |

                    <a href="' . e($privacyUrl) . '">
                        Privacy policy
                    </a>

                    <img
                        src="' . e($trackingUrl) . '"
                        width="1"
                        height="1"
                        style="display:inline;border:0;"
                        alt=""
                    >

                </td>

            </tr>

            <tr>

                <td
                    align="center"
                    width="620"
                    style="font-size:10px;"
                >

                    ' . e($companyDetails) . '

                </td>

            </tr>
            ';
        }

        $footer .= '</table>';

        return $footer;
    }
}