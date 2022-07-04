<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    $this->call([
        FileTypeSeeder::class,
        JobCategorySeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
        FileTypeJobCategorySeeder::class,
        RoleUserSeeder::class,
        JobSeeder::class,
        MessageSeeder::class,
        FileSeeder::class,
    ]);
  }
}
