<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceArticle extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'thumbnail', 'content', 'status'];
    public function category()
    {
        return $this->belongsTo(ResourceCategory::class, 'category_id');
    }
}