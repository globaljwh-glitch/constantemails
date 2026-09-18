<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AutoresponderResult extends Model
{
    use HasFactory;

    protected $table = 'autoresponder_results';

    protected $fillable = [
        'auto_id',
        'user_id',
        'group_id',
        'contact_id',
        'template_id',
        'contact_first_name',
        'contact_last_name',
        'interval',
        'run_date_time',
        'last_run_date_time',
        'next_run_date_time',
        'category_id',
        'current_date_time',
    ];

    protected $casts = [
        'run_date_time' => 'datetime',
        'last_run_date_time' => 'datetime',
        'next_run_date_time' => 'datetime',
        'current_date_time' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | Autoresponder
    |--------------------------------------------------------------------------
    */

    public function autoresponder()
    {
        return $this->belongsTo(
            AutoResponder::class,
            'auto_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | User
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Group
    |--------------------------------------------------------------------------
    */

    public function group()
    {
        return $this->belongsTo(
            Group::class,
            'group_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Contact
    |--------------------------------------------------------------------------
    */

    public function contact()
    {
        return $this->belongsTo(
            ContactList::class,
            'contact_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(
            ContactCategory::class,
            'category_id'
        );
    }
}