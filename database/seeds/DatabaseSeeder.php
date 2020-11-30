<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([

            'name'=>'Admin',
            'last_name'=>'Admin',
            'email'=>'haris.muslic@purplematrix.co.uk',
            'password'=>Hash::make('Matrix2020!!'),
            'is_admin'=>true,
            
        ]);

    }
}
