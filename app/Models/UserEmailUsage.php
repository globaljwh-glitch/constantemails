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
        'email_limit'       => 'integer',
        'emails_sent'       => 'integer',
        'emails_reserved'   => 'integer',
        'period_started_at' => 'datetime',
        'period_ends_at'    => 'datetime',
    ];

    /**
     * Return -1 for unlimited packages.
     */
    public function remainingEmails(): int
    {
        if ($this->email_limit === -1) {
            return -1;
        }

        return max(
            0,
            $this->email_limit - $this->emails_sent - $this->emails_reserved
        );
    }
}