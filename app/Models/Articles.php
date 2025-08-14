<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{
    use HasFactory;

    protected $table = 'articles';

    protected $fillable = [
        'title',
        'content',
        'author',
        'users_id',
        'published',
        'bkimage',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];
    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    public function getPublishedAttribute($value)
    {
        return (bool) $value;
    }
    public function setPublishedAttribute($value)
    {
        $this->attributes['published'] = (bool) $value;
    }
   
}

