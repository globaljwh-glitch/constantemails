<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BadMailCategory extends Model
{
    use HasFactory;

    protected $table = 'bad_mail_category';

    protected $fillable = [
        'user_id',
        'upload_date',
        'file_name',
        'added',
        'rejected',
        'status',
    ];

    protected $casts = [
        'upload_date' => 'date',
    ];


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
    | Rejected Contacts
    |--------------------------------------------------------------------------
    */

    public function badContacts()
    {
        return $this->hasMany(
            BadMailList::class,
            'bad_mail_id'
        );
    }
}