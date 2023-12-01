<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'Pain Relief',
            'Antibiotics',
            'Vitamins',
            'Cough and Cold',
            'Digestive Health',
            // 'Analgesics',
            // 'Anesthetics',
            // 'Anti-addiction agents',
            // 'Antibacterials',
            // 'Anticonvulsants',
            // 'Antidementia agents',
            // 'Antidepressants',
            // 'Antiemetics',
            // 'Antifungals',
            // 'Antigout agents',
            // 'Antimigraine agents',
            // 'Antimyasthenic agents',
            // 'Antimycobacterials',
            // 'Antineoplastics',
            // 'Antiparasitics',
            // 'Antiparkinson agents',
            // 'Antipsychotics',
            // 'Antispasticity agents',
            // 'Antivirals',
            // 'Anxiolytics',
            // 'Bipolar agents',
            // 'Blood glucose regulators',
            // 'Blood products',
            // 'Cardiovascular agents',
            // 'Central nervous system agents',
            // 'Dental and oral agents',
            // 'Dermatological agents',
            // 'Electrolytes, minerals, metals, vitamins',
            // 'Gastrointestinal agents',
            // 'Genetic/enzyme/protein disorder agents',
            // 'Genitourinary agents',
            // 'Hormonal agents (adrenal)',
            // 'Hormonal agents (pituitary)',
            // 'Hormonal agents (prostaglandins)',
            // 'Hormonal agents (sex hormones)',
            // 'Hormonal agents (thyroid)',
            // 'Hormone suppressant (adrenal)',
            // 'Hormone suppressant (pituitary)',
            // 'Hormone suppressant (thyroid)',
            // 'Immunological agents',
            // 'Inflammatory bowel disease agents',
            // 'Metabolic bone disease agents',
            // 'Ophthalmic agents',
            // 'Otic agents',
            // 'Respiratory tract agents',
            // 'Skeletal muscle relaxants',
            // 'Sleep disorder agents',
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName,
            ]);
        }
    }
}
