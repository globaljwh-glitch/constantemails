<?php

namespace App\Services;

use App\Models\MailCampaign;
use App\Models\User;
use App\Models\UserEmailUsage;
use App\Models\CampaignRecipient;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use RuntimeException;

class EmailQuotaService
{
    /**
     * Get/create monthly usage and reserve all pending campaign recipients.
     */
    public function createPackageUsage(User $user): UserEmailUsage
    {
        return DB::transaction(function () use ($user) {

            $user = User::where('id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            $package = DB::table('registration_packages')
                ->where('id', $user->package_id)
                ->where('status', '!=', 'Deleted')
                ->first();

            if (!$package) {
                throw new \Exception('Assigned package not found.');
            }

            // Check whether usage already exists for this package
            // in the current billing period.
            $existingUsage = UserEmailUsage::where('user_id', $user->id)
                ->where('package_id', $package->id)
                ->where('period_started_at', '<=', now())
                ->where('period_ends_at', '>', now())
                ->lockForUpdate()
                ->first();

            if ($existingUsage) {
                return $existingUsage;
            }

            // Create a fresh usage record for the newly assigned package.
            return UserEmailUsage::create([
                'user_id'          => $user->id,
                'package_id'       => $package->id,
                'email_limit'      => $package->package_emails,
                'emails_sent'      => 0,
                'emails_reserved'  => 0,
                'period_started_at'=> now(),
                'period_ends_at'   => now()->addMonth(),
            ]);
        });
    }


    public function processCampaignQuota(
        MailCampaign $campaign
    ): UserEmailUsage {

        return DB::transaction(function () use ($campaign) {

            // 1. Lock user to prevent duplicate usage creation.
            $user = User::whereKey($campaign->user_id)
                ->lockForUpdate()
                ->firstOrFail();

            // 2. Get currently assigned package.
            $package = DB::table('registration_packages')
                ->where('id', $user->package_id)
                ->where('status', '!=', 'Deleted')
                ->first();

            if (!$package) {
                throw new RuntimeException(
                    'Your assigned package is not active.'
                );
            }

            $now = now();

            /*
            * 3. ALWAYS check usage for the user's CURRENT package.
            *
            * If package ID has changed, the old usage record
            * will not match this query.
            */
            $currentUsage = UserEmailUsage::where('user_id', $user->id)
                ->where('package_id', $user->package_id)
                ->where('period_started_at', '<=', $now)
                ->where('period_ends_at', '>', $now)
                ->latest('period_started_at')
                ->lockForUpdate()
                ->first();

            /*
            * 4. Create a new usage record if the current
            * package does not have an active usage record.
            *
            * This also handles package changes and renewals.
            */
            if (!$currentUsage) {

                $currentUsage = UserEmailUsage::create([
                    'user_id'           => $user->id,
                    'package_id'        => $package->id,
                    'email_limit'       => (int) $package->package_emails,
                    'emails_sent'       => 0,
                    'emails_reserved'   => 0,
                    'period_started_at' => $now,
                    'period_ends_at'    => $now->copy()
                        ->addMonthNoOverflow(),
                ]);

                Log::info('New package usage record created', [
                    'user_id'    => $user->id,
                    'package_id' => $package->id,
                    'usage_id'   => $currentUsage->id,
                    'email_limit'=> $currentUsage->email_limit,
                ]);
            }

            /*
            * 5. Check existing campaign reservations.
            */
            $campaignUsageIds = CampaignRecipient::where(
                    'campaign_id',
                    $campaign->id
                )
                ->whereNotNull('quota_usage_id')
                ->distinct()
                ->pluck('quota_usage_id');

            if ($campaignUsageIds->count() > 1) {
                throw new RuntimeException(
                    'Campaign has reservations linked to multiple usage records.'
                );
            }

            /*
            * 6. Select usage record for this campaign.
            *
            * Existing campaign reservations stay with their
            * original usage record.
            *
            * New campaigns use the current package usage.
            */
            if ($campaignUsageIds->count() === 1) {

                $usage = UserEmailUsage::whereKey(
                        $campaignUsageIds->first()
                    )
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->firstOrFail();

            } else {

                $usage = $currentUsage;
            }

            /*
            * 7. Get queued recipients without existing
            * quota reservations.
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

                // 8. Calculate available credits.
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

                // 9. Assign quota reservation.
                CampaignRecipient::whereIn('id', $recipientIds)
                    ->whereNull('quota_usage_id')
                    ->update([
                        'quota_usage_id'    => $usage->id,
                        'quota_released_at' => null,
                        'updated_at'        => now(),
                    ]);

                // 10. Increase reserved email count.
                $usage->increment(
                    'emails_reserved',
                    $emailCount
                );
            }

            Log::info('Campaign quota processed', [
                'campaign_id' => $campaign->id,
                'user_id'     => $user->id,
                'package_id'  => $package->id,
                'current_usage_id' => $currentUsage->id,
                'campaign_usage_id' => $usage->id,
                'new_reservations' => $emailCount,
            ]);

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