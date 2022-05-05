<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            'user_switch_uuid' => '111@hes-so.ch',
            'role_id' => 1,
        ]);
        
        DB::table('role_user')->insert([
            'user_switch_uuid' => '222@hes-so.ch',
            'role_id' => 2,
        ]);

        DB::table('role_user')->insert([
            'user_switch_uuid' => '333@hes-so.ch',
            'role_id' => 3,
        ]);

        DB::table('role_user')->insert([
            'user_switch_uuid' => '444@hes-so.ch',
            'role_id' => 4,
        ]);
    }
}
