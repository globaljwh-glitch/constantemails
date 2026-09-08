<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignRecipient extends Model
{
    protected $fillable = [

        'campaign_id',
        'contact_id',
        'email',
        'first_name',
        'last_name',
        'status',
        'error_message',
        'queued_at',
        'sent_at',
        'opened_at',
        'clicked_at',
    ];

    protected $casts = [

        'queued_at'=>'datetime',
        'sent_at'=>'datetime',
        'opened_at'=>'datetime',
        'clicked_at'=>'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(MailCampaign::class,'campaign_id');
    }

    public function contact()
    {
        return $this->belongsTo(ContactList::class,'contact_id');
    }
}