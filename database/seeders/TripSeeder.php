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
                'travel_id' => 1, // Assurez-vous que cet ID existe dans la table travels
                'arrival_location' => 1, // Assurez-vous que cet ID existe dans la table locations
                'departure_location' => 2, // Assurez-vous que cet ID existe dans la table locations
                'transportation_id' => 1, // Assurez-vous que cet ID existe dans la table transportations
                'commentary_id' => null,
                'days_spent_at_destination' => 3,
                'length_in_km' => 150.5,
                'duration_estimated' => '02:00:00',
                'description' => 'Deuxième étape de mon voyage au Canada',
                'departure_date' => '2024-07-30 08:00:00',
                'pictures' => 'canada1.jpg'
            ],
            [
                'travel_id' => 2, // Assurez-vous que cet ID existe dans la table travels
                'arrival_location' => 15, // Assurez-vous que cet ID existe dans la table locations
                'departure_location' => 13, // Assurez-vous que cet ID existe dans la table locations
                'transportation_id' => 2, // Assurez-vous que cet ID existe dans la table transportations
                'commentary_id' => null, // Assurez-vous que cet ID existe dans la table commentaries (si applicable)
                'days_spent_at_destination' => 4,
                'length_in_km' => 200.8,
                'duration_estimated' => '05:00:00',
                'description' => 'Première étape de mon voyage au Japon',
                'departure_date' => '2024-08-02 10:00:00',
                'pictures' => 'japan1.jpg'
            ],
            [
                'travel_id' => 3, // Assurez-vous que cet ID existe dans la table travels
                'arrival_location' => 11, // Assurez-vous que cet ID existe dans la table locations
                'departure_location' => 10, // Assurez-vous que cet ID existe dans la table locations
                'transportation_id' => 3, // Assurez-vous que cet ID existe dans la table transportations
                'commentary_id' => null, // Assurez-vous que cet ID existe dans la table commentaries (si applicable)
                'days_spent_at_destination' => 2,
                'length_in_km' => 180.2,
                'duration_estimated' => '03:00:00',
                'description' => 'Première étape de mon voyage aux États-Unis',
                'departure_date' => '2024-08-03 12:00:00',
                'pictures' => 'usa1.jpg'
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
