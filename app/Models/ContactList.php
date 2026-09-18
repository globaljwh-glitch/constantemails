<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactList extends Model
{
    protected $table = 'contact_lists';

    protected $guarded = [];

    public function groups()
    {
        return $this->belongsToMany(
            Group::class,
            'contact_group',
            'contact_id',
            'group_id'
        );
    }
}