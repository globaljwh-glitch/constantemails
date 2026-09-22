<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $table = 'referrals';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'submittedAt',
        'refereEmail',
        'referred_user_id',
        'Status',
    ];

    protected $casts = [
        'submittedAt' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function referredUser()
    {
        return $this->belongsTo(
            User::class,
            'referred_user_id'
        );
    }
}