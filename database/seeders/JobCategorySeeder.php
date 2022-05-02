<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('job_categories')->insert([
            'name' => 'routage électronique / electrical-routing',
        ],
        [
            'name' => 'assemblage électronique',
        ],
        [
            'name' => 'cablage',
        ],
        [
            'name' => 'usinage conventionnel',
        ],
        [
            'name' => 'impression 3d',
        ],
        [
            'name' => 'découpe laser',
        ],
        [
            'name' => 'gravure laser',
        ],
        [
            'name' => 'test',
        ],
        [
            'name' => 'autre',
        ]);

        DB::table('job_category_has_device')->insert([
            'id_category' => 0,
            'id_device' => 0,
        ],
        [
            'id_category' => 1,
            'id_device' => 1,
        ],
        [
            'id_category' => 2,
            'id_device' => 2,
        ],
        [
            'id_category' => 0,
            'id_device' => 3,
        ]);

        DB::table('job_category_has_file_type')->insert([
            'id_category' => 0,
            'id_file_type' => 0,
        ],
        [
            'id_category' => 1,
            'id_file_type' => 1,
        ],
        [
            'id_category' => 2,
            'id_file_type' => 2,
        ],
        [
            'id_category' => 0,
            'id_file_type' => 3,
        ],
        [
            'id_category' => 0,
            'id_file_type' => 4,
        ],
        [
            'id_category' => 0,
            'id_file_type' => 5,
        ]);
    }
}
