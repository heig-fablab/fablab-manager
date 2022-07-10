<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    public function run()
    {
        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => Carbon::now()->addDays(10)->format('Y-m-d'),
            'rating' => null,
            'status' => 'new',
            'job_category_id' => 1,
            'client_username' => 'client.client',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => Carbon::now()->addDays(15)->format('Y-m-d'),
            'rating' => null,
            'status' => 'new',
            'job_category_id' => 2,
            'client_username' => 'client.client',
            'worker_username' => 'worker.worker',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);

        DB::table('jobs')->insert([
            'title' => Str::random(10),
            'description' => Str::random(10),
            'deadline' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'rating' => null,
            'status' => 'new',
            'job_category_id' => 3,
            'client_username' => 'client.client',
            'worker_username' => 'worker.worker',
            'validator_username' => 'validato.validato',
            'created_at' => Carbon::now()->format('Y-m-d'),
        ]);
    }
}
