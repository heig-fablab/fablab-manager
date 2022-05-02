<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->insert([
            'name' => 'Formlabs Form 3',
            'image_path' => Str::random(10),
            'description' => 'Avec cette imprimante industrielle, réalisez vos pièces en résine allant jusqu\'à une dimension de 14.5 x 14.5 x 18.5 cm, avec une précision inégalée de 25 μm.',
        ]);

        DB::table('devices')->insert([
            'name' => 'Roland MDX-50',
            'image_path' => Str::random(10),
            'description' => 'Cette fraiseuse à commande numérique possède un volume de travail de 40 x 30.5 x 13.5 cm à une résolution mécanique de 10 μm. Les matériaux utilisables sont nombreux : ABS, bois dur, Acétal, Mousses synthétiques, etc.',
        ]);

        DB::table('devices')->insert([
            'name' => 'Trotec SpeedMarker 300',
            'image_path' => Str::random(10),
            'description' => 'Gravez vos pièces avec ce laser à fibre sur un surface comprise jusqu\'à 19 x 19 cm, d\'une hauteur ne dépassant pas 17 cm. Les gravures font faisables sur des pièces en métal et en plastique.',
        ]);
        
        DB::table('devices')->insert([
            'name' => 'Trotec Speedy 360',
            'image_path' => Str::random(10),
            'description' => 'Le découpage par laser peut se faire sur un surface de 81.3 x 50.8 cm, d\'une hauteur maximale de 18.8 cm. La machine est capable de couper à travers l\'acrylique, le bois, le plastique, etc.',
        ]);
    }
}
