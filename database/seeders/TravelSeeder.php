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
            ['user_id' => 1, 'name' => 'Voyage à Londres', 'total_length' => 350.45],
            ['user_id' => 1, 'name' => 'Voyage à Sydney', 'total_length' => 1700.80],
            ['user_id' => 1, 'name' => 'Voyage à Rome', 'total_length' => 450.60],
            ['user_id' => 1, 'name' => 'Voyage à Barcelone', 'total_length' => 300.20],
            ['user_id' => 1, 'name' => 'Voyage à Berlin', 'total_length' => 400.00],
            ['user_id' => 1, 'name' => 'Voyage à Los Angeles', 'total_length' => 1300.75],
            ['user_id' => 1, 'name' => 'Voyage à Amsterdam', 'total_length' => 550.30],
        ];

        foreach ($travels as $travel) {
            Travel::create($travel);
        }
    }
}