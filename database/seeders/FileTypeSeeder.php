<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileTypeSeeder extends Seeder
{
    // Refs:
    // https://developer.mozilla.org/fr/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types
    // https://www.digipres.org/formats/mime-types/
    // http://et.engr.iupui.edu/~dskim/tutorials/misc/
    public function run()
    {
        // For pcb routing
        DB::table('file_types')->insert([
            'name' => 'zip',
            'mime_type' => 'application/zip',
        ]);

        DB::table('file_types')->insert([
            'name' => 'rar',
            'mime_type' => 'application/x-rar-compressed',
        ]);

        DB::table('file_types')->insert([
            'name' => '7z',
            'mime_type' => 'application/x-7z-compressed',
        ]);

        DB::table('file_types')->insert([
            'name' => 'PcbDoc',
            'mime_type' => null,
        ]);

        DB::table('file_types')->insert([
            'name' => 'PrjPcb',
            'mime_type' => null,
        ]);

        DB::table('file_types')->insert([
            'name' => 'SchDoc',
            'mime_type' => null,
        ]);

        // For pcb assembly + cablage
        DB::table('file_types')->insert([
            'name' => 'pdf',
            'mime_type' => 'application/pdf',
        ]);

        // For usinage conventionnel
        DB::table('file_types')->insert([
            'name' => 'step',
            'mime_type' => 'application/STEP',
        ]);

        DB::table('file_types')->insert([
            'name' => 'Sldprt',
            'mime_type' => null,
        ]);

        DB::table('file_types')->insert([
            'name' => 'iges',
            'mime_type' => 'application/iges',
        ]);

        // For 3d printing
        DB::table('file_types')->insert([
            'name' => 'stl',
            'mime_type' => null,
        ]);
        // + step

        // For découpe et gravure laser
        DB::table('file_types')->insert([
            'name' => 'dxf',
            'mime_type' => 'application/dxf',
        ]);

        DB::table('file_types')->insert([
            'name' => 'svg',
            'mime_type' => 'image/svg+xml',
        ]);

        DB::table('file_types')->insert([
            'name' => 'ai',
            'mime_type' => 'application/postscript',
        ]);

        // For gravure pcb
        DB::table('file_types')->insert([
            'name' => 'gbr',
            'mime_type' => null,
        ]);
        // + zip

        // For job category images
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
    }
}
