<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{

    public function run()
    {
        $trips = [
            [   
                'travel_id' => 19, 
                'arrival_location' => 63, 
                'departure_location' => 62, 
                'transportation_id' => 6, 
                'days_spent_at_destination' => 0,
                'length_in_km' => 2,
                'duration_estimated' => '00:30:00',     
                'description' => 'Accès à pied au sentier de Machu Picchu',
                'departure_date' => '2024-07-30 09:00:00',
                'pictures' => 'machupichu1.jpg'
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
