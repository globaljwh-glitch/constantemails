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

    // public function processCampaignQuota(
    //     MailCampaign $campaign
    // ): UserEmailUsage {

    //     return DB::transaction(function () use ($campaign) {

    //         // 1. Lock user to prevent concurrent usage creation.
    //         $user = User::whereKey($campaign->user_id)
    //             ->lockForUpdate()
    //             ->firstOrFail();

    //         // 2. Get the user's currently assigned package.
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

    //         /*
    //         * 3. Check whether this campaign already has
    //         * a quota usage record.
    //         *
    //         * This is important for old campaigns:
    //         * package changes must not move their reservations.
    //         */
    //         $campaignUsageIds = CampaignRecipient::where(
    //                 'campaign_id',
    //                 $campaign->id
    //             )
    //             ->whereNotNull('quota_usage_id')
    //             ->distinct()
    //             ->pluck('quota_usage_id');

    //         if ($campaignUsageIds->count() > 1) {
    //             throw new RuntimeException(
    //                 'This campaign has reservations linked to multiple usage records. Please investigate before sending.'
    //             );
    //         }

    //         if ($campaignUsageIds->count() === 1) {

    //             // Reuse the original usage record for this campaign.
    //             $usage = UserEmailUsage::whereKey(
    //                 $campaignUsageIds->first()
    //             )
    //                 ->where('user_id', $user->id)
    //                 ->lockForUpdate()
    //                 ->firstOrFail();

    //         } else {

    //             /*
    //             * 4. This campaign has no previous reservation.
    //             * Find the latest usage record for the user.
    //             */
    //             $latestUsage = UserEmailUsage::where(
    //                     'user_id',
    //                     $user->id
    //                 )
    //                 ->latest('period_started_at')
    //                 ->lockForUpdate()
    //                 ->first();

    //             $usage = null;

    //             if ($latestUsage) {

    //                 $samePackage = (int) $latestUsage->package_id
    //                     === (int) $user->package_id;

    //                 $periodActive =
    //                     Carbon::parse($latestUsage->period_started_at)
    //                         ->lte($now)
    //                     &&
    //                     Carbon::parse($latestUsage->period_ends_at)
    //                         ->gt($now);

    //                 /*
    //                 * RULE 1:
    //                 * Same package + same active billing period.
    //                 * Reuse existing usage.
    //                 */
    //                 if ($samePackage && $periodActive) {
    //                     $usage = $latestUsage;
    //                 }
    //             }

    //             /*
    //             * RULE 2:
    //             * Different package ID.
    //             *
    //             * RULE 3:
    //             * Same package but billing period expired.
    //             *
    //             * Also handles first-time usage creation.
    //             */
    //             if (!$usage) {

    //                 $usage = UserEmailUsage::create([
    //                     'user_id'           => $user->id,
    //                     'package_id'        => $package->id,
    //                     'email_limit'       => (int) $package->package_emails,
    //                     'emails_sent'       => 0,
    //                     'emails_reserved'   => 0,
    //                     'period_started_at' => $now,
    //                     'period_ends_at'    => $now->copy()
    //                         ->addMonthNoOverflow(),
    //                 ]);
    //             }
    //         }

    //         /*
    //         * 5. Get queued recipients that have never
    //         * been assigned a quota usage record.
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

    //             // Calculate remaining credits.
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

    //             /*
    //             * 6. Assign reservations to the selected usage record.
    //             * Old campaigns retain their original usage ID.
    //             */
    //             CampaignRecipient::whereIn('id', $recipientIds)
    //                 ->whereNull('quota_usage_id')
    //                 ->update([
    //                     'quota_usage_id'    => $usage->id,
    //                     'quota_released_at' => null,
    //                     'updated_at'        => now(),
    //                 ]);

    //             // 7. Increase reserved email count.
    //             $usage->increment(
    //                 'emails_reserved',
    //                 $emailCount
    //             );
    //         }

    //         // 8. Return the correct usage record.
    //         return $usage->fresh();

    //     }, 5);
    // }

    // public function processCampaignQuota(
    //     MailCampaign $campaign
    // ): UserEmailUsage {

    //     return DB::transaction(function () use ($campaign) {

    //         // 1. Lock user to prevent concurrent usage creation.
    //         $user = User::whereKey($campaign->user_id)
    //             ->lockForUpdate()
    //             ->firstOrFail();

    //         // 2. Get the user's currently assigned package.
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
    //         $usage = null;

    //         /*
    //         * 3. Check whether this campaign already has
    //         * a quota usage record.
    //         */
    //         $campaignUsageIds = CampaignRecipient::where(
    //                 'campaign_id',
    //                 $campaign->id
    //             )
    //             ->whereNotNull('quota_usage_id')
    //             ->distinct()
    //             ->pluck('quota_usage_id');

    //         if ($campaignUsageIds->count() > 1) {
    //             throw new RuntimeException(
    //                 'This campaign has reservations linked to multiple usage records. Please investigate before sending.'
    //             );
    //         }

    //         /*
    //         * RULE 4:
    //         * Existing campaign reservations must remain
    //         * linked to their original usage record.
    //         */
    //         if ($campaignUsageIds->count() === 1) {

    //             $usage = UserEmailUsage::whereKey(
    //                 $campaignUsageIds->first()
    //             )
    //                 ->where('user_id', $user->id)
    //                 ->lockForUpdate()
    //                 ->firstOrFail();

    //         } else {

    //             /*
    //             * 4. New campaign without existing reservations.
    //             * Get the latest usage record for this user.
    //             */
    //             $latestUsage = UserEmailUsage::where(
    //                     'user_id',
    //                     $user->id
    //                 )
    //                 ->latest('period_started_at')
    //                 ->lockForUpdate()
    //                 ->first();

    //             /*
    //             * RULE 1:
    //             * Same package and active billing period.
    //             * Reuse existing usage.
    //             */
    //             if ($latestUsage) {

    //                 $samePackage = (int) $latestUsage->package_id
    //                     === (int) $user->package_id;

    //                 $periodActive =
    //                     Carbon::parse($latestUsage->period_started_at)
    //                         ->lte($now)
    //                     &&
    //                     Carbon::parse($latestUsage->period_ends_at)
    //                         ->gt($now);

    //                 if ($samePackage && $periodActive) {
    //                     $usage = $latestUsage;
    //                 }
    //             }

    //             /*
    //             * RULE 2:
    //             * Different package ID.
    //             *
    //             * RULE 3:
    //             * Same package but expired billing period.
    //             *
    //             * Also handles first-time usage creation.
    //             */
    //             if (!$usage) {

    //                 $usage = UserEmailUsage::create([
    //                     'user_id'           => $user->id,
    //                     'package_id'        => $package->id,
    //                     'email_limit'       => (int) $package->package_emails,
    //                     'emails_sent'       => 0,
    //                     'emails_reserved'   => 0,
    //                     'period_started_at' => $now,
    //                     'period_ends_at'    => $now->copy()
    //                         ->addMonthNoOverflow(),
    //                 ]);
    //             }
    //         }

    //         /*
    //         * 5. Get queued recipients that have not
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

    //             // 6. Calculate available credits.
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

    //             // 7. Assign reservations to the correct usage record.
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

    //         // 9. Return the selected usage record.
    //         return $usage->fresh();

    //     }, 5);
    // }

    
    // public function processCampaignQuota(
    //     MailCampaign $campaign
    // ): UserEmailUsage {

    //     return DB::transaction(function () use ($campaign) {

    //         // 1. Lock user.
    //         $user = User::whereKey($campaign->user_id)
    //             ->lockForUpdate()
    //             ->firstOrFail();

    //         // 2. Get currently assigned package.
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

    //         // 3. Lock all recipients belonging to this campaign.
    //         $recipients = CampaignRecipient::where(
    //                 'campaign_id',
    //                 $campaign->id
    //             )
    //             ->lockForUpdate()
    //             ->get();

    //         // Find existing usage IDs.
    //         $campaignUsageIds = $recipients
    //             ->whereNotNull('quota_usage_id')
    //             ->pluck('quota_usage_id')
    //             ->unique()
    //             ->values();

    //         if ($campaignUsageIds->count() > 1) {
    //             throw new RuntimeException(
    //                 'Campaign has reservations linked to multiple usage records.'
    //             );
    //         }

    //         $usage = null;

    //         /*
    //         * 4. Check whether this campaign already has a reservation.
    //         */
    //         if ($campaignUsageIds->count() === 1) {

    //             $oldUsage = UserEmailUsage::whereKey(
    //                     $campaignUsageIds->first()
    //                 )
    //                 ->where('user_id', $user->id)
    //                 ->lockForUpdate()
    //                 ->firstOrFail();

    //             /*
    //             * Check whether this campaign has already sent
    //             * any emails successfully.
    //             */
    //             $alreadySent = $recipients->contains(function ($recipient) {
    //                 return $recipient->quota_counted_at !== null;
    //             });

    //             /*
    //             * If emails have already been sent, preserve
    //             * the original usage record.
    //             */
    //             if ($alreadySent) {

    //                 $usage = $oldUsage;

    //             } else {

    //                 /*
    //                 * No emails sent yet.
    //                 * Compare old usage package with current package.
    //                 */
    //                 if (
    //                     (int) $oldUsage->package_id ===
    //                     (int) $user->package_id
    //                 ) {

    //                     $usage = $oldUsage;

    //                 } else {

    //                     /*
    //                     * Package changed before sending started.
    //                     * Get or create current package usage.
    //                     */
    //                     $usage = UserEmailUsage::where('user_id', $user->id)
    //                         ->where('package_id', $user->package_id)
    //                         ->where('period_started_at', '<=', $now)
    //                         ->where('period_ends_at', '>', $now)
    //                         ->latest('period_started_at')
    //                         ->lockForUpdate()
    //                         ->first();

    //                     if (!$usage) {

    //                         $usage = UserEmailUsage::create([
    //                             'user_id'           => $user->id,
    //                             'package_id'        => $package->id,
    //                             'email_limit'       => (int) $package->package_emails,
    //                             'emails_sent'       => 0,
    //                             'emails_reserved'   => 0,
    //                             'period_started_at' => $now,
    //                             'period_ends_at'    => $now->copy()
    //                                 ->addMonthNoOverflow(),
    //                         ]);
    //                     }

    //                     /*
    //                     * Transfer only active queued reservations.
    //                     * Do not transfer sent or released reservations.
    //                     */
    //                     $queuedRecipients = $recipients
    //                         ->where('status', 'queued')
    //                         ->where('quota_usage_id', $oldUsage->id)
    //                         ->whereNull('quota_counted_at')
    //                         ->whereNull('quota_released_at');

    //                     $transferCount = $queuedRecipients->count();

    //                     if ($transferCount > 0) {

    //                         // Check availability in the new package.
    //                         $remaining = $usage->remainingEmails();

    //                         if (
    //                             $remaining !== -1 &&
    //                             $transferCount > $remaining
    //                         ) {
    //                             throw new RuntimeException(
    //                                 'Insufficient email credits. You need ' .
    //                                 $transferCount . ' emails, but only ' .
    //                                 $remaining . ' are available.'
    //                             );
    //                         }

    //                         $recipientIds = $queuedRecipients
    //                             ->pluck('id')
    //                             ->all();

    //                         // Release old reservations.
    //                         $oldUsage->decrement(
    //                             'emails_reserved',
    //                             $transferCount
    //                         );

    //                         // Assign reservations to new usage.
    //                         CampaignRecipient::whereIn('id', $recipientIds)
    //                             ->update([
    //                                 'quota_usage_id'    => $usage->id,
    //                                 'quota_released_at' => null,
    //                                 'updated_at'        => now(),
    //                             ]);

    //                         // Reserve against new package.
    //                         $usage->increment(
    //                             'emails_reserved',
    //                             $transferCount
    //                         );
    //                     }
    //                 }
    //             }

    //         } else {

    //             /*
    //             * 5. No existing campaign reservation.
    //             * Find latest usage record for the user.
    //             */
    //             $latestUsage = UserEmailUsage::where('user_id', $user->id)
    //                 ->latest('period_started_at')
    //                 ->lockForUpdate()
    //                 ->first();

    //             /*
    //             * RULE 1: Same package + active billing period.
    //             * RULE 2: Different package.
    //             * RULE 3: Expired billing period.
    //             */
    //             if (
    //                 $latestUsage &&
    //                 (int) $latestUsage->package_id ===
    //                     (int) $user->package_id &&
    //                 Carbon::parse($latestUsage->period_started_at)->lte($now) &&
    //                 Carbon::parse($latestUsage->period_ends_at)->gt($now)
    //             ) {

    //                 $usage = $latestUsage;

    //             } else {

    //                 $usage = UserEmailUsage::create([
    //                     'user_id'           => $user->id,
    //                     'package_id'        => $package->id,
    //                     'email_limit'       => (int) $package->package_emails,
    //                     'emails_sent'       => 0,
    //                     'emails_reserved'   => 0,
    //                     'period_started_at' => $now,
    //                     'period_ends_at'    => $now->copy()
    //                         ->addMonthNoOverflow(),
    //                 ]);
    //             }
    //         }

    //         /*
    //         * 6. Reserve any remaining queued recipients
    //         * that have never been assigned a usage record.
    //         */
    //         $newRecipients = CampaignRecipient::where(
    //                 'campaign_id',
    //                 $campaign->id
    //             )
    //             ->where('status', 'queued')
    //             ->whereNull('quota_usage_id')
    //             ->lockForUpdate()
    //             ->get(['id']);

    //         $emailCount = $newRecipients->count();

    //         if ($emailCount > 0) {

    //             $remaining = $usage->remainingEmails();

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

    //             $recipientIds = $newRecipients->pluck('id')->all();

    //             CampaignRecipient::whereIn('id', $recipientIds)
    //                 ->whereNull('quota_usage_id')
    //                 ->update([
    //                     'quota_usage_id'    => $usage->id,
    //                     'quota_released_at' => null,
    //                     'updated_at'        => now(),
    //                 ]);

    //             $usage->increment(
    //                 'emails_reserved',
    //                 $emailCount
    //             );
    //         }

    //         return $usage->fresh();

    //     }, 5);
    // }


    
