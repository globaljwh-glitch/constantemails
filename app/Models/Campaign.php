<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
        protected $fillable = [
        'subject',
        'html_content',
        'json_content',
        
    ];
}
