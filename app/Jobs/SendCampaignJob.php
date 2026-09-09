<?php

namespace App\Jobs;

use App\Models\MailCampaign;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public MailCampaign $campaign;

    /**
     * Number of times Laravel should retry the job.
     */
    public int $tries = 3;

    /**
     * Seconds between retries.
     */
    public int $backoff = 30;

    public function __construct(MailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function handle(): void
    {
        $campaign = $this->campaign;

        // Mark campaign as sending
        $campaign->update([
            'status' => 'sending',
        ]);

        /*
         * Get recipients.
         *
         * Change this according to your actual relationship/table.
         *
         * Example:
         * $recipients = $campaign->recipients;
         */
        $recipients = $campaign->recipients;

        foreach ($recipients as $recipient) {

            try {

                /*
                 * ----------------------------------------
                 * Replacement variables
                 * ----------------------------------------
                 */

                $replacements = [
                    '[name]'    => $recipient->name ?? '',
                    '[email]'   => $recipient->email ?? '',
                    '[company]' => $recipient->company_name ?? '',
                    '[phone]'   => $recipient->phone ?? '',
                ];

                /*
                 * ----------------------------------------
                 * Email subject
                 * ----------------------------------------
                 */

                $subject = strtr(
                    $campaign->subject,
                    $replacements
                );

                /*
                 * ----------------------------------------
                 * Email HTML
                 * ----------------------------------------
                 */

                $html = strtr(
                    $campaign->content,
                    $replacements
                );

                /*
                 * ----------------------------------------
                 * Convert relative image URLs
                 * ----------------------------------------
                 *
                 * /images/example.png
                 *
                 * becomes
                 *
                 * https://yourdomain.com/images/example.png
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
                 * ----------------------------------------
                 * Send email
                 * ----------------------------------------
                 */

                Mail::html($html, function ($message) use (
                    $recipient,
                    $subject
                ) {
                    $message
                        ->to($recipient->email, $recipient->name ?? null)
                        ->subject($subject);
                });

                /*
                 * ----------------------------------------
                 * Mark recipient as sent
                 * ----------------------------------------
                 *
                 * Only use this if your recipient model
                 * contains these fields.
                 */

                $recipient->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);

            } catch (\Throwable $e) {

                /*
                 * Don't stop the complete campaign because
                 * one email failed.
                 */

                Log::error('Campaign email failed', [
                    'campaign_id' => $campaign->id,
                    'email'       => $recipient->email ?? null,
                    'error'       => $e->getMessage(),
                ]);

                /*
                 * Mark this recipient as failed.
                 */

                $recipient->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }

        /*
         * ----------------------------------------
         * Campaign completed
         * ----------------------------------------
         */

        $campaign->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Called when the whole job fails after all retries.
     */
    public function failed(?\Throwable $exception): void
    {
        $this->campaign->update([
            'status' => 'failed',
        ]);

        Log::error('Mail campaign job failed', [
            'campaign_id' => $this->campaign->id,
            'error' => $exception?->getMessage(),
        ]);
    }
}