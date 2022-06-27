<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run()
  {
    $this->call([
      DeviceSeeder::class,
      FileTypeSeeder::class,
      JobCategorySeeder::class,
      RoleSeeder::class,
      UserSeeder::class,
      DeviceJobCategorySeeder::class,
      FileTypeJobCategorySeeder::class,
      RoleUserSeeder::class,
      JobSeeder::class,
      MessageSeeder::class,
    ]);
  }
}
