<?php

namespace Database\Seeders;

//use App\Models\File;
use App\Models\JobCategory;
use Illuminate\Database\Seeder;
//use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
{
    public function run()
    {
        // Doesn't work yet
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

        // Add job category files to the seeder
        // Watch README for more info
        for ($i = 1; $i <= JobCategory::all()->count(); $i+=1) {
            DB::table('files')->insert([
                'name' => 'cat' . $i . 'png',
                'hash' => 'cat' . $i,
                'directory' => 'ca',
                'file_type_id' => 7,
                'job_id' => null,
                'job_category_id' => $i,
            ]);
        }
    }
}
