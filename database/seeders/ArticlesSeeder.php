<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticlesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => 'فوائد الحمية الغذائية الصحية',
                'content' => 'تساعد الحمية الغذائية الصحية على تحسين صحة القلب وتقليل مخاطر الأمراض المزمنة مثل السكري وارتفاع ضغط الدم.',
                'users_id' => 1,
                'published' => true,
                'bkimage' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'أهمية شرب الماء في النظام الغذائي',
                'content' => 'شرب الماء بكميات كافية يومياً ضروري للحفاظ على توازن السوائل في الجسم وتعزيز عملية الهضم.',
                'users_id' => 1,
                'published' => true,
                'bkimage' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'نصائح غذائية لمرضى السكري',
                'content' => 'ينصح مرضى السكري بتناول وجبات صغيرة ومتكررة وتجنب السكريات البسيطة للحفاظ على مستوى السكر في الدم.',
                'users_id' => 1,
                'published' => true,
                'bkimage' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'أفضل الأطعمة لتعزيز المناعة',
                'content' => 'تناول الفواكه والخضروات الغنية بالفيتامينات والمعادن يساهم في تقوية جهاز المناعة.',
                'users_id' => 1,
                'published' => true,
                'bkimage' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'دور الألياف في صحة الجهاز الهضمي',
                'content' => 'الألياف الغذائية تساعد على تحسين حركة الأمعاء والوقاية من الإمساك.',
                'users_id' => 1,
                'published' => true,
                'bkimage' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('articles')->insert($articles);
    }
}
