<?php

namespace App\Livewire;

use App\Models\Travel;
use Illuminate\Support\Facades\Http;

use Livewire\Component;

class ShowTravel extends Component
{
    public $travel;
    public $routeData;
    public $waypoints = '';

    public function getRoute()
    {
        $trips = $this->travel->trips;

        if ($trips->isEmpty()) {
            session()->flash('error', 'Aucun trajet disponible.');
            return;
        }

        // Récupérer le premier et le dernier trip
        $firstTrip = $trips->first();
        $lastTrip = $trips->last();

        $startLat = $firstTrip->departureLocation->latitude;
        $startLon = $firstTrip->departureLocation->longitude;
        $endLat = $lastTrip->arrivalLocation->latitude;
        $endLon = $lastTrip->arrivalLocation->longitude;

        if ($trips->count() == 1) {
            // Cas où il n'y a qu'un seul trip → pas de waypoints
            $this->waypoints = '';
        } else {
            // Ajouter l'arrivée du premier trip comme premier waypoint
            $waypointsArray = ["{$firstTrip->arrivalLocation->longitude},{$firstTrip->arrivalLocation->latitude}"];

            // Si plus de 2 trips, ajouter les autres arrivées intermédiaires
            if ($trips->count() > 2) {
                $middleWaypoints = collect($trips)
                    ->slice(1, $trips->count() - 2) // Prend tous les trips sauf le premier et le dernier
                    ->map(fn($trip) => "{$trip->arrivalLocation->longitude},{$trip->arrivalLocation->latitude}")
                    ->toArray();

                $waypointsArray = array_merge($waypointsArray, $middleWaypoints);
            }

            // Convertir les waypoints en chaîne pour l'URL
            $this->waypoints = implode(';', $waypointsArray);
        }

        $waypointsString = !empty($this->waypoints) ? ';' . $this->waypoints : '';

        // Construction de l'URL pour OSRM
        $url = "http://localhost:5000/route/v1/driving/{$startLon},{$startLat}{$waypointsString};{$endLon},{$endLat}?overview=full&geometries=geojson";

        \Log::info('OSRM Request URL:', [$url]);

        $response = Http::get($url);

        if ($response->successful() && isset($response['routes'][0]['geometry'])) {
            $routeGeoJSON = $response['routes'][0]['geometry'];

            \Log::info('Route GeoJSON:', [$routeGeoJSON]);

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
