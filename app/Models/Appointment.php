<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'clinic_id', 'scheduled_at', 'status',
        'rescheduled_at', 'reschedule_reason', 'location', 'appointment_type',
        'created_by', 'updated_by', 'notes'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'rescheduled_at' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
}
