<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
     'name',
    ];

    
    public function cities() {
        return $this->belongsTo(City::class);
    }
  
    public function branch() {
        return $this->belongsTo(Branches::class);
    }
    public function permitRequests() {
        return $this->belongsTo(PermitRequest::class);
    }

    public function sites() {
        return $this->belongsTo(Sites::class);
    }
}

