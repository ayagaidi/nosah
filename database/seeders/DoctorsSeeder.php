<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoctorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = [
            [
                'fullname' => 'د. أحمد علي',
                'username' => 'ahmed.ali',
                'email' => 'ahmed.ali@example.com',
                'phonenumber' => '091111111',
                'password' => bcrypt('password123'),
                'active' => 1,
                'image' => null,
                'cv' => null,
                'specializations_id' => 1,
                'created_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'fullname' => 'د. فاطمة محمد',
                'username' => 'fatima.mohamed',
                'email' => 'fatima.mohamed@example.com',
                'phonenumber' => '092222222',
                'password' => bcrypt('password123'),
                'active' => 1,
                'image' => null,
                'cv' => null,
                'specializations_id' => 2,
                'created_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'fullname' => 'د. يوسف سالم',
                'username' => 'yousef.salem',
                'email' => 'yousef.salem@example.com',
                'phonenumber' => '093333333',
                'password' => bcrypt('password123'),
                'active' => 1,
                'image' => null,
                'cv' => null,
                'specializations_id' => 3,
                'created_at' => now(),
                'remember_token' => Str::random(10),
            ],
        ];

        DB::table('doctors')->insert($doctors);
    }
}
