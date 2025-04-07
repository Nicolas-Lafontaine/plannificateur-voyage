<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationsPeruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            [
                'country_id' => 12,
                'latitude' => -13.161436,
                'longitude' => -72.536649,     // début de la route en voiture machupichu   id = 61
            ],
            [
                'country_id' => 12,
                'latitude' => -13.165902,
                'longitude' => -72.542843,     // fin de la route en voiture machupichu    id = 62
            ],
            [
                'country_id' => 12,
                'latitude' => -13.166858,
                'longitude' => -72.544355,     // début du sentier à pied machupichu      id = 63
            ],
            [
                'country_id' => 12,
                'latitude' => -13.174620,
                'longitude' => -72.542126,     // fin du sentier à pied machupichu      id = 64
            ]
            ];
    
            foreach ($locations as $location) {
                Location::create($location);
            }    
    }
}
