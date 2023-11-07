<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class PatientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($barangayId = 1; $barangayId <= 16; $barangayId++) {
            // Generate a random number of patients for each barangay
            $numPatients = rand(5, 20); // You can adjust this range as needed

            for ($i = 0; $i < $numPatients; $i++) {
                $patientsData[] = [
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'birthdate' => $faker->date('Y-m-d', '-20 years', 'now'),
                    'age' => $faker->numberBetween(18, 70),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'barangay_id' => $barangayId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all the patient data into the database
        DB::table('patients')->insert($patientsData);
    }
}
