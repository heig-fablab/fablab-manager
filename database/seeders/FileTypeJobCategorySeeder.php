<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeJobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 1,
        ]);
        
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 2,
            'file_type_id' => 2,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 3,
            'file_type_id' => 3,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 4,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 5,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 6,
        ]);
    }
}
