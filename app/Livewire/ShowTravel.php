<?php

namespace App\Livewire;

use App\Models\Travel;
use App\Models\Trip;
use App\Models\Commentary;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class ShowTravel extends Component
{
    public $travel;
    public $routeData;
    public $waypoints = '';
    public $descriptions = [];
    public $newComment = [];
    public array $expandedTrips = [];
    public $searchedTripDescription;
    public $searchedCountryName;
    public $searchedTrips;
    


    protected $rules = [
        'newComment.*' => 'required|string|max:250',
    ];

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

        $this->travel->total_length = 0;

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

                $distanceInMeters = $response['routes'][0]['distance'];
                $distanceInKm = $distanceInMeters / 1000;
        
                $trip->length_in_km = $distanceInKm;
                $trip->save();
                $this->travel->total_length = $this->travel->total_length + $distanceInKm;
        
                \Log::info("Distance pour le trip #{$trip->order_number} : {$distanceInKm} km");
        

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
        $this->travel->save();

        // \Log::info('--------------------------------------------------');
        // \Log::info('Route complète envoyée :', [$routeGeoJSON]);
        // \Log::info('Descriptions collectées:', $this->descriptions);
        // \Log::info('Waypoints avant l\'envoi :', [$this->waypoints]);
        
        // Dispatch l'événement avec toutes les routes fusionnées et les waypoints
        $this->dispatch('updateRoute', [
            'routeGeoJSON' => $routeGeoJSON,
            'waypoints' => $this->waypoints,
            'descriptions' => $this->descriptions
        ]);
    }

    public function addComment($tripId)
    {
        $this->validate([
            'newComment.' . $tripId => 'required|string|max:250',
        ]);

        $comment = new Commentary();
        $comment->trip_id = $tripId;
        $comment->user_id = auth()->id();
        $comment->text = $this->newComment[$tripId];
        $comment->save();

        // Réinitialiser le champ du commentaire
        $this->newComment[$tripId] = '';

        // Rafraîchir le modèle travel avec ses relations si nécessaire
        //$this->travel->load('trips.commentaries');
    }

    public function deleteComment($commentaryId)
    {
    $commentary = Commentary::findOrFail($commentaryId);

    if ($commentary->user_id !== auth()->id()) {
        abort(403);
    }

    $commentary->delete();
    }

    public function toggleComments($tripId)
    {
    $this->expandedTrips[$tripId] = !($this->expandedTrips[$tripId] ?? false);
    }


    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
        $this->getRoute();
        $this->searchedTrips = $this->travel->trips()->orderBy('order_number')->get();
    }   

        public function render()
        {
            $query = Trip::query();

            // Appliquer les filtres
            if (!empty($this->searchedTripDescription) && !$this->searchedTripDescription == '') {
                $query->where('description', 'LIKE', '%' . $this->searchedTripDescription . '%');
                \Log::info("Filtre description appliqué : ", [$this->searchedTripDescription]);
            }

            if (!empty($this->searchedCountryName)) {
                $query->where('', '', $searchedCountryName);
                \Log::info("Filtre pays appliqué : ", [$this->searchedCountryName]);
            }
            
            //$this->$searchedTrips = $query->get();

            return view('livewire.show-travel')->layout('layouts.app');
        }




    // public function render()
    // {


    //     if ($this->maxLength) {
    //         $query->where('total_length', '<=', $this->maxLength);
    //     }

    //     if ($this->maxLength) {
    //         $query->where('total_length', '<=', $this->maxLength);
    //     }

    //     if ($this->userId) {
    //         $query->where('user_id', '=', intval($this->userId));
    //     }


    //     return view('livewire.my-trips', ['travels' => $travels]);
    // }

}
