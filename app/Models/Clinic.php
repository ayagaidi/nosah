<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['name', 'address'];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctorassigns', 'clinics_id', 'doctors_id'); // Specify correct foreign key
    }
    public function cities()
    {
        return $this->belongsTo(City::class); // Specify correct foreign key
    }
}
