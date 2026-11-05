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
    // public function processCampaignQuota(
    //     MailCampaign $campaign
    // ): UserEmailUsage {

    //     return DB::transaction(function () use ($campaign) {

    //         // Lock user to prevent concurrent first-time usage creation.
    //         $user = User::whereKey($campaign->user_id)
    //             ->lockForUpdate()
    //             ->firstOrFail();

    //         // Get user's assigned active package.
    //         $package = DB::table('registration_packages')
    //             ->where('id', $user->package_id)
    //             ->where('status', '!=', 'Deleted')
    //             ->first();

    //         if (!$package) {
    //             throw new RuntimeException(
    //                 'Your assigned package is not active.'
    //             );
    //         }

    //         $latestUsage = UserEmailUsage::where('user_id', $user->id)
    //             ->latest('period_started_at')
    //             ->first();

    //         if (
    //             !$latestUsage ||
    //             $latestUsage->package_id != $user->package_id ||
    //             $latestUsage->period_ends_at <= now()
    //         ) {
    //             // Create new usage record
    //         } else {
    //             // Reuse existing usage record
    //         }
    //         $now = now();

    //         // Get current monthly usage.
    //         $usage = UserEmailUsage::where('user_id', $user->id)
    //             ->where('period_started_at', '<=', $now)
    //             ->where('period_ends_at', '>', $now)
    //             ->latest('period_started_at')
    //             ->lockForUpdate()
    //             ->first();

    //         // Create the first monthly usage record.
    //         if (!$usage) {

    //             $usage = UserEmailUsage::create([
    //                 'user_id'          => $user->id,
    //                 'package_id'       => $package->id,
    //                 'email_limit'      => (int) $package->package_emails,
    //                 'emails_sent'      => 0,
    //                 'emails_reserved'  => 0,
    //                 'period_started_at'=> $now,
    //                 'period_ends_at'   => Carbon::instance($now)
    //                     ->addMonthNoOverflow(),
    //             ]);
    //         }

    //         /*
    //          * Get only recipients that have not already been reserved.
    //          * Existing reservations are retained on queue retries.
    //          */
    //         $recipients = CampaignRecipient::where(
    //                 'campaign_id',
    //                 $campaign->id
    //             )
    //             ->where('status', 'queued')
    //             ->whereNull('quota_usage_id')
    //             ->lockForUpdate()
    //             ->get(['id']);

    //         $emailCount = $recipients->count();

    //         if ($emailCount > 0) {

    //             $remaining = $usage->remainingEmails();

    //             // -1 means unlimited.
    //             if (
    //                 $remaining !== -1 &&
    //                 $emailCount > $remaining
    //             ) {
    //                 throw new RuntimeException(
    //                     'Insufficient email credits. You need ' .
    //                     $emailCount . ' emails, but only ' .
    //                     $remaining . ' are available.'
    //                 );
    //             }

    //             $recipientIds = $recipients->pluck('id')->all();

    //             CampaignRecipient::whereIn('id', $recipientIds)
    //                 ->whereNull('quota_usage_id')
    //                 ->update([
    //                     'quota_usage_id' => $usage->id,
    //                     'quota_released_at' => null,
    //                     'updated_at' => now(),
    //                 ]);

    //             $usage->increment(
    //                 'emails_reserved',
    //                 $emailCount
    //             );
    //         }

    //         /*
    //          * If this is a queue retry, recipients may already have
    //          * reservations. Do not reserve them again.
    //          */
    //         return $usage->fresh();

    //     }, 5);
    // }

    // public function processCampaignQuota(
    //     MailCampaign $campaign
    // ): UserEmailUsage {

    //     return DB::transaction(function () use ($campaign) {

    //         // 1. Lock user to prevent concurrent usage record creation.
    //         $user = User::whereKey($campaign->user_id)
    //             ->lockForUpdate()
    //             ->firstOrFail();

    //         // 2. Get user's currently assigned package.
    //         $package = DB::table('registration_packages')
    //             ->where('id', $user->package_id)
    //             ->where('status', '!=', 'Deleted')
    //             ->first();

    //         if (!$package) {
    //             throw new RuntimeException(
    //                 'Your assigned package is not active.'
    //             );
    //         }

    //         $now = now();

    //         // 3. Get the latest usage record for this user.
    //         $latestUsage = UserEmailUsage::where('user_id', $user->id)
    //             ->latest('period_started_at')
    //             ->lockForUpdate()
    //             ->first();

    //         $usage = null;

    //         /*
    //         * 4. Check whether the latest usage record belongs
    //         * to the currently assigned package and is active.
    //         */
    //         if ($latestUsage) {

    //             $samePackage = (int) $latestUsage->package_id
    //                 === (int) $user->package_id;

    //             $periodStarted = Carbon::parse(
    //                 $latestUsage->period_started_at
    //             )->lte($now);

    //             $periodNotExpired = Carbon::parse(
    //                 $latestUsage->period_ends_at
    //             )->gt($now);

    //             if (
    //                 $samePackage &&
    //                 $periodStarted &&
    //                 $periodNotExpired
    //             ) {
    //                 // Reuse existing monthly usage record.
    //                 $usage = $latestUsage;
    //             }
    //         }

    //         /*
    //         * 5. Create a new usage record when:
    //         * - No previous usage record exists.
    //         * - User has changed their package.
    //         * - Previous billing period has expired.
    //         */
    //         if (!$usage) {

    //             $usage = UserEmailUsage::create([
    //                 'user_id'           => $user->id,
    //                 'package_id'        => $package->id,
    //                 'email_limit'       => (int) $package->package_emails,
    //                 'emails_sent'       => 0,
    //                 'emails_reserved'   => 0,
    //                 'period_started_at' => $now,
    //                 'period_ends_at'    => $now->copy()
    //                     ->addMonthNoOverflow(),
    //             ]);
    //         }

    //         /*
    //         * 6. Get only queued recipients that have not
    //         * already been assigned a quota reservation.
    //         */
    //         $recipients = CampaignRecipient::where(
    //                 'campaign_id',
    //                 $campaign->id
    //             )
    //             ->where('status', 'queued')
    //             ->whereNull('quota_usage_id')
    //             ->lockForUpdate()
    //             ->get(['id']);

    //         $emailCount = $recipients->count();

    //         if ($emailCount > 0) {

    //             // Calculate available credits.
    //             $remaining = $usage->remainingEmails();

    //             // -1 means unlimited.
    //             if (
    //                 $remaining !== -1 &&
    //                 $emailCount > $remaining
    //             ) {
    //                 throw new RuntimeException(
    //                     'Insufficient email credits. You need ' .
    //                     $emailCount . ' emails, but only ' .
    //                     $remaining . ' are available.'
    //                 );
    //             }

    //             $recipientIds = $recipients->pluck('id')->all();

    //             // 7. Assign quota reservation to recipients.
    //             CampaignRecipient::whereIn('id', $recipientIds)
    //                 ->whereNull('quota_usage_id')
    //                 ->update([
    //                     'quota_usage_id'    => $usage->id,
    //                     'quota_released_at' => null,
    //                     'updated_at'        => now(),
    //                 ]);

    //             // 8. Increase reserved email count.
    //             $usage->increment(
    //                 'emails_reserved',
    //                 $emailCount
    //             );
    //         }

    //         /*
    //         * 9. Return the usage record.
    //         * Existing reservations are not counted again on retries.
    //         */
    //         return $usage->fresh();

    //     }, 5);
    // }

    public function processCampaignQuota(
        MailCampaign $campaign
    ): UserEmailUsage {

        return DB::transaction(function () use ($campaign) {

            // 1. Lock user to prevent concurrent usage creation.
            $user = User::whereKey($campaign->user_id)
                ->lockForUpdate()
                ->firstOrFail();

            // 2. Get the user's currently assigned package.
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
            * 3. Check whether this campaign already has
            * a quota usage record.
            *
            * This is important for old campaigns:
            * package changes must not move their reservations.
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
                    'This campaign has reservations linked to multiple usage records. Please investigate before sending.'
                );
            }

            if ($campaignUsageIds->count() === 1) {

                // Reuse the original usage record for this campaign.
                $usage = UserEmailUsage::whereKey(
                    $campaignUsageIds->first()
                )
                    ->where('user_id', $user->id)
                    ->lockForUpdate()
                    ->firstOrFail();

            } else {

                /*
                * 4. This campaign has no previous reservation.
                * Find the latest usage record for the user.
                */
                $latestUsage = UserEmailUsage::where(
                        'user_id',
                        $user->id
                    )
                    ->latest('period_started_at')
                    ->lockForUpdate()
                    ->first();

                $usage = null;

                if ($latestUsage) {

                    $samePackage = (int) $latestUsage->package_id
                        === (int) $user->package_id;

                    $periodActive =
                        Carbon::parse($latestUsage->period_started_at)
                            ->lte($now)
                        &&
                        Carbon::parse($latestUsage->period_ends_at)
                            ->gt($now);

                    /*
                    * RULE 1:
                    * Same package + same active billing period.
                    * Reuse existing usage.
                    */
                    if ($samePackage && $periodActive) {
                        $usage = $latestUsage;
                    }
                }

                /*
                * RULE 2:
                * Different package ID.
                *
                * RULE 3:
                * Same package but billing period expired.
                *
                * Also handles first-time usage creation.
                */
                if (!$usage) {

                    $usage = UserEmailUsage::create([
                        'user_id'           => $user->id,
                        'package_id'        => $package->id,
                        'email_limit'       => (int) $package->package_emails,
                        'emails_sent'       => 0,
                        'emails_reserved'   => 0,
                        'period_started_at' => $now,
                        'period_ends_at'    => $now->copy()
                            ->addMonthNoOverflow(),
                    ]);
                }
            }

            /*
            * 5. Get queued recipients that have never
            * been assigned a quota usage record.
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

                // Calculate remaining credits.
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

                /*
                * 6. Assign reservations to the selected usage record.
                * Old campaigns retain their original usage ID.
                */
                CampaignRecipient::whereIn('id', $recipientIds)
                    ->whereNull('quota_usage_id')
                    ->update([
                        'quota_usage_id'    => $usage->id,
                        'quota_released_at' => null,
                        'updated_at'        => now(),
                    ]);

                // 7. Increase reserved email count.
                $usage->increment(
                    'emails_reserved',
                    $emailCount
                );
            }

            // 8. Return the correct usage record.
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