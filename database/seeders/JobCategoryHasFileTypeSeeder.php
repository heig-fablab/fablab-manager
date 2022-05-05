<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategoryHasFileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_category_has_file_type')->insert([
            'id_category' => 1,
            'id_file_type' => 1,
        ]);
        
        DB::table('job_category_has_file_type')->insert([
            'id_category' => 2,
            'id_file_type' => 2,
        ]);

        DB::table('job_category_has_file_type')->insert([
            'id_category' => 3,
            'id_file_type' => 3,
        ]);

        DB::table('job_category_has_file_type')->insert([
            'id_category' => 1,
            'id_file_type' => 4,
        ]);

        DB::table('job_category_has_file_type')->insert([
            'id_category' => 1,
            'id_file_type' => 5,
        ]);

        DB::table('job_category_has_file_type')->insert([
            'id_category' => 1,
            'id_file_type' => 6,
        ]);
    }
}
