<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageSeeder extends Seeder
{
    public function run()
    {
        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 1,
            'sender_username' => 'client.client',
            'receiver_username' => 'worker.worker',
        ]);

        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 1,
            'sender_username' => 'worker.worker',
            'receiver_username' => 'client.client',
        ]);

        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 2,
            'sender_username' => 'client.client',
            'receiver_username' => 'worker.worker',
        ]);

        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 3,
            'sender_username' => 'client.client',
            'receiver_username' => 'worker.worker',
        ]);
    }
}