public function processCampaignQuota(
    MailCampaign $campaign
): UserEmailUsage {

    return DB::transaction(function () use ($campaign) {

        // 1. Lock user.
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
         * 3. ALWAYS ensure the current package has an
         * active usage record.
         *
         * This happens independently of old campaign reservations.
         */
        $currentUsage = UserEmailUsage::where('user_id', $user->id)
            ->where('package_id', $user->package_id)
            ->where('period_started_at', '<=', $now)
            ->where('period_ends_at', '>', $now)
            ->latest('period_started_at')
            ->lockForUpdate()
            ->first();

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

            Log::info('New email usage record created', [
                'user_id'    => $user->id,
                'package_id' => $package->id,
                'usage_id'   => $currentUsage->id,
                'email_limit'=> $currentUsage->email_limit,
            ]);
        }

        /*
         * 4. Check existing campaign reservations.
         */
        $recipients = CampaignRecipient::where(
                'campaign_id',
                $campaign->id
            )
            ->lockForUpdate()
            ->get();

        $campaignUsageIds = $recipients
            ->whereNotNull('quota_usage_id')
            ->pluck('quota_usage_id')
            ->unique()
            ->values();

        if ($campaignUsageIds->count() > 1) {
            throw new RuntimeException(
                'Campaign has reservations linked to multiple usage records.'
            );
        }

        $usage = $currentUsage;

        /*
         * 5. Preserve old campaign reservations.
         */
        if ($campaignUsageIds->count() === 1) {

            $oldUsage = UserEmailUsage::whereKey(
                    $campaignUsageIds->first()
                )
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((int) $oldUsage->id !== (int) $currentUsage->id) {

                // Check whether this campaign has already sent emails.
                $alreadySent = $recipients->contains(function ($recipient) {
                    return $recipient->quota_counted_at !== null
                        || in_array($recipient->status, [
                            'sent',
                            'opened',
                            'clicked',
                            'unsubscribed',
                        ], true);
                });

                if ($alreadySent) {

                    // Old campaign: retain original usage record.
                    $usage = $oldUsage;

                } else {

                    /*
                     * Campaign has not sent emails yet.
                     * Transfer its active queued reservations
                     * to the current package usage.
                     */
                    $queuedRecipients = $recipients
                        ->where('status', 'queued')
                        ->where('quota_usage_id', $oldUsage->id)
                        ->whereNull('quota_counted_at')
                        ->whereNull('quota_released_at');

                    $transferCount = $queuedRecipients->count();

                    if ($transferCount > 0) {

                        $remaining = $currentUsage->remainingEmails();

                        if (
                            $remaining !== -1 &&
                            $transferCount > $remaining
                        ) {
                            throw new RuntimeException(
                                'Insufficient email credits. You need ' .
                                $transferCount . ' emails, but only ' .
                                $remaining . ' are available.'
                            );
                        }

                        // Release old reservations.
                        if ($oldUsage->emails_reserved < $transferCount) {
                            throw new RuntimeException(
                                'Old usage record has insufficient reserved credits.'
                            );
                        }

                        $oldUsage->decrement(
                            'emails_reserved',
                            $transferCount
                        );

                        $recipientIds = $queuedRecipients
                            ->pluck('id')
                            ->all();

                        // Move queued recipients to current usage.
                        CampaignRecipient::whereIn('id', $recipientIds)
                            ->update([
                                'quota_usage_id'    => $currentUsage->id,
                                'quota_released_at' => null,
                                'updated_at'        => now(),
                            ]);

                        // Reserve credits in current package.
                        $currentUsage->increment(
                            'emails_reserved',
                            $transferCount
                        );
                    }

                    $usage = $currentUsage;
                }
            } else {
                $usage = $oldUsage;
            }
        }

        /*
         * 6. Reserve any queued recipients that do not
         * already have a quota usage record.
         */
        $newRecipients = CampaignRecipient::where(
                'campaign_id',
                $campaign->id
            )
            ->where('status', 'queued')
            ->whereNull('quota_usage_id')
            ->lockForUpdate()
            ->get(['id']);

        $emailCount = $newRecipients->count();

        if ($emailCount > 0) {

            $remaining = $usage->remainingEmails();

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

            $recipientIds = $newRecipients->pluck('id')->all();

            CampaignRecipient::whereIn('id', $recipientIds)
                ->whereNull('quota_usage_id')
                ->update([
                    'quota_usage_id'    => $usage->id,
                    'quota_released_at' => null,
                    'updated_at'        => now(),
                ]);

            $usage->increment(
                'emails_reserved',
                $emailCount
            );
        }

        Log::info('Campaign quota processed', [
            'campaign_id' => $campaign->id,
            'user_id'     => $user->id,
            'package_id'  => $package->id,
            'usage_id'    => $usage->id,
            'reserved'    => $emailCount,
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