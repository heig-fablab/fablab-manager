<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@heig-vd.ch',
            'name' => 'admin',
            'surname' => 'admin',
            'password' => Hash::make('password'),
        ]);
        
        DB::table('users')->insert([
            'email' => 'worker@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'email' => 'validator@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'email' => 'requestor@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'password' => Hash::make('password'),
        ]);
    }
}
