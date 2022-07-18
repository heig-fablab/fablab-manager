<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeJobCategorySeeder extends Seeder
{
    // TODO: adapt with given file types by m. Chevallier
    public function run()
    {
        // pcb routing
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 1,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 2,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 1,
            'file_type_id' => 3,
        ]);

        // pcb assembly
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 2,
            'file_type_id' => 7,
        ]);

        // cablage
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 3,
            'file_type_id' => 7,
        ]);

        // usinage conventionnel
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 4,
            'file_type_id' => 8,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 4,
            'file_type_id' => 9,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 4,
            'file_type_id' => 10,
        ]);

        // 3d printing
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 5,
            'file_type_id' => 8,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 5,
            'file_type_id' => 11,
        ]);

        // découpe laser
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 6,
            'file_type_id' => 12,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 6,
            'file_type_id' => 13,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 6,
            'file_type_id' => 14,
        ]);

        // gravure laser
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 7,
            'file_type_id' => 12,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 7,
            'file_type_id' => 13,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 7,
            'file_type_id' => 14,
        ]);

        // gravure pcb
        DB::table('file_type_job_category')->insert([
            'job_category_id' => 8,
            'file_type_id' => 1,
        ]);

        DB::table('file_type_job_category')->insert([
            'job_category_id' => 8,
            'file_type_id' => 15,
        ]);

        // test

        // autre
    }
}
