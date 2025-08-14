<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User_Type_TableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_types')->insert([
            'name' => 'Super Admin',
            'slug'=>' النظام',
        ]);
        // DB::table('user_types')->insert([
        //     'name' => 'Admin',
        //     'slug'=>'مدير النظام',
        // ]);
        DB::table('user_types')->insert([
            'name' => 'User',
            'slug'=>'مستخدم نظام',
        ]);
       
   
    }
}
