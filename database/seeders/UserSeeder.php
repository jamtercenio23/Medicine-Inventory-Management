<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Barangay;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    // Create an admin user
    $user = User::create([
        'name' => "Admin",
        'email' => "admin@example.com",
        'password' => Hash::make('admin'),
        'is_active' => '1',
        'created_at' => now(),
    ]);
    $user->assignRole('admin');

    $user = User::create([
        'name' => "Backup Admin",
        'email' => "backup_admin@example.com",
        'password' => Hash::make('admin'),
        'is_active' => '1',
        'created_at' => now(),
    ]);
    $user->assignRole('admin');

    $user = User::create([
        'name' => "Super Admin",
        'email' => "superadmin@example.com",
        'password' => Hash::make('admin'),
        'is_active' => '1',
        'created_at' => now(),
    ]);

    $user->assignRole('admin');
    // Create a pharmacist user
    $user = User::create([
        'name' => "Pharmacist",
        'email' => "pharmacist@example.com",
        'password' => Hash::make('admin'),
        'is_active' => '1',
        'created_at' => now(),
    ]);
    $user->assignRole('pharmacist');

    // Create 'BHW' users for each barangay
    $barangays = [
        'Bacnit',
        'Barlo',
        'Caabiangan',
        'Cabanaetan',
        'Cabinuangan',
        'Calzada',
        'Caranglaan',
        'De-Guzman',
        'Luna',
        'Magalong',
        'Nibaliw',
        'Patar',
        'Poblacion',
        'San-Pedro',
        'Tagudin',
        'Villacorta',
    ];

    foreach ($barangays as $barangayName) {
        $barangay = Barangay::firstOrCreate(['name' => $barangayName]);

        $user = User::create([
            'name' => $barangayName . ' BHW',
            'email' => strtolower($barangayName) . "@example.com",
            'password' => Hash::make('admin'),
            'is_active' => '1',
            'barangay_id' => $barangay->id,
        ]);

        $user->assignRole('bhw');
    }
}
}
