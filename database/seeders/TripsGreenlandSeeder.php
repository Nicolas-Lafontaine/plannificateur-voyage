<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripsGreenlandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = [
            [
                'travel_id' => 11, 
                'arrival_location' => 47, 
                'departure_location' => 46, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 0,
                'length_in_km' => 0.5,
                'duration_estimated' => '00:01:00',
                'description' => 'Première étape de mon voyage au Groenland',
                'departure_date' => '2025-03-06 08:00:00',
                'pictures' => 'greenland_trip_1.jpg'
            ],
            [
                'travel_id' => 11, 
                'arrival_location' => 48, 
                'departure_location' => 47, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 0,
                'length_in_km' => 1.5,
                'duration_estimated' => '00:01:00',
                'description' => 'Deuxième étape de mon voyage au Groenland',
                'departure_date' => '2025-03-06 08:01:00',
                'pictures' => 'greenland_trip_2.jpg'
            ],
            [
                'travel_id' => 11, 
                'arrival_location' => 49, 
                'departure_location' => 48, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 4,
                'length_in_km' => 1.0,
                'duration_estimated' => '00:01:00',
                'description' => 'Troisième étape de mon voyage au Groenland',
                'departure_date' => '2025-03-06 08:02:00',
                'pictures' => 'greenland_trip_3.jpg'
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }

}
