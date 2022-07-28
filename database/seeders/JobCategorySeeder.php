<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('job_categories')->insert([
            'acronym' => 'PCBR',
            'name' => 'pcb routing / routage électronique',
            'description' => '',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'PCBA',
            'name' => 'pcb assembly / assemblage électronique',
            'description' => '',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'CAB',
            'name' => 'cablage',
            'description' => '',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'UC',
            'name' => 'usinage conventionnel',
            'description' => 'Un volume de travail de 40 x 30.5 x 13.5 cm avec une résolution mécanique de 10 μm est possible. Les matériaux utilisables sont nombreux : ABS, bois dur, Acétal, Mousses synthétiques, etc.',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'I3D',
            'name' => 'impression 3d',
            'description' => 'Réalisez vos pièces en résine allant jusqu\'à une dimension de 14.5 x 14.5 x 18.5 cm, avec une précision inégalée de 25 μm.',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'DL',
            'name' => 'découpe laser',
            'description' => 'Le découpage par laser peut se faire sur un surface de 81.3 x 50.8 cm, d\'une hauteur maximale de 18.8 cm. Possibilité de couper à travers l\'acrylique, le bois, le plastique, etc.',
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'GL',
            'name' => 'gravure laser',
            'description' => 'Gravez vos pièces sur un surface comprise jusqu\'à 19 x 19 cm, d\'une hauteur ne dépassant pas 17 cm. Les gravures font faisables sur des pièces en métal et en plastique.'
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'GPCB',
            'name' => 'gravure pcb',
            'description' => ''
        ]);

        DB::table('job_categories')->insert([
            'acronym' => 'AUT',
            'name' => 'autre',
            'description' => '',
        ]);
    }
}
