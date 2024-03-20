<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('BangladeshGeocode:setup');
        $this->call([
            UserSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
    }
}