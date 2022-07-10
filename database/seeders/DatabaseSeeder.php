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
      ]);

      if (env('APP_ENV') != 'production') {
          $this->call([
              UserSeeder::class,
              RoleUserSeeder::class,
              JobSeeder::class,
              MessageSeeder::class,
          ]);
      }
  }
}
