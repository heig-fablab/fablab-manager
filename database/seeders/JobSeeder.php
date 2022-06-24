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
            'rating' => null,
            'status' => 'new',
            'job_category_id' => 1,
            'client_username' => 'client.client',
        ]);

        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => '2023-01-01',
            'rating' => null,
            'status' => 'new',
            'job_category_id' => 2,
            'client_username' => 'client.client',
            'worker_username' => 'worker.worker',
        ]);

        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => '2023-01-01',
            'rating' => null,
            'status' => 'new',
            'job_category_id' => 3,
            'client_username' => 'client.client',
            'worker_username' => 'worker.worker',
            'validator_username' => 'validator.validator',
        ]);
    }
}
