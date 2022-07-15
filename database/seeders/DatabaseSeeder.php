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
          FileTypeJobCategorySeeder::class,
          RoleSeeder::class,
          FileSeeder::class,
          // Creating admin users
          UserSeeder::class,
          RoleUserSeeder::class,
      ]);

      if (env('APP_ENV') != 'production') {
          $this->call([
              JobSeeder::class,
              MessageSeeder::class,
          ]);
      }
  }
}
