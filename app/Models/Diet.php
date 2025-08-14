<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'image',
        'published'
    ];

      protected $casts = [
        'published' => 'boolean',
        'created_at' => 'datetime',
    ];


}
