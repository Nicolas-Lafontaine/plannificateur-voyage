<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_id','arrival_location', 'departure_location', 'transportation_id', 'departure_date', 'days_spent_at_destination', 'length_in_km', 'duration_estimated', 'description', 'pictures', 'co2_emission_in_kg', 'order_number'
    ];

    protected $casts = [
        'departure_date' => 'date',
    ];    

    public function arrivalLocation()
    {
        return $this->belongsTo(Location::class, 'arrival_location');
    }

    public function departureLocation()
    {
        return $this->belongsTo(Location::class, 'departure_location');
    }

    public function transportation()
    {
        return $this->belongsTo(Transportation::class);
    }

    public function commentary()
    {
        return $this->belongsTo(Commentary::class);
    }

    public function travel()
    {
        return $this->belongsTo(Travel::class);
    }
}
