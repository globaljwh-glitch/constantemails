<?php

namespace App\Jobs;

use App\Models\MailCampaign;
use App\Models\ContactList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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
        $campaign = $this->campaign;

        $groupIds = DB::table('campaign_group')
            ->where('campaign_id', $campaign->id)
            ->pluck('group_id');

        \Log::info('Campaign groups', [
            'campaign_id' => $campaign->id,
            'group_ids' => $groupIds->toArray(),
        ]);

        $contacts = ContactList::whereIn('group_id', $groupIds)
            ->whereNotNull('contact_email')
            ->get();

        \Log::info('Campaign contacts', [
            'campaign_id' => $campaign->id,
            'count' => $contacts->count(),
        ]);

        //$contacts = ContactList::where('group_id', $campaign->group_id)
        $contacts = ContactList::whereIn('group_id', $groupIds)
            ->whereNotNull('contact_email')
            ->chunkById(100, function ($contacts) use ($campaign) {

                foreach ($contacts as $contact) {

                    try {

                        \Log::info('Campaign email content debug', [
                            'campaign_id'     => $campaign->id,
                            'message_length'  => strlen($campaign->message ?? ''),
                            'message'         => $campaign->message,
                            'email_subject'   => $campaign->email_subject,
                            'recipient_email' => $contact->contact_email,
                            'recipient_name'  => $contact->contact_first_name,
                        ]);

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
                         * Email content
                         */
                        $html = strtr(
                            $campaign->message,
                            $replacements
                        );


                        /*
                         * Convert relative image URLs
                         *
                         * /images/img_waves.png
                         *
                         * to
                         *
                         * https://yourdomain.com/images/img_waves.png
                         */
                        $html = preg_replace_callback(
                            '/(<img[^>]+src=["\'])\/([^"\']+)(["\'])/i',
                            function ($matches) {
                                return $matches[1]
                                    . asset($matches[2])
                                    . $matches[3];
                            },
                            $html
                        );


                        /*
                         * Send email
                         */
                        Mail::html($html, function ($message) use (
                            $contact,
                            $subject
                        ) {
                            $message
                                ->to(
                                    $contact->contact_email,
                                    trim(
                                        ($contact->contact_first_name ?? '') . ' ' .
                                        ($contact->contact_last_name ?? '')
                                    )
                                )
                                ->subject($subject);
                        });


                        Log::info('Campaign email sent', [
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
    }
}