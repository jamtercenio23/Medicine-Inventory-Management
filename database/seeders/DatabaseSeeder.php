<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\RolesAndPermissionsSeeder;
use Database\Seeders\BarangaySeeder;
use Database\Seeders\CategoriesSeeder;
use Database\Seeders\MedicinesSeeder;
use Database\Seeders\PatientsSeeder;
use Database\Seeders\BarangayPatientsSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            UserSeeder::class,
            BarangaySeeder::class,
            CategoriesSeeder::class,
            MedicinesSeeder::class,
            PatientsSeeder::class,
            BarangayPatientsSeeder::class,
        ]);
    }
}
