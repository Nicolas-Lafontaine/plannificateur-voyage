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
    public $descriptions = [];

    public function getRoute()
    {
        $trips = $this->travel->trips()->orderBy('order_number')->get();

        if ($trips->isEmpty()) {
            session()->flash('error', 'Aucun trajet disponible.');
            return;
        }

        $this->descriptions = [];
        $routeGeoJSON = ["type" => "FeatureCollection", "features" => []];

        // Récupération des waypoints
        $firstTrip = $trips->first();
        $lastTrip = $trips->last();

        $startLat = $firstTrip->departureLocation->latitude;
        $startLon = $firstTrip->departureLocation->longitude;
        $endLat = $lastTrip->arrivalLocation->latitude;
        $endLon = $lastTrip->arrivalLocation->longitude;
        \Log::info('First Trip départ : ', [$firstTrip->departureLocation->longitude]);
        \Log::info('Last Trip fin : ', [$lastTrip->arrivalLocation->longitude]);

        
        
        
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

        \Log::info('Waypoints générés : ', [$this->waypoints]);

        foreach ($trips as $index => $trip) {
            $this->descriptions[] = $trip->description;

            \Log::info("Type de transport pour le trip #{$trip->order_number} :", [$trip->transportation->name]);

            // Déterminer le profil de transport et le port OSRM
            $profile = ($trip->transportation->name === 'foot') ? 'foot' : 'driving';
            $osrmPort = ($profile === 'foot') ? 5001 : 5000;

            // Récupération des valeurs de longitude et latitude de départ et d'arrivée
            $departureLat = $trip->departureLocation->latitude;
            $departureLon = $trip->departureLocation->longitude;
            $arrivalLat = $trip->arrivalLocation->latitude;
            $arrivalLon = $trip->arrivalLocation->longitude;
            \Log::info('Départ longitude : ', [$departureLon]);
            \Log::info('Arrivée longitude : ', [$arrivalLon]);

            // Construire l'URL OSRM avec les waypoints
            $url = "http://localhost:{$osrmPort}/route/v1/{$profile}/{$departureLon},{$departureLat};{$arrivalLon},{$arrivalLat}?overview=full&geometries=geojson";

            \Log::info("Requête OSRM pour le trip #{$trip->order_number} :", [$url]);

            $response = Http::get($url);

            if ($response->successful() && isset($response['routes'][0]['geometry'])) {
                $tripGeoJSON = [
                    "type" => "Feature",
                    "geometry" => $response['routes'][0]['geometry'],
                    "properties" => ["mode" => $trip->transportation->name]
                ];

                $routeGeoJSON["features"][] = $tripGeoJSON;
            } else {
                \Log::error("Erreur OSRM sur le trip #{$index} : " . $response->body());
                session()->flash('error', "Erreur sur le trip #{$index}.");
                return;
            }
        }

        \Log::info('--------------------------------------------------');
        \Log::info('Route complète envoyée :', [$routeGeoJSON]);
        \Log::info('Descriptions collectées:', $this->descriptions);
        \Log::info('Waypoints avant l\'envoi :', [$this->waypoints]);
        
        // Dispatch l'événement avec toutes les routes fusionnées et les waypoints
        $this->dispatch('updateRoute', [
            'routeGeoJSON' => $routeGeoJSON,
            'waypoints' => $this->waypoints,
            'descriptions' => $this->descriptions
        ]);
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
