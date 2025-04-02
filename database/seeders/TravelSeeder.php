<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Travel;

class TravelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $travels = [
            ['user_id' => 2, 'name' => 'Voyage privé Utilisateur 2', 'total_length' => 950.45],
        ];

        foreach ($travels as $travel) {
            Travel::create($travel);
        }
    }
}