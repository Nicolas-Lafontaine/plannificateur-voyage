<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;
use App\Models\Commentary;


class CommentariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $commentary = [
            'id' => 1,
            'user_id' => 1,
            'text' => 'Mon premier commentaire !',
            'created_at' => now(),
            'updated_at' => now(),
            'trip_id' => 18,
        ];

        Commentary::create($commentary);
    }
}
