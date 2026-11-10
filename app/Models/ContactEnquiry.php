<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'campaign_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'company',
        'company_business_type',
        'products_interested',
        'application',
        'final_application',
    ];
}
