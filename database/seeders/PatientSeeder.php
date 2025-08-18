<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Doctor;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doctors = Doctor::all();
        
        if ($doctors->isEmpty()) {
            $this->command->error('No doctors found. Please run DoctorsSeeder first.');
            return;
        }

        // Create sample patients with realistic data
        $patients = [
            [
                'doctors_id' => $doctors->random()->id,
                'patient_number' => 'P001',
                'full_name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'password' => bcrypt('password123'),
                'dob' => '1985-03-15',
                'gender' => 'male',
                'address' => 'شارع الملك عبدالله، الرياض',
                'contact_number' => '0501234567',
                'medical_history' => 'ضغط دم مرتفع، سكر',
                'allergies' => 'مضادات حيوية من نوع البنسلين',
                'medications' => 'أدوية ضغط الدم، أدوية السكر',
                'weight' => 85,
                'height' => 175,
                'active' => 1,
                'created_at' => now(),
            ],
            [
                'doctors_id' => $doctors->random()->id,
                'patient_number' => 'P002',
                'full_name' => 'فاطمة عبدالرحمن',
                'email' => 'fatima@example.com',
                'password' => bcrypt('password123'),
                'dob' => '1990-07-22',
                'gender' => 'female',
                'address' => 'حي النرجس، الرياض',
                'contact_number' => '0502345678',
                'medical_history' => 'سمنة، ارتفاع كوليسترول',
                'allergies' => 'لا يوجد',
                'medications' => 'أدوية خفض الكوليسترول',
                'weight' => 90,
                'height' => 165,
                'active' => 1,
                'created_at' => now(),
            ],
            [
                'doctors_id' => $doctors->random()->id,
                'patient_number' => 'P003',
                'full_name' => 'خالد سعيد',
                'email' => 'khaled@example.com',
                'password' => bcrypt('password123'),
                'dob' => '1978-11-10',
                'gender' => 'male',
                'address' => 'شارع عثمان بن عفان، جدة',
                'contact_number' => '0503456789',
                'medical_history' => 'قرحة معدية',
                'allergies' => 'الأسبرين',
                'medications' => 'أدوية قرحة المعدة',
                'weight' => 78,
                'height' => 180,
                'active' => 1,
                'created_at' => now(),
            ],
            [
                'doctors_id' => $doctors->random()->id,
                'patient_number' => 'P004',
                'full_name' => 'سارة إبراهيم',
                'email' => 'sarah@example.com',
                'password' => bcrypt('password123'),
                'dob' => '1992-05-18',
                'gender' => 'female',
                'address' => 'حي الياسمين، الدمام',
                'contact_number' => '0504567890',
                'medical_history' => 'فقر دم، نقص فيتامين د',
                'allergies' => 'لا يوجد',
                'medications' => 'مكملات حديد وفيتامين د',
                'weight' => 60,
                'height' => 168,
                'active' => 1,
                'created_at' => now(),
            ],
            [
                'doctors_id' => $doctors->random()->id,
                'patient_number' => 'P005',
                'full_name' => 'محمد علي',
                'email' => 'mohamed@example.com',
                'password' => bcrypt('password123'),
                'dob' => '1988-09-25',
                'gender' => 'male',
                'address' => 'شارع الأمير سلطان، مكة',
                'contact_number' => '0505678901',
                'medical_history' => 'ربو، حساسية موسمية',
                'allergies' => 'غبار، حبوب لقاح',
                'medications' => 'بخاخات الربو، أدوية الحساسية',
                'weight' => 75,
                'height' => 172,
                'active' => 1,
                'created_at' => now(),
            ],
        ];

        foreach ($patients as $patient) {
            Patient::create($patient);
        }

        // Create additional random patients
        for ($i = 6; $i <= 15; $i++) {
            Patient::create([
                'doctors_id' => $doctors->random()->id,
                'patient_number' => 'P' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'full_name' => 'مريض ' . $i,
                'email' => 'patient' . $i . '@example.com',
                'password' => bcrypt('password123'),
                'dob' => now()->subYears(rand(20, 65))->format('Y-m-d'),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'address' => 'عنوان ' . $i . '، مدينة',
                'contact_number' => '05' . str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'medical_history' => 'لا يوجد تاريخ مرضي',
                'allergies' => 'لا يوجد',
                'medications' => 'لا يوجد',
                'weight' => rand(50, 100),
                'height' => rand(150, 190),
                'active' => 1,
                'created_at' => now(),
            ]);
        }
    }
}
