<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'thumbnail', 'content', 'status'];

    // Define the relationship to Category
    public function category()
    {
        return $this->belongsTo(TemplateCategory::class, 'category_id');
    }
}