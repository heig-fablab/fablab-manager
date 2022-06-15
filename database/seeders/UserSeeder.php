<?php

namespace Database\Seeders;

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
            'switch_uuid' => '111@hes-so.ch',
            'email' => 'admin@heig-vd.ch',
            'name' => 'admin',
            'surname' => 'admin',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'switch_uuid' => '222@hes-so.ch',
            'email' => 'alec.berney@heig-vd.ch', //'worker@heig-vd.ch'
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'switch_uuid' => '333@hes-so.ch',
            'email' => 'validator@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'switch_uuid' => '444@hes-so.ch',
            'email' => 'beral@sevjnet.ch', //'client@heig-vd.ch'
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'password' => Hash::make('password'),
        ]);
    }
}
