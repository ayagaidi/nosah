<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Patient extends Authenticatable
{
    use HasFactory;

    protected $table = 'patients';

    protected $guard = 'patient';

    protected $fillable = [
        'doctors_id',
        'patient_number', // add patient_number
        'full_name',
        'email',
        'password',
        'dob',
        'gender',
        'address',
        'contact_number',
        'medical_history',
        'allergies',
        'medications',
        'weight',
        'height',
        'active',
        'created_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public $timestamps = false;


    // علاقة مع الطبيب
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctors_id');
    }
    public function files()
    {
        return $this->hasMany(PatientFile::class, 'patient_id');
    }
}
