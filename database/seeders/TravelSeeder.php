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
            ['user_id' => 1, 'name' => 'Road trip Québec => Colombie-Britannique', 'total_length' => 350.45],
        ];

        foreach ($travels as $travel) {
            Travel::create($travel);
        }
    }
}