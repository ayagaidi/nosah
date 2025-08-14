<?php

// هذا الملف يحتوي على تعريف نموذج doctorassign
// النموذج يمثل العلاقة بين الأطباء والعيادات في قاعدة البيانات
// ويحدد الحقول القابلة للتعبئة والعلاقات مع النماذج الأخرى

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class doctorassign extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function doctors()
    {
        return $this->belongsTo(doctor::class, 'doctors_id');
    }
    public function clinics()
    {
        return $this->belongsTo(Clinic::class, 'clinics_id');
    }
    protected $fillable = [
        'doctors_id',
        'clinics_id',
        'active',
    ];
    protected $casts = [
        'active' => 'boolean',
    ];
    protected $hidden = [
        'created_at',
    ];
    
}
