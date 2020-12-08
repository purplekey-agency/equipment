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

            'name'=>'Haris',
            'last_name'=>'Muslic',
            'email'=>'haris.muslic@purplematrix.co.uk',
            'password'=>Hash::make('Matrix2020!!'),
            'is_admin'=>true,
            
        ]);

        DB::table('users')->insert([

            'name'=>'Mirza',
            'last_name'=>'Piric',
            'email'=>'mirza@purplematrix.co.uk',
            'password'=>Hash::make('Matrix2020!!'),
            'is_admin'=>true,
            
        ]);

        DB::table('users')->insert([

            'name'=>'Nadža',
            'last_name'=>'Karić',
            'email'=>'nadza@purplematrix.co.uk',
            'password'=>Hash::make('Matrix2020!!'),
            'is_admin'=>true,
            
        ]);

        DB::table('users')->insert([

            'name'=>'Đorđe',
            'last_name'=>'Jovanović',
            'email'=>'djordje@purplematrix.co.uk',
            'password'=>Hash::make('Matrix2020!!'),
            'is_admin'=>true,
            
        ]);

        DB::table('users')->insert([

            'name'=>'Mahira',
            'last_name'=>'Hadžić',
            'email'=>'mahira@purplematrix.co.uk',
            'password'=>Hash::make('Matrix2020!!'),
            'is_admin'=>true,
            
        ]);

    }
}
