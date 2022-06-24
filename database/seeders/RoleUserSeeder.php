<?php

namespace Database\Seeders;

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
            'user_username' => 'admin.admin',
            'role_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'worker.worker',
            'role_id' => 2,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'validator.validator',
            'role_id' => 3,
        ]);

        // They are also all clients
        DB::table('role_user')->insert([
            'user_username' => 'admin.admin',
            'role_id' => 4,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'worker.worker',
            'role_id' => 4,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'validator.validator',
            'role_id' => 4,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'client.client',
            'role_id' => 4,
        ]);
    }
}
