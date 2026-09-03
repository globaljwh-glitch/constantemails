<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailTemplate extends Model
{
    use HasFactory;

    protected $table = 'mail_templates';

    protected $fillable = [
        'mail_template_name',
        'mail_template_content',
        'mail_template_image',
        'status'
    ];
}