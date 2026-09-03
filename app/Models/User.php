<?php

namespace App\Models;
use App\Models\RegistrationPackage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'industry_id',
        'company_name',
        'company_address',
        'company_phone',
        'company_fax',
        'city',
        'state',
        'country',
        'zip',
        'intresta_id',
        'additional_details',
        'billing_first_name',
        'billing_last_name',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_country',
        'billing_zip',
        'package_id',
        'payment_option',
        'bank_name',
        'bank_city_name',
        'micr_number',
        'cheque_number',
        'cheque_date',
        'cheque_type',
        'status',
        'account_type',
        'masking_allowed',
        'stripe_id',
        'pm_type',
        'pm_last_four'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function package()
    {
       
        return $this->belongsTo(RegistrationPackage::class, 'package_id');
    }
}