<?php

namespace App\Livewire;

use App\Models\Travel;
use Illuminate\Support\Facades\Http;

use Livewire\Component;

class ShowTravel extends Component
{
    public $travel;

    public $latitude = 45.5017; // Valeur par défaut pour Montréal
    public $longitude = -73.5673; // Valeur par défaut pour Montréal

    public $latitude3Riviere = 46.3498; // Valeur par défaut pour Montréal
    public $longitude3Riviere = -72.5501; // Valeur par défaut pour Montréal

    // Valeurs utilisées pour le test API
    public $start = "-42.0,71.0";
    public $end = "-41.0,72.0";
    public $routeData;

    // Valeurs test pour initialiser la carte
    public $latitudeTest = "72.0";
    public $longitudeTest = "-41.0";
    public $zoomTest = "6";

    public function getRoute()
    {
        $startCoords = explode(',', $this->start); // Partie à supprimer car les coordonnées sont stockées séparément dans la base de données
        $endCoords = explode(',', $this->end);
    
        if (count($startCoords) !== 2 || count($endCoords) !== 2) { // TO DELETE
            session()->flash('error', 'Coordonnées invalides. Format attendu : "longitude,latitude".');
            return;
        }
    
        [$startLon, $startLat] = array_map('trim', $startCoords); // TO DELETE
        [$endLon, $endLat] = array_map('trim', $endCoords); // Il faudra utiliser $travel->$trip->arrival_location ET $travel->$trip->departure_location->latitude et longitude
    
        $url = "http://localhost:5000/route/v1/driving/{$startLon},{$startLat};{$endLon},{$endLat}?overview=full&geometries=geojson";
        $response = Http::get($url);
    
        if ($response->successful() && isset($response['routes'][0]['geometry'])) {
            $routeGeoJSON = $response['routes'][0]['geometry'];
    
            //(storage/logs/laravel.log)
            \Log::info('Route GeoJSON:', [$routeGeoJSON]);
    
            $this->latitudeTest = $startLat;
            $this->longitudeTest = $startLon;
    
            $this->dispatch('updateRoute', $routeGeoJSON);
        } else {
            \Log::error('Erreur OSRM: ' . $response->body());
            session()->flash('error', 'Erreur lors de la récupération de la route.');
        }
    }
    

   

    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.show-travel')->layout('layouts.app');
    }
}
