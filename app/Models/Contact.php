<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact_lists';

    protected $fillable = [
        'user_id',
        'group_id',
        'contact_first_name',
        'contact_last_name',
        'contact_company_name',
        'contact_address',
        'contact_email',
        'contact_phone',
        'status',
        'user_status',
    ];
}