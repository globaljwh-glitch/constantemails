<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutoResponder extends Model
{
    use HasFactory;

    protected $table = 'autoresponders';

    protected $fillable = [
        'user_id',
        'subject',
        'sender_name',
        'auto_responder_name',
        'creation_type',
        'campaign_id',
        'message',
        'attachment',
        'status',
    ];

    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Campaign
    |--------------------------------------------------------------------------
    */

    public function campaign()
    {
        return $this->belongsTo(
            MailCampaign::class,
            'campaign_id'
        );
    }
}