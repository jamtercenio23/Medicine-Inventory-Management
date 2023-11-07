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
        $categories = [1, 2, 3, 4, 5]; // Replace with your actual category IDs
        $faker = Faker::create();

        for ($i = 1; $i <= 100; $i++) {
            $isOutOfStock = $i % 3 == 0; // Every third medicine is out of stock
            $isExpired = $i % 4 == 0; // Every fourth medicine is expired

            $stock = $isOutOfStock ? 0 : rand(10, 100);
            $expirationDate = $isExpired ? now()->subDays(rand(1, 365)) : now()->addDays(rand(1, 365));

            DB::table('medicines')->insert([
                'generic_name' => $faker->word,
                'brand_name' => $faker->word,
                'category_id' => $categories[array_rand($categories)],
                'price' => rand(10, 100),
                'stocks' => $stock,
                'expiration_date' => $expirationDate,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
