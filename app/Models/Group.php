<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contact;

class Group extends Model
{
    protected $table = 'contact_groups';

    protected $fillable = [
        'group_name',
        'category_id',
        'user_id',
        'mail_campaign_footer',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(ContactCategory::class, 'category_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'group_id');
    }

    public function campaigns()
    {
        return $this->belongsToMany(
            MailCampaign::class,
            'campaign_group',
            'group_id',
            'campaign_id'
        );
    }

}
