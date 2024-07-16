<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'housing_price_per_day', 'food_price_per_day', 'transport_price_per_day', 'average_highest_temperature', 'average_lowest_temperature',
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
