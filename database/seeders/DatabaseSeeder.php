<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call([
        DeviceSeeder::class,
        FileTypeSeeder::class,
        JobCategorySeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
        JobCategoryHasDeviceSeeder::class,
        JobCategoryHasFileTypeSeeder::class,
        UserHasRoleSeeder::class,
      ]);

        // \App\Models\User::factory(10)->create();
        /*User::insert([
            'name' => 'Ludwig',
            'surname' => '1',
            'email' => 'Beethoven',
            'password' => bcrypt('password'),
          ]);
            User::insert([
            'name' => 'Sebastian',
            'surname' => 'Bach',
            'email' => 'tech1',
            'is_technician' => true,
            'password' => bcrypt('password'),
          ]);
          User::insert([
            'name' => 'Amadeus',
            'surname' => 'Mozart',
            'email' => 'tech2',
            'is_technician' => true,
            'password' => bcrypt('password'),
        ]);*/
    }
}
