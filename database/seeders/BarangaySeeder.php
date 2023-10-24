<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class BarangaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $barangays = [
            'Bacnit',
            'Barlo',
            'Caabiangan',
            'Cabanaetan',
            'Cabinuangan',
            'Calzada',
            'Caranglaan',
            'De Guzman',
            'Luna',
            'Magalong',
            'Nibaliw',
            'Patar',
            'Poblacion',
            'San Pedro',
            'Tagudin',
            'Villacorta',
        ];

        foreach ($barangays as $barangay) {
            DB::table('barangays')->insert([
                'name' => $barangay,
            ]);
        }
    }
}
