<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Travel;

class TravelGreenlandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $travel = [
            'user_id' => 1,
            'name' => 'Expédition au Groenland',
            'total_length' => 100, 
            'created_at' => now(),
            'updated_at' => now(),
            'image_url' => '/images/travels/greenland.jpg',
            'public' => true,
        ];

        Travel::create($travel);
    }
}
