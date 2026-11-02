<?php

namespace App\Services;

use App\Models\MailCampaign;
use App\Models\User;
use App\Models\UserEmailUsage;
use App\Models\CampaignRecipient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RuntimeException;

class EmailQuotaService
{
    /**
     * Get/create monthly usage and reserve all pending campaign recipients.
     */
    public function processCampaignQuota(
        MailCampaign $campaign
    ): UserEmailUsage {

        return DB::transaction(function () use ($campaign) {

            // Lock user to prevent concurrent first-time usage creation.
            $user = User::whereKey($campaign->user_id)
                ->lockForUpdate()
                ->firstOrFail();

            // Get user's assigned active package.
            $package = DB::table('registration_packages')
                ->where('id', $user->package_id)
                ->where('status', 'Active')
                ->first();

            if (!$package) {
                throw new RuntimeException(
                    'Your assigned package is not active.'
                );
            }

            $now = now();

            // Get current monthly usage.
            $usage = UserEmailUsage::where('user_id', $user->id)
                ->where('period_started_at', '<=', $now)
                ->where('period_ends_at', '>', $now)
                ->latest('period_started_at')
                ->lockForUpdate()
                ->first();

            // Create the first monthly usage record.
            if (!$usage) {

                $usage = UserEmailUsage::create([
                    'user_id'          => $user->id,
                    'package_id'       => $package->id,
                    'email_limit'      => (int) $package->package_emails,
                    'emails_sent'      => 0,
                    'emails_reserved'  => 0,
                    'period_started_at'=> $now,
                    'period_ends_at'   => Carbon::instance($now)
                        ->addMonthNoOverflow(),
                ]);
            }

            /*
             * Get only recipients that have not already been reserved.
             * Existing reservations are retained on queue retries.
             */
            $recipients = CampaignRecipient::where(
                    'campaign_id',
                    $campaign->id
                )
                ->where('status', 'queued')
                ->whereNull('quota_usage_id')
                ->lockForUpdate()
                ->get(['id']);

            $emailCount = $recipients->count();

            if ($emailCount > 0) {

                $remaining = $usage->remainingEmails();

                // -1 means unlimited.
                if (
                    $remaining !== -1 &&
                    $emailCount > $remaining
                ) {
                    throw new RuntimeException(
                        'Insufficient email credits. You need ' .
                        $emailCount . ' emails, but only ' .
                        $remaining . ' are available.'
                    );
                }

                $recipientIds = $recipients->pluck('id')->all();

                CampaignRecipient::whereIn('id', $recipientIds)
                    ->whereNull('quota_usage_id')
                    ->update([
                        'quota_usage_id' => $usage->id,
                        'quota_released_at' => null,
                        'updated_at' => now(),
                    ]);

                $usage->increment(
                    'emails_reserved',
                    $emailCount
                );
            }

            /*
             * If this is a queue retry, recipients may already have
             * reservations. Do not reserve them again.
             */
            return $usage->fresh();

        }, 5);
    }

    /**
     * Mark one recipient as successfully accepted by SMTP.
     * Idempotent: a retry cannot count the same recipient twice.
     */
    public function markEmailSent(int $recipientId): void
    {
        DB::transaction(function () use ($recipientId) {

            $recipient = CampaignRecipient::whereKey($recipientId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($recipient->quota_counted_at) {
                return;
            }

            if (!$recipient->quota_usage_id) {
                throw new RuntimeException(
                    'Recipient has no quota reservation.'
                );
            }

            if ($recipient->quota_released_at) {
                throw new RuntimeException(
                    'Recipient quota reservation was already released.'
                );
            }

            $usage = UserEmailUsage::whereKey(
                $recipient->quota_usage_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($usage->emails_reserved < 1) {
                throw new RuntimeException(
                    'No reserved email credit available.'
                );
            }

            $usage->decrement('emails_reserved');
            $usage->increment('emails_sent');

            $recipient->update([
                'quota_counted_at' => now(),
            ]);

        }, 5);
    }

    /**
     * Release one reservation after an SMTP failure.
     * Idempotent: a reservation cannot be released twice.
     */
    public function releaseEmailReservation(int $recipientId): void
    {
        DB::transaction(function () use ($recipientId) {

            $recipient = CampaignRecipient::whereKey($recipientId)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                !$recipient->quota_usage_id ||
                $recipient->quota_counted_at ||
                $recipient->quota_released_at
            ) {
                return;
            }

            $usage = UserEmailUsage::whereKey(
                $recipient->quota_usage_id
            )
                ->lockForUpdate()
                ->firstOrFail();

            if ($usage->emails_reserved > 0) {
                $usage->decrement('emails_reserved');
            }

            $recipient->update([
                'quota_released_at' => now(),
            ]);

        }, 5);
    }
}