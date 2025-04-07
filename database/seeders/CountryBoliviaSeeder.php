<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryBoliviaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = ['name' => 'Bolivia', 'housing_price_per_day' => 80, 'food_price_per_day' => 35, 'transport_price_per_day' => 25, 'average_highest_temperature' => 25, 'average_lowest_temperature' => 0];
        Country::create($country);
    }
}
