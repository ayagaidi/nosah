<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CityTableSeeder::class,
            User_Type_TableDataSeeder::class,
            CreateAdminUserSeeder::class,
            SpecializationsSeeder::class,
            ClinicsSeeder::class,
            InbodydevicesSeeder::class,
            DoctorsSeeder::class,
            ArticlesSeeder::class,
            WhoweareSeeder::class,
            HomecontentSeeder::class,
            DietSeeder::class,
            
        ]);
    }
}
