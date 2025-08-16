<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HomecontentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('homecontents')->insert([
            'clinics_title' => 'العيادات',
            'clinics_text' => 'نوفر لك أفضل العيادات الطبية المتخصصة في التغذية والصحة.',
            'inbody_title' => 'أجهزة الInBody',
            'inbody_text' => 'أحدث أجهزة تحليل مكونات الجسم متوفرة لدينا لمتابعة تقدمك الصحي.',
            'banner_title' => 'مرحبًا بكم في نُصْح',
            'banner_text' => 'ابدأ رحلتك نحو صحة أفضل مع فريقنا من الأخصائيين.',
            'video_url' => 'https://www.youtube.com/watch?v=xxxxxx',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
