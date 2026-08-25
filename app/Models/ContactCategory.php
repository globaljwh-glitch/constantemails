<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactCategory extends Model
{
    protected $table = 'contact_categories';

    protected $fillable = [
        'category_name',
        'status',
    ];

    public function groups()
    {
        return $this->hasMany(Group::class, 'category_id');
    }
    
}
