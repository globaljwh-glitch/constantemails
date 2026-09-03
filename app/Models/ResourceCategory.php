<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceCategory extends Model
{
    protected $fillable = ['name', 'description', 'status'];
    public function articles()
    {
        return $this->hasMany(ResourceArticle::class, 'category_id');
    }
}
