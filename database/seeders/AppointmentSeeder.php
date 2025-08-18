<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Clinic;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get existing patients and doctors
        $patients = Patient::all();
        $doctors = Doctor::all();
        $clinics = Clinic::all();

        // Create appointments for each patient
        foreach ($patients as $patient) {
            // Create 2-3 appointments per patient
            $appointmentCount = rand(2, 3);
            
            for ($i = 0; $i < $appointmentCount; $i++) {
                Appointment::create([
                    'patient_id' => $patient->id,
                    'doctor_id' => $patient->doctors_id ?? $doctors->random()->id,
                    'clinic_id' => $clinics->random()->id,
                    'scheduled_at' => now()->addDays(rand(1, 30))->addHours(rand(8, 17)),
                    'status' => $this->getRandomStatus(),
                    'appointment_type' => $this->getRandomAppointmentType(),
                    'location' => 'Clinic Location',
                    'notes' => 'Follow-up appointment',
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }

    /**
     * Get random appointment status
     *
     * @return string
     */
    private function getRandomStatus()
    {
        $statuses = ['scheduled', 'confirmed', 'completed', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }

    /**
     * Get random appointment type
     *
     * @return string
     */
    private function getRandomAppointmentType()
    {
        $types = ['consultation', 'follow-up', 'check-up', 'emergency'];
        return $types[array_rand($types)];
    }
}
