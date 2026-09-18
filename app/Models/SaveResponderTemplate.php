<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveResponderTemplate extends Model
{
    use HasFactory;

    protected $table = 'save_responder_templates';

    protected $fillable = [
        'user_id',
        'responder_title',
        'responder_content',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}