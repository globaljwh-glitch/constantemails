<?php

namespace App\Services;

use App\Models\UserEmailUsage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RuntimeException;

class EmailQuotaService
{
    /**
     * Get or create the current monthly quota period.
     */
    public function getCurrentUsage(
        int $userId,
        ?int $packageId,
        int $packageLimit
    ): UserEmailUsage {

        return DB::transaction(function () use (
            $userId,
            $packageId,
            $packageLimit
        ) {

            $now = now();

            $usage = UserEmailUsage::where('user_id', $userId)
                ->where('period_started_at', '<=', $now)
                ->where('period_ends_at', '>', $now)
                ->latest('period_started_at')
                ->lockForUpdate()
                ->first();

            if ($usage) {
                return $usage;
            }

            return UserEmailUsage::create([
                'user_id' => $userId,
                'package_id' => $packageId,
                'email_limit' => $packageLimit,
                'emails_sent' => 0,
                'emails_reserved' => 0,
                'period_started_at' => $now,
                'period_ends_at' => Carbon::instance($now)
                    ->addMonthNoOverflow(),
            ]);
        }, 5);
    }

    /**
     * Reserve email credits before dispatching campaign jobs.
     */
    public function reserve(
        int $usageId,
        int $emailCount
    ): UserEmailUsage {

        return DB::transaction(function () use ($usageId, $emailCount) {

            $usage = UserEmailUsage::whereKey($usageId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($usage->period_ends_at->isPast()) {
                throw new RuntimeException(
                    'Your monthly email quota has expired.'
                );
            }

            if ($emailCount <= 0) {
                throw new RuntimeException(
                    'No eligible recipients found.'
                );
            }

            if ($emailCount > $usage->remainingEmails()) {
                throw new RuntimeException(
                    'Insufficient email credits. Remaining emails: ' .
                    $usage->remainingEmails()
                );
            }

            $usage->increment('emails_reserved', $emailCount);

            return $usage->fresh();
        }, 5);
    }

    /**
     * Mark one reserved email as successfully accepted by SMTP.
     */
    public function markSent(int $usageId): void
    {
        DB::transaction(function () use ($usageId) {

            $usage = UserEmailUsage::whereKey($usageId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($usage->emails_reserved < 1) {
                throw new RuntimeException(
                    'No reserved email credit available.'
                );
            }

            $usage->emails_reserved--;
            $usage->emails_sent++;

            $usage->save();
        }, 5);
    }

    /**
     * Release one reserved credit when SMTP sending fails.
     */
    public function release(int $usageId): void
    {
        DB::transaction(function () use ($usageId) {

            $usage = UserEmailUsage::whereKey($usageId)
                ->lockForUpdate()
                ->firstOrFail();

            if ($usage->emails_reserved > 0) {
                $usage->decrement('emails_reserved');
            }
        }, 5);
    }
}
