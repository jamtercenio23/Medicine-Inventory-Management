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
            $numPatients = rand(5, 20);
            // $createdDate = $faker->dateTimeBetween('-2 years', 'now');
            for ($i = 0; $i < $numPatients; $i++) {
                $patientsData[] = [
                    'first_name' => $faker->firstName,
                    'last_name' => $faker->lastName,
                    'birthdate' => $faker->date('Y-m-d', '-20 years'),
                    'age' => $faker->numberBetween(18, 70),
                    'gender' => $faker->randomElement(['Male', 'Female']),
                    'barangay_id' => $barangayId,
                    'blood_pressure' =>$faker->numberBetween(60,200),
                    'heart_rate' => $faker->numberBetween(60,130),
                    'weight' => $faker->numberBetween(20,100),
                    'height' => $faker->numberBetween(130,180),
                    // 'created_at' => $createdDate,
                    'created_at' => now(),
                ];
            }
        }

        // Insert all the patient data into the database
        DB::table('patients')->insert($patientsData);
    }
}
