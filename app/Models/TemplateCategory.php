<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateCategory extends Model
{
    use HasFactory;

    protected $table = 'template_categories';

    protected $fillable = [
        'name',
        'status',
    ];

    public function templates()
    {
        return $this->hasMany(Template::class, 'category_id');
    }
}