<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;

class FileSeeder extends Seeder
{
    // TODO: Add job category files to the seeder
    // Doesn't work yet
    // Need to do it manually via API and PUT method
    public function run()
    {
        /*$filesystem = new Filesystem();
        //$images = $filesystem->allFiles('./database/seeders/images');
        $images = $filesystem->allFiles('./database/seeders/images');

        $cpt = 1;
        foreach ($images as $image) {
            $file = File::store_file($image, null);
            JobCategory::findOrFail($cpt)
                ->file->attach($file->id)
                ->save();
            $cpt += 1;
        }*/
    }
}
