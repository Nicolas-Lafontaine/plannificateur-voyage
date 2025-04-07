<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Country;

class CountryPeruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = ['name' => 'Peru', 'housing_price_per_day' => 70, 'food_price_per_day' => 30, 'transport_price_per_day' => 20, 'average_highest_temperature' => 20, 'average_lowest_temperature' => -5];
        Country::create($country);
    }
}
