<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailVerification extends Model
{
    protected $fillable = [
        'email',
        'domain',
        'status',
        'smtp_status',
        'syntax_valid',
        'domain_exists',
        'mx_exists',
        'mx_host',
        'smtp_code',
        'message',
        'verified_at',
    ];

    protected $casts = [
        'syntax_valid' => 'boolean',
        'domain_exists' => 'boolean',
        'mx_exists' => 'boolean',
        'verified_at' => 'datetime',
    ];
}