<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PatientDietPlan;
use App\Models\Patient;
use App\Models\Diet;

class PatientDietPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $patients = Patient::all();
        $diets = Diet::all();

        foreach ($patients as $patient) {
            // Assign 1-2 diet plans per patient
            $dietCount = rand(1, 2);
            $assignedDiets = $diets->random($dietCount);
            
            foreach ($assignedDiets as $diet) {
                PatientDietPlan::create([
                    'patient_id' => $patient->id,
                    'diet_id' => $diet->id,
                    'start_date' => now()->subDays(rand(1, 30)),
                    'end_date' => now()->addDays(rand(30, 90)),
                    'notes' => 'Diet plan assigned for patient',
                    'created_by' => 1,
                    'updated_by' => 1,
                ]);
            }
        }
    }
}
