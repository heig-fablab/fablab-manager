<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_has_role')->insert([
            'email_user' => 'admin@heig-vd.ch',
            'id_role' => 1,
        ]);
        
        DB::table('user_has_role')->insert([
            'email_user' => 'worker@heig-vd.ch',
            'id_role' => 2,
        ]);

        DB::table('user_has_role')->insert([
            'email_user' => 'validator@heig-vd.ch',
            'id_role' => 3,
        ]);

        DB::table('user_has_role')->insert([
            'email_user' => 'requestor@heig-vd.ch',
            'id_role' => 4,
        ]);
    }
}
