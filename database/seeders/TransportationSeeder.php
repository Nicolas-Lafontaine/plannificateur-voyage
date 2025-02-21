<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transportation;

class TransportationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $transportations = [
            ['name' => 'Car', 'co2_emission_per_km_grams' => 220], // 120 grams of CO2 per km
            ['name' => 'Bus', 'co2_emission_per_km_grams' => 29.4], // 30 grams of CO2 per km
            ['name' => 'Bicycle', 'co2_emission_per_km_grams' => 0], // No CO2 emissions
            ['name' => 'Train', 'co2_emission_per_km_grams' => 30], // 50 grams of CO2 per km
            ['name' => 'Plane', 'co2_emission_per_km_grams' => 260], // 260 grams of CO2 per km
            ['name' => 'Walking', 'co2_emission_per_km_grams' => 0], // No CO2 emissions
        ];

        foreach ($transportations as $transportation) {
            Transportation::create($transportation);
        }
    }
}
