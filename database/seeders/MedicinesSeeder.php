<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class MedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = range(1, 47);
        $faker = Faker::create();

        for ($i = 1; $i <= 200; $i++) {
            $isOutOfStock = $i % 3 == 0;
            $isExpired = $i % 4 == 0;

            $stock = $isOutOfStock ? 0 : rand(10, 500);
            $expirationDate = $isExpired ? now()->subDays(rand(1, 365)) : now()->addDays(rand(1, 365));
            // $createdDate = $faker->dateTimeBetween('-2 years', 'now');

            DB::table('medicines')->insert([
                'generic_name' => $faker->word,
                'brand_name' => $faker->word,
                'category_id' => $categories[array_rand($categories)],
                'price' => rand(10, 100),
                'stocks' => $stock,
                'expiration_date' => $expirationDate,
                // 'created_at' => $createdDate,
                'created_at' => now(),
            ]);
        }
    }
}
