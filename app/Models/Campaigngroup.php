<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaigngroup extends Model
{
    protected $table = 'campaign_group';

    protected $fillable = [
        'campaign_id',
        'group_id',
    ];
}