<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin users
        DB::table('users')->insert([
            'username' => 'alec.berney',
            'email' => 'alec.berney@heig-vd.ch',
            'name' => 'Alec',
            'surname' => 'Berney',
        ]);

        DB::table('users')->insert([
            'username' => 'yves.chevalli',
            'email' => 'yves.chevallier@heig-vd.ch',
            'name' => 'Yves',
            'surname' => 'Chevallier',
        ]);

        // Dev test users
        if (env('APP_ENV') != 'production') {
            DB::table('users')->insert([
                'username' => 'admin.admin',
                'email' => 'admin@heig-vd.ch',
                'name' => 'admin',
                'surname' => 'admin',
            ]);

            DB::table('users')->insert([
                'username' => 'worker.worker',
                'email' => 'worker@heig-vd.ch',
                'name' => 'worker',
                'surname' => 'worker',
            ]);

            DB::table('users')->insert([
                'username' => 'validato.validato',
                'email' => 'validator@heig-vd.ch',
                'name' => 'validator',
                'surname' => 'validator',
            ]);

            DB::table('users')->insert([
                'username' => 'client.client',
                'email' => 'client@heig-vd.ch',
                'name' => 'client',
                'surname' => 'client',
            ]);
        }
    }
}
