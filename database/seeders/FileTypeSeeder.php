<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeSeeder extends Seeder
{
    // Refs:
    // https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types
    // https://www.digipres.org/formats/mime-types/
    public function run()
    {
        DB::table('file_types')->insert([
            'name' => 'dxf',
            'mime_type' => 'image/x-dxf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'step',
            'mime_type' => 'application/STEP',
        ]);

        DB::table('file_types')->insert([
            'name' => 'stl',
            'mime_type' => 'application/stl',
        ]); // TODO: to validate

        DB::table('file_types')->insert([
            'name' => 'pdf',
            'mime_type' => 'application/pdf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'swlprt',
            'mime_type' => 'application/swlprt',
        ]); // TODO: to validate

        DB::table('file_types')->insert([
            'name' => 'gcode',
            'mime_type' => 'text/x-gcode',
        ]); // TODO: to validate

        DB::table('file_types')->insert([
            'name' => 'png',
            'mime_type' => 'image/png',
        ]);

        DB::table('file_types')->insert([
            'name' => 'jpg',
            'mime_type' => 'image/jpeg',
        ]);

        DB::table('file_types')->insert([
            'name' => 'jpeg',
            'mime_type' => 'image/jpeg',
        ]);

        DB::table('file_types')->insert([
            'name' => 'svg',
            'mime_type' => 'image/svg+xml',
        ]);
    }
}
