<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('file_types')->insert([
            'name' => 'dxf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'step',
        ]);

        DB::table('file_types')->insert([
            'name' => 'stl',
        ]);

        DB::table('file_types')->insert([
            'name' => 'pdf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'swlprt',
        ]);

        DB::table('file_types')->insert([
            'name' => 'gcode',
        ]);
    }
}
