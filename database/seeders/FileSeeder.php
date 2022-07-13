<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FileSeeder extends Seeder
{
    public function run()
    {
        // Add job category files to the seeder
        // Watch README for more info
        for ($i = 1; $i <= JobCategory::all()->count(); $i+=1) {
            DB::table('files')->insert([
                'name' => 'cat' . $i . '.jpg',
                'hash' => 'cat' . $i . '.jpg',
                'directory' => 'images',
                'file_type_id' => 8,
                'job_id' => null,
                'job_category_id' => $i,
            ]);
        }
    }
}
