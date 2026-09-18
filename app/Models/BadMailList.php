<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BadMailList extends Model
{
    use HasFactory;

    protected $table = 'bad_mail_list';

    protected $fillable = [
        'bad_mail_id',
        'first_name',
        'last_name',
        'company',
        'address',
        'email',
        'phone',
        'status',
    ];


    /*
    |--------------------------------------------------------------------------
    | Import Report
    |--------------------------------------------------------------------------
    */

    public function report()
    {
        return $this->belongsTo(
            BadMailCategory::class,
            'bad_mail_id'
        );
    }
}