<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => '2023-01-01',
            'rating' => 1,
            'status' => 'new',
            'job_category_id' => 1,
            'client_switch_uuid' => '444@hes-so.ch',
            'worker_switch_uuid' => '222@hes-so.ch',
            'validator_switch_uuid' => '333@hes-so.ch',
        ]);

        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => '2023-01-01',
            'rating' => 2,
            'status' => 'new',
            'job_category_id' => 2,
            'client_switch_uuid' => '444@hes-so.ch',
            'worker_switch_uuid' => '222@hes-so.ch',
        ]);

        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => '2023-01-01',
            'rating' => 3,
            'status' => 'new',
            'job_category_id' => 3,
            'client_switch_uuid' => '444@hes-so.ch',
        ]);
    }
}
