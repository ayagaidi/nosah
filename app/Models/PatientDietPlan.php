<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDietPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'meal_type',
        'food_category',
        'food_item',
        'portion_size',
        'calories',
        'carbs',
        'protein',
        'fat',
        'fiber',
        'fluid_intake',
        'supplements',
        'special_instructions',
        'dietary_restrictions',
        'compliance_notes',
        'prescribed_by',
        'date_prescribed',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // إضافة العلاقة مع الطبيب
    public function doctor()
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'prescribed_by');
    }
}
