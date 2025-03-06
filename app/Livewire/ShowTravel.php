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

    // Valeurs utilisées pour le test API (Nuuk)
    public $start = "-51.708966,64.183547";
    public $end = "-51.710552,64.179831";
    public $routeData;

    // Valeurs test pour initialiser la carte 
    public $latitudeTest = "72.0";
    public $longitudeTest = "-41.0";
    public $zoomTest = "6";

    // Variable pour les points de passage
    public $waypoints = "-51.708693,64.182738;-51.709850,64.181253";

    // Méthode pour récupérer la route entre deux points

    public function getRoute()
    {

        // Récupérer les données de départ et d'arrivée + étapes pour le travel sélectionné   
        
        $firstTrip = $this->travel->trips->first();
        $lastTrip = $this->travel->trips->last();

        // Récupérer les coordonnées de départ et d'arrivée du premier trajet
        $firstTripStartLat = $firstTrip->departureLocation->latitude;
        $firstTripStartLon = $firstTrip->departureLocation->longitude;

        // Récupérer les coordonnées de départ et d'arrivée du dernier trajet
        $lastTripEndLat = $lastTrip->arrivalLocation->latitude;
        $lastTripEndLon = $lastTrip->arrivalLocation->longitude;

        // Récupérer les coordonnées des étapes intermédiaires

        $startCoords = explode(',', $this->start); // Partie à supprimer car les coordonnées sont stockées séparément dans la base de données
        $endCoords = explode(',', $this->end);
    
        if (count($startCoords) !== 2 || count($endCoords) !== 2) { // TO DELETE
            session()->flash('error', 'Coordonnées invalides. Format attendu : "longitude,latitude".');
            return;
        }
    
        [$startLon, $startLat] = array_map('trim', $startCoords); // TO DELETE
        [$endLon, $endLat] = array_map('trim', $endCoords); // Il faudra utiliser $travel->$trip->arrival_location ET $travel->$trip->departure_location->latitude et longitude
    
        \Log::info('firstTripStartLat :', [$firstTripStartLat]);
        \Log::info('firstTripStartLon :', [$firstTripStartLon]);
        \Log::info('endLon :', [$endLon]);
        \Log::info('endLat :', [$endLat]);


        // Vérifier si des waypoints sont définis et bien formatés
        $waypointsArray = [];
        if (!empty($this->waypoints)) {
            $waypointsArray = explode(';', $this->waypoints);
            foreach ($waypointsArray as $key => $waypoint) {
                $waypointsArray[$key] = trim($waypoint);
                if (count(explode(',', $waypoint)) !== 2) {
                    session()->flash('error', 'Format invalide pour les points intermédiaires.');
                    return;
                }
            }
        }

        // Construction de la requête OSRM avec waypoints
        $waypointsString = !empty($waypointsArray) ? ';' . implode(';', $waypointsArray) : '';
        $url = "http://localhost:5000/route/v1/driving/{$firstTripStartLon},{$firstTripStartLat}{$waypointsString};{$lastTripEndLon},{$lastTripEndLat}?overview=full&geometries=geojson";

        $response = Http::get($url);
    
        if ($response->successful() && isset($response['routes'][0]['geometry'])) {
            $routeGeoJSON = $response['routes'][0]['geometry']; // On extrait les données GeoJSON de la réponse, si le format est correct
    
            //(storage/logs/laravel.log)
            \Log::info('Route GeoJSON:', [$routeGeoJSON]);
    
            $this->latitudeTest = $startLat; // On passe les coordonnées de départ à la carte via des propriétés
            $this->longitudeTest = $startLon; // (à effacer ?)
    
            $this->dispatch('updateRoute', $routeGeoJSON); // Déclenche l'événement 'updateRoute' avec les données GeoJSON
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
