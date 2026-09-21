<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'organization',
        'phone',
        'comments',
        'status',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];
}