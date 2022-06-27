<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin.admin',
            'email' => 'admin@heig-vd.ch',
            'name' => 'admin',
            'surname' => 'admin',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'username' => 'worker.worker',
            'email' => 'worker@heig-vd.ch@heig-vd.ch',
            'name' => 'worker',
            'surname' => 'worker',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'username' => 'validato.validato',
            'email' => 'validator@heig-vd.ch',
            'name' => 'validator',
            'surname' => 'validator',
            'password' => Hash::make('password'),
        ]);

        DB::table('users')->insert([
            'username' => 'client.client',
            'email' => 'beral@sevjnet.ch', //'client@heig-vd.ch'
            'name' => 'client',
            'surname' => 'client',
            'password' => Hash::make('password'),
        ]);

        /*DB::table('users')->insert([
            'username' => 'alec.berney',
            'email' => 'alec.berney@heig-vd.ch',
            'name' => 'Alec',
            'surname' => 'Berney',
            'password' => Hash::make('password'),
        ]);*/
    }
}
