<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageGallery extends Model
{
    use HasFactory;

    protected $table = 'image_galleries';

    protected $fillable = [
        'user_id',
        'image',
        'size',
        'type',
        'caption',
    ];

    protected $casts = [
        'size' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}