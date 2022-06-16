<?php

namespace Database\Seeders;

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
    }
}
