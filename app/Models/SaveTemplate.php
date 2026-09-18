<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveTemplate extends Model
{
    use HasFactory;

    protected $table = 'save_templates';

    protected $fillable = [
        'user_id',
        'template_title',
        'template_content',
        'session_id',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}