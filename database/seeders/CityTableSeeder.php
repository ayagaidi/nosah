<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            ['name' => 'طرابلس'],
            ['name' => 'بنغازي'],
            ['name' => 'مصراتة'],
            ['name' => 'سبها'],
            ['name' => 'الزاوية'],
            ['name' => 'زليتن'],
            ['name' => 'البيضاء'],
            ['name' => 'سرت'],
            ['name' => 'درنة'],
            ['name' => 'غريان'],
            ['name' => 'طبرق'],
            ['name' => 'اجدابيا'],
            ['name' => 'الخمس'],
            ['name' => 'صبراتة'],
            ['name' => 'ترهونة'],
            ['name' => 'مرزق'],
            ['name' => 'نالوت'],
            ['name' => 'بني وليد'],
            ['name' => 'زوارة'],
            ['name' => 'شحات'],
        ]);
    }
}
