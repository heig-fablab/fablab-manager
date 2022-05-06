<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceJobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('device_job_category')->insert([
            'job_category_id' => 1,
            'device_id' => 1,
        ]);

        DB::table('device_job_category')->insert([
            'job_category_id' => 2,
            'device_id' => 2,
        ]);

        DB::table('device_job_category')->insert([
            'job_category_id' => 3,
            'device_id' => 3,
        ]);

        DB::table('device_job_category')->insert([
            'job_category_id' => 1,
            'device_id' => 4,
        ]);
    }
}
