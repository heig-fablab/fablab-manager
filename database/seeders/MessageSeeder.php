<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 1,
            'sender_switch_uuid' => '444@hes-so.ch',
            'receiver_switch_uuid' => '222@hes-so.ch',
        ]);

        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 1,
            'sender_switch_uuid' => '222@hes-so.ch',
            'receiver_switch_uuid' => '444@hes-so.ch',
        ]);

        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 2,
            'sender_switch_uuid' => '444@hes-so.ch',
            'receiver_switch_uuid' => '222@hes-so.ch',
        ]);

        DB::table('messages')->insert([
            'text' => Str::random(10),
            'job_id' => 3,
            'sender_switch_uuid' => '444@hes-so.ch',
            'receiver_switch_uuid' => '222@hes-so.ch',
        ]);
    }
}
