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
                'travel_id' => 15, 
                'arrival_location' => 56, 
                'departure_location' => 55, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 0,
                'length_in_km' => 200.5,
                'duration_estimated' => '02:00:00',
                'description' => 'Arrivée à Ottawa',
                'departure_date' => '2024-07-30 08:00:00',
                'pictures' => 'canada1.jpg'
            ],
            [
                'travel_id' => 15, 
                'arrival_location' => 57, 
                'departure_location' => 56, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 1,
                'length_in_km' => 200.5,
                'duration_estimated' => '02:00:00',
                'description' => 'Arrivée à Toronto',
                'departure_date' => '2024-07-30 08:00:00',
                'pictures' => 'canada1.jpg'
            ],
            [
                'travel_id' => 15, 
                'arrival_location' => 58, 
                'departure_location' => 57, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 1,
                'length_in_km' => 200.5,
                'duration_estimated' => '02:00:00',
                'description' => 'Arrivée à Winnipeg',
                'departure_date' => '2024-07-30 08:00:00',
                'pictures' => 'canada1.jpg'
            ],
            [
                'travel_id' => 15, 
                'arrival_location' => 59, 
                'departure_location' => 58, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 2,
                'length_in_km' => 200.5,
                'duration_estimated' => '02:00:00',
                'description' => 'Arrivée à Calgary',
                'departure_date' => '2024-07-30 08:00:00',
                'pictures' => 'canada1.jpg'
            ],
            [
                'travel_id' => 15, 
                'arrival_location' => 60, 
                'departure_location' => 59, 
                'transportation_id' => 1, 
                'days_spent_at_destination' => 7,
                'length_in_km' => 200.5,
                'duration_estimated' => '02:00:00',
                'description' => 'Arrivée à Vancouver',
                'departure_date' => '2024-07-30 08:00:00',
                'pictures' => 'canada1.jpg'
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
