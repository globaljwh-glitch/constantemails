<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEmailUsage extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'email_limit',
        'emails_sent',
        'emails_reserved',
        'period_started_at',
        'period_ends_at',
    ];

    protected $casts = [
        'period_started_at' => 'datetime',
        'period_ends_at' => 'datetime',
    ];

    public function remainingEmails(): int
    {
        return max(
            0,
            $this->email_limit - $this->emails_sent - $this->emails_reserved
        );
    }
}

