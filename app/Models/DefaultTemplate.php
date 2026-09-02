<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefaultTemplate extends Model
{
    protected $table = 'default_templates';

    protected $fillable = [
        'campaign_category_id',
        'template_name',
        'template_content',
        'template_image',
        'status',
    ];
}