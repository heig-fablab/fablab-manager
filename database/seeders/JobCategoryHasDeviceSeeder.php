<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategoryHasDeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_category_has_device')->insert([
            'id_category' => 1,
            'id_device' => 1,
        ]);

        DB::table('job_category_has_device')->insert([
            'id_category' => 2,
            'id_device' => 2,
        ]);

        DB::table('job_category_has_device')->insert([
            'id_category' => 3,
            'id_device' => 3,
        ]);

        DB::table('job_category_has_device')->insert([
            'id_category' => 1,
            'id_device' => 4,
        ]);
    }
}
