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
            $numPatients = rand(5, 100); // You can adjust this range as needed
            $createdDate = $faker->dateTimeBetween('-2 years', 'now');
            for ($i = 0; $i < $numPatients; $i++) {
                $patientsData[] = [
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'birthdate' => $faker->date('Y-m-d', '-20 years', 'now'),
                    'age' => $faker->numberBetween(18, 70),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'barangay_id' => $barangayId,
                    'blood_pressure' =>$faker->numberBetween(60,200),
                    'heart_rate' => $faker->numberBetween(60,130),
                    'weight' => $faker->numberBetween(20,100),
                    'height' => $faker->numberBetween(130,180),
                    'created_at' => $createdDate,
                ];
            }
        }

        // Insert all the patient data into the database
        DB::table('patients')->insert($patientsData);
    }
}
