<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->insert([
            'email' => 'admin@heig-vd.ch',
            'name' => 'admin',
            'surname' => 'admin',
            'description' => Hash::make('password'),
        ],
        [
            'email' => 'worker@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'description' => Hash::make('password'),
        ],
        [
            'email' => 'validator@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'description' => Hash::make('password'),
        ],
        [
            'email' => 'requestor@heig-vd.ch',
            'name' => Str::random(10),
            'surname' => Str::random(10),
            'description' => Hash::make('password'),
        ]);

        DB::table('user_has_role')->insert([
            'email_user' => 'admin@heig-vd.ch',
            'id_role' => 0,
        ],
        [
            'email_user' => 'worker@heig-vd.ch',
            'id_role' => 1,
        ],
        [
            'email_user' => 'validator@heig-vd.ch',
            'id_role' => 2,
        ],
        [
            'email_user' => 'requestor@heig-vd.ch',
            'id_role' => 3,
        ]);
    }
}
