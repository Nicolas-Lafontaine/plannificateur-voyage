<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Travel;
use Illuminate\Support\Facades\DB;

class Trends extends Component
{
    public $mostVisitedCountryName;
    public $mostVisitedCountryImage;
    public $averageKm;
    public $mostPopularTransportName;
    public $mostPopularTransportImage;
    public $averageDuration;

    public function mount()
    {
        $this->calculateAverageDistance();
        $this->calculateAverageDuration();
        $this->identifyFavoriteCountry();
        $this->identifyFavoriteTransportation();


    }

    public function identifyFavoriteCountry()
    {
    $favorite = DB::table('trips')
        ->join('locations', function ($join) {
            $join->on('locations.id', '=', 'trips.arrival_location')
                 ->orOn('locations.id', '=', 'trips.departure_location');
        })
        ->join('countries', 'countries.id', '=', 'locations.country_id')
        ->select('countries.name', DB::raw('COUNT(*) as total'))
        ->groupBy('countries.name')
        ->orderByDesc('total')
        ->first();

        if ($favorite) {
            $this->mostVisitedCountryName = $favorite->name;
            $this->mostVisitedCountryImage = asset('images/flags/' . strtolower($favorite->name) . '.jpg');
        }
    }

    public function identifyFavoriteTransportation()
    {
    $favorite = DB::table('trips')
        ->join('transportations', 'transportations.id', '=', 'trips.transportation_id')        
        ->select('transportations.name', DB::raw('COUNT(*) as total'))
        ->groupBy('transportations.name')
        ->orderByDesc('total')
        ->first();

        if ($favorite) {
            $translations = [
            'driving'   => 'Voiture',
            'foot' => 'Marche',
            ];
            $this->mostPopularTransportName = $translations[$favorite->name] ?? $favorite->name;
            $this->mostPopularTransportImage = asset('images/icons/' . strtolower($favorite->name) . '.jpg');
        }    
    }

    public function calculateAverageDuration()
    {
        $this->averageDuration = round(Travel::avg('total_duration'), 0);
    }

    public function calculateAverageDistance()
    {
        $this->averageKm = round(Travel::avg('total_length'), 0);
    }

    public function render()
    {
        return view('livewire.trends');
    }
}
