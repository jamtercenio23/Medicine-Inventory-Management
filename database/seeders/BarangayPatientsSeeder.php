<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class BarangayPatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($barangayId = 1; $barangayId <= 16; $barangayId++) {
            $numPatients = rand(5, 5);
            // $createdDate = $faker->dateTimeBetween('-2 years', 'now');
            for ($i = 0; $i < $numPatients; $i++) {
                $patientsData[] = [
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'birthdate' => $faker->date('Y-m-d', '-20 years'),
                    'age' => $faker->numberBetween(18, 70),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'barangay_id' => $barangayId,
                    // 'created_at' => $createdDate,
                    'created_at' => now(),
                ];
            }
        }

        // Insert all the patient data into the database
        DB::table('barangay_patients')->insert($patientsData);
    }
}
