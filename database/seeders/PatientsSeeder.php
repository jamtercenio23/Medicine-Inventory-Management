<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Replace the following with actual data for your patients
        $patientsData = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'birthdate' => '1990-05-15',
                'age' => 33,
                'gender' => 'Male',
                'barangay_id' => 1, // Replace with a valid barangay_id
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'birthdate' => '1985-12-10',
                'age' => 38,
                'gender' => 'Female',
                'barangay_id' => 2, // Replace with a valid barangay_id
            ],
            // Add more patient data here
        ];

        foreach ($patientsData as $patient) {
            DB::table('patients')->insert($patient);
        }
    }
}
