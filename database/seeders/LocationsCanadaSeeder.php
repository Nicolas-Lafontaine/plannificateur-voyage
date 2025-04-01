<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsCanadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
        [
            'country_id' => 1,
            'latitude' => 49.281914,
            'longitude' => -123.118986,        
        ]
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
