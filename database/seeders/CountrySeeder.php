<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['name' => 'Canada', 'housing_price_per_day' => 100, 'food_price_per_day' => 50, 'transport_price_per_day' => 25, 'average_highest_temperature' => 25, 'average_lowest_temperature' => -15],
            ['name' => 'Japan', 'housing_price_per_day' => 120, 'food_price_per_day' => 60, 'transport_price_per_day' => 30, 'average_highest_temperature' => 30, 'average_lowest_temperature' => 0],
            ['name' => 'USA', 'housing_price_per_day' => 150, 'food_price_per_day' => 70, 'transport_price_per_day' => 35, 'average_highest_temperature' => 35, 'average_lowest_temperature' => -10],
            ['name' => 'Thailand', 'housing_price_per_day' => 30, 'food_price_per_day' => 15, 'transport_price_per_day' => 10, 'average_highest_temperature' => 35, 'average_lowest_temperature' => 20],
            ['name' => 'Indonesia', 'housing_price_per_day' => 25, 'food_price_per_day' => 10, 'transport_price_per_day' => 8, 'average_highest_temperature' => 32, 'average_lowest_temperature' => 22],
            ['name' => 'Mexico', 'housing_price_per_day' => 50, 'food_price_per_day' => 20, 'transport_price_per_day' => 15, 'average_highest_temperature' => 30, 'average_lowest_temperature' => 10],
            ['name' => 'Peru', 'housing_price_per_day' => 40, 'food_price_per_day' => 18, 'transport_price_per_day' => 12, 'average_highest_temperature' => 25, 'average_lowest_temperature' => 5],
            ['name' => 'United-Kingdom', 'housing_price_per_day' => 110, 'food_price_per_day' => 55, 'transport_price_per_day' => 25, 'average_highest_temperature' => 22, 'average_lowest_temperature' => 2],
            ['name' => 'Iceland', 'housing_price_per_day' => 90, 'food_price_per_day' => 40, 'transport_price_per_day' => 20, 'average_highest_temperature' => 15, 'average_lowest_temperature' => -5],
            ['name' => 'Australia', 'housing_price_per_day' => 120, 'food_price_per_day' => 60, 'transport_price_per_day' => 30, 'average_highest_temperature' => 28, 'average_lowest_temperature' => 5],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
