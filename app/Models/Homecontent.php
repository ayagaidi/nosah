<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homecontent extends Model
{
    use HasFactory;

    protected $fillable = [
        'clinics_title',
        'clinics_text',
        'inbody_title',
        'inbody_text',
        'banner_title',
        'banner_text','video_url'
    ];
}
