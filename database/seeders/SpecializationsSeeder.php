<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecializationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $specializations = [
            ['name' => 'أخصائي تغذية علاجية'],
            ['name' => 'أخصائي تغذية رياضية'],
            ['name' => 'أخصائي تغذية أطفال'],
            ['name' => 'أخصائي تغذية سريرية'],
            ['name' => 'أخصائي تغذية سمنة ونحافة'],
            ['name' => 'أخصائي تغذية أمراض مزمنة'],
            ['name' => 'أخصائي تغذية أمراض الجهاز الهضمي'],
            ['name' => 'أخصائي تغذية أمراض الكلى'],
            ['name' => 'أخصائي تغذية أمراض القلب'],
            ['name' => 'أخصائي تغذية الحمل والرضاعة'],
            ['name' => 'أخصائي تغذية نباتية'],
            ['name' => 'أخصائي تغذية علاجية للأطفال'],
            ['name' => 'أخصائي تغذية علاجية للكبار'],
            ['name' => 'أخصائي تغذية علاجية للرياضيين'],
            ['name' => 'أخصائي تغذية علاجية للسكري'],
            ['name' => 'أخصائي تغذية علاجية للضغط'],
            ['name' => 'أخصائي تغذية علاجية للسرطان'],
            ['name' => 'أخصائي تغذية علاجية للحساسية'],
            ['name' => 'أخصائي تغذية علاجية للغدة الدرقية'],
            ['name' => 'أخصائي تغذية علاجية للحوامل'],
        ];

        DB::table('specializations')->insert($specializations);
    }
}
