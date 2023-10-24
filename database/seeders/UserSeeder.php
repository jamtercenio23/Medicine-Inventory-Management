<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::create([
            'name' => "Admin",
            'email' => "admin@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('admin');
        // pharmacist
        $user = User::create([
            'name' => "Pharmacist",
            'email' => "pharmacist@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('pharmacist');

        $user = User::create([
            'name' => "Bacnit BHW",
            'email' => "bacnit@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Barlo BHW",
            'email' => "barlo@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Caabiangan BHW",
            'email' => "caabiangan@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Cabanaetan BHW",
            'email' => "cabanaetan@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Cabinuangan BHW",
            'email' => "cabinuangan@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Calzada BHW",
            'email' => "calzada@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Caranglaan BHW",
            'email' => "caranglaan@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "De Guzman BHW",
            'email' => "deguzman@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Luna BHW",
            'email' => "Luna@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Magalong BHW",
            'email' => "magalong@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Nibaliw BHW",
            'email' => "nibaliw@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Patar BHW",
            'email' => "patar@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Poblacion BHW",
            'email' => "poblacion@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "San Pedro BHW",
            'email' => "sanpedro@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Tagudin BHW",
            'email' => "tagudin@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');

        $user = User::create([
            'name' => "Villacorta BHW",
            'email' => "villacorta@example.com",
            'password' => Hash::make('admin'),
        ]);
        $user->assignRole('bhw');
    }
}
