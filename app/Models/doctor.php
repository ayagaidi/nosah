<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class doctor extends Authenticatable
{
    use HasFactory, Notifiable;
    public $timestamps = false;

    protected $fillable = [
        'fullname',
        'username',
        'email',
        'phonenumber',
        'specializations_id',
        'image',
        'password',
        'active',
        'cv',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function specializations()
    {
        return $this->belongsTo(Specializations::class, 'specializations_id');
    }

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'doctorassigns', 'doctors_id', 'clinics_id');
    }
}
