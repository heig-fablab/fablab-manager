<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    // 1 = ADMIN
    // 2 = WORKER
    // 3 = VALIDATOR
    // 4 = CLIENT

    public function run()
    {
        // Admin users
        DB::table('role_user')->insert([
            'user_username' => 'alec.berney',
            'role_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'alec.berney',
            'role_id' => 4,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'yves.chevalli',
            'role_id' => 1,
        ]);

        DB::table('role_user')->insert([
            'user_username' => 'yves.chevalli',
            'role_id' => 4,
        ]);

        if (env('APP_ENV') != 'production') {
            DB::table('role_user')->insert([
                'user_username' => 'admin.admin',
                'role_id' => 1,
            ]);

            DB::table('role_user')->insert([
                'user_username' => 'worker.worker',
                'role_id' => 2,
            ]);

            DB::table('role_user')->insert([
                'user_username' => 'validato.validato',
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
                'user_username' => 'validato.validato',
                'role_id' => 4,
            ]);

            DB::table('role_user')->insert([
                'user_username' => 'client.client',
                'role_id' => 4,
            ]);
        }
    }
}
