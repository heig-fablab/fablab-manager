<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        ],
        [
            'name' => 'step',
        ],
        [
            'name' => 'stl',
        ],
        [
            'name' => 'pdf',
        ],
        [
            'name' => 'swlprt',
        ],
        [
            'name' => 'gcode',
        ]);
    }
}
