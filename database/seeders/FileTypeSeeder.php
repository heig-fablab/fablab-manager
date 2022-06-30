<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('file_types')->insert([
            'name' => 'dxf',
            'mime_type' => 'application/dxf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'step',
            'mime_type' => 'application/step',
        ]);

        DB::table('file_types')->insert([
            'name' => 'stl',
            'mime_type' => 'application/stl',
        ]);

        DB::table('file_types')->insert([
            'name' => 'pdf',
            'mime_type' => 'application/pdf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'swlprt',
            'mime_type' => 'application/swlprt',
        ]);

        DB::table('file_types')->insert([
            'name' => 'gcode',
            'mime_type' => 'application/gcode',
        ]);
    }
}
