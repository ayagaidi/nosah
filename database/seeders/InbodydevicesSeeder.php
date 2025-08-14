<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InbodydevicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [
            [
                'place_name' => 'مركز طرابلس الصحي',
                'cities_id' => 1,
                'device_model' => 'InBody 770',
                'url' => 'https://maps.google.com/?q=32.8872,13.1913',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'place_name' => 'عيادة بنغازي الطبية',
                'cities_id' => 2,
                'device_model' => 'InBody 570',
                'url' => 'https://maps.google.com/?q=32.1167,20.0667',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'place_name' => 'مركز مصراتة للأجهزة الطبية',
                'cities_id' => 3,
                'device_model' => 'InBody 230',
                'url' => 'https://maps.google.com/?q=32.3754,15.0925',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'place_name' => 'مركز سبها الصحي',
                'cities_id' => 4,
                'device_model' => 'InBody 120',
                'url' => 'https://maps.google.com/?q=27.0377,14.4283',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'place_name' => 'مركز الزاوية للأجهزة الطبية',
                'cities_id' => 5,
                'device_model' => 'InBody 270',
                'url' => 'https://maps.google.com/?q=32.7614,12.7278',
                'active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('inbodydevices')->insert($devices);
    }
}
