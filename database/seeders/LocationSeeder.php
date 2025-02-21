<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Country;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // Canada
            ['country_id' => Country::where('name', 'Canada')->first()->id, 'latitude' => 45.421530, 'longitude' => -75.697193], // Ottawa
            ['country_id' => Country::where('name', 'Canada')->first()->id, 'latitude' => 43.653225, 'longitude' => -79.383186], // Toronto
            ['country_id' => Country::where('name', 'Canada')->first()->id, 'latitude' => 49.282729, 'longitude' => -123.121647], // Vancouver
            ['country_id' => Country::where('name', 'Canada')->first()->id, 'latitude' => 45.501690, 'longitude' => -73.567256], // Montreal
            ['country_id' => Country::where('name', 'Canada')->first()->id, 'latitude' => 46.813878, 'longitude' => -71.208221], // Quebec City
            ['country_id' => Country::where('name', 'Canada')->first()->id, 'latitude' => 46.118797, 'longitude' => -74.585746], // Mont Tremblant

            // USA
            ['country_id' => Country::where('name', 'USA')->first()->id, 'latitude' => 40.712776, 'longitude' => -74.006015], // New York
            ['country_id' => Country::where('name', 'USA')->first()->id, 'latitude' => 34.052235, 'longitude' => -118.243683], // Los Angeles
            ['country_id' => Country::where('name', 'USA')->first()->id, 'latitude' => 41.878113, 'longitude' => -87.629799], // Chicago
            ['country_id' => Country::where('name', 'USA')->first()->id, 'latitude' => 42.360083, 'longitude' => -71.058880], // Boston
            ['country_id' => Country::where('name', 'USA')->first()->id, 'latitude' => 44.338556, 'longitude' => -68.273335], // Acadia National Park
            ['country_id' => Country::where('name', 'USA')->first()->id, 'latitude' => 44.475883, 'longitude' => -73.212072], // Burlington, Vermont

            // Japan
            ['country_id' => Country::where('name', 'Japan')->first()->id, 'latitude' => 35.689487, 'longitude' => 139.691706], // Tokyo
            ['country_id' => Country::where('name', 'Japan')->first()->id, 'latitude' => 34.693738, 'longitude' => 135.502165], // Osaka
            ['country_id' => Country::where('name', 'Japan')->first()->id, 'latitude' => 35.676192, 'longitude' => 139.650311], // Yokohama
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }}