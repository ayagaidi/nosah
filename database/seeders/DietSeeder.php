<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DietSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('diets')->insert([
            [
                'title' => 'حمية غذائية متوازنة',
                'text' => 'هذه الحمية تعتمد على تناول جميع العناصر الغذائية بشكل متوازن وتشمل الخضروات والفواكه والبروتينات والكربوهيدرات الصحية.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'published'=>1,
            ],
            [
                'title' => 'حمية منخفضة الكربوهيدرات',
                'text' => 'تركز هذه الحمية على تقليل الكربوهيدرات وزيادة البروتين والخضروات، وتناسب من يرغب في فقدان الوزن بسرعة.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
                                'published'=>1,

            ],
            [
                'title' => 'حمية البحر الأبيض المتوسط',
                'text' => 'تعتمد على زيت الزيتون، الأسماك، الخضروات، الفواكه، والحبوب الكاملة، وتعتبر من أفضل الحميات لصحة القلب.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
                                'published'=>1,

            ],
        ]);
    }
}
