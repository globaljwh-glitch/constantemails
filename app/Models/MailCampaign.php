<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailCampaign extends Model
{
    protected $table = 'mail_campaign';

    protected $fillable = [
        'user_id',
        'template_id',
        'payment_id',
        'group_id',
        'email_title',
        'from_name',
        'email_subject',
        'additional_recipients',
        'message',
        'mail_header',
        'mail_message',
        'campaign_footer',
        'scheduler',
        'schedule_date',
        'schedule_hour',
        'schedule_minute',
        'save_option',
        'send_status',
        'campaign_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'campaign_group',
            'campaign_id',
            'group_id'
        );
    }
}
