<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transportation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'co2_emission_per_km_grams',
    ];

    public function trips()
    {
        return $this->hasMany(Trip::class);
    }
}
