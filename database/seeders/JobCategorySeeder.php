<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'acronym' => 'REI',
            'name' => 'routage électronique / electrical-routing',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'AEI',
            'name' => 'assemblage électronique',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'CAB',
            'name' => 'cablage',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'UC',
            'name' => 'usinage conventionnel',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'I3D',
            'name' => 'impression 3d',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'DL',
            'name' => 'découpe laser',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'GL',
            'name' => 'gravure laser',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'TE',
            'name' => 'test',
        ]);
        
        DB::table('job_categories')->insert([
            'acronym' => 'OTH',
            'name' => 'autre',
        ]);

        /*DB::table('job_category_has_device')->insert([
            'id_category' => 1,
            'id_device' => 1,
        ],
        [
            'id_category' => 2,
            'id_device' => 2,
        ],
        [
            'id_category' => 3,
            'id_device' => 3,
        ],
        [
            'id_category' => 1,
            'id_device' => 4,
        ]);

        DB::table('job_category_has_file_type')->insert([
            'id_category' => 1,
            'id_file_type' => 1,
        ],
        [
            'id_category' => 2,
            'id_file_type' => 2,
        ],
        [
            'id_category' => 3,
            'id_file_type' => 3,
        ],
        [
            'id_category' => 1,
            'id_file_type' => 4,
        ],
        [
            'id_category' => 1,
            'id_file_type' => 5,
        ],
        [
            'id_category' => 1,
            'id_file_type' => 6,
        ]);*/
    }
}
