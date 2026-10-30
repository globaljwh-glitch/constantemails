<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    // The explicit database target mapping name
    protected $table = 'contact_inquiries';

    // Whitelist entry fields to protect bulk column processing operations
    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'address', 'city', 'state', 'zip', 'country',
        'company', 'application', 'products_interested', 'final_application'
    ];
}
