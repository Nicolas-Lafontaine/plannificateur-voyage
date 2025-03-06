<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryGreenlandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = ['name' => 'Greenland', 'housing_price_per_day' => 150, 'food_price_per_day' => 70, 'transport_price_per_day' => 50, 'average_highest_temperature' => 5, 'average_lowest_temperature' => -20];
        Country::create($country);
    }
}
