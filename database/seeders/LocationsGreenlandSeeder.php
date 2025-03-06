<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use App\Models\Country;

class LocationsGreenlandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            // Greenland
            ['country_id' => Country::where('name', 'Greenland')->first()->id, 'latitude' => 64.183547, 'longitude' => -51.708966], 
            ['country_id' => Country::where('name', 'Greenland')->first()->id, 'latitude' => 64.182738, 'longitude' => -51.708693], 
            ['country_id' => Country::where('name', 'Greenland')->first()->id, 'latitude' => 64.181253, 'longitude' => -51.709850], 
            ['country_id' => Country::where('name', 'Greenland')->first()->id, 'latitude' => 64.179831, 'longitude' => -51.710552], 
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }

    }
}
