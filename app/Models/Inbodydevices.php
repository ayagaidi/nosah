<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbodydevices extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['url', 'place_name', 'cities_id', 'device_model'];

    public function cities()
    {
        return $this->belongsTo(City::class);
    }
}
