<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    protected $table = 'mail_templates';

    protected $fillable = [
        'mail_template_name',
        'mail_template_content',
        'mail_template_image',
        'status',
    ];
}
