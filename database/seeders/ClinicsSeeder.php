<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClinicsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinics = [
            [
                'name' => 'عيادة طرابلس المركز',
                'address' => 'طرابلس - شارع الاستقلال',
                'phone_number' => '0911111111',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 1,
                'active' => 1,
            ],
            [
                'name' => 'عيادة بنغازي الطبية',
                'address' => 'بنغازي - شارع جمال عبد الناصر',
                'phone_number' => '0922222222',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 2,
                'active' => 1,
            ],
            [
                'name' => 'عيادة مصراتة التخصصية',
                'address' => 'مصراتة - شارع طرابلس',
                'phone_number' => '0933333333',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 3,
                'active' => 1,
            ],
            [
                'name' => 'عيادة سبها العامة',
                'address' => 'سبها - وسط المدينة',
                'phone_number' => '0944444444',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 4,
                'active' => 1,
            ],
            [
                'name' => 'عيادة الزاوية الصحية',
                'address' => 'الزاوية - شارع المستشفى',
                'phone_number' => '0955555555',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 5,
                'active' => 1,
            ],
            [
                'name' => 'عيادة زليتن',
                'address' => 'زليتن - شارع البحر',
                'phone_number' => '0966666666',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 6,
                'active' => 1,
            ],
            [
                'name' => 'عيادة البيضاء',
                'address' => 'البيضاء - شارع الجمهورية',
                'phone_number' => '0977777777',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 7,
                'active' => 1,
            ],
            [
                'name' => 'عيادة سرت',
                'address' => 'سرت - شارع النهر',
                'phone_number' => '0988888888',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 8,
                'active' => 1,
            ],
            [
                'name' => 'عيادة درنة',
                'address' => 'درنة - شارع البحر',
                'phone_number' => '0999999999',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 9,
                'active' => 1,
            ],
            [
                'name' => 'عيادة غريان',
                'address' => 'غريان - وسط المدينة',
                'phone_number' => '0910000000',
                'url_location' => 'https://www.google.com/maps/place/32%C2%B022\'31.4%22N+15%C2%B005\'33.0%22E/@32.3754,15.0899251,17z/data=!3m1!4b1!4m4!3m3!8m2!3d32.3754!4d15.0925?entry=ttu&g_ep=EgoyMDI1MDYxNy4wIKXMDSoASAFQAw%3D%3D',
                'cities_id' => 10,
                'active' => 1,
            ],
            // ...يمكنك إضافة المزيد بنفس النمط...
        ];

        DB::table('clinics')->insert($clinics);
    }
}
