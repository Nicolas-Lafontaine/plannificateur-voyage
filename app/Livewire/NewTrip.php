<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Transportation;
use App\Models\Travel;
use App\Models\Country;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewTrip extends Component
{
    public $travel;
    public $travelID;
    public $transportationName;
    public $transportation;
    public $departureLocation;
    public $departure;
    public $arrival;
    public $arrivalLocation;
    public $daysSpentAtDestination;
    public $description;
    public $departureDate;
    public $customDepartureDate;
    public $isFirstTrip = false;
    public $distanceInKm;
    public $departureLat;
    public $departureLon;
    public $arrivalLat;
    public $arrivalLon;
    public $co2Emission;
    public $latitudeLastTrip;
    public $longitudeLastTrip;
    public $zoomDefault;
    public $arrivalLastTrip;
    public $lastTrip;

    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
        $this->travelID = $this->travel->id;

        $this->isFirstTrip();
    }

    public function isFirstTrip()
    {
        $this->lastTrip = Trip::where('travel_id', $this->travelID)->orderBy('departure_date', 'desc')->first();

        if (!$this->lastTrip) {
            $this->isFirstTrip = true;
        }
        else
        {
            // Attribue une valeur pour le champ du formulaire
            $this->departureLocation =$this->lastTrip->arrivalLocation->latitude . ',' . $this->lastTrip->arrivalLocation->longitude;
            // Attribue une valeur pour le calcul de la distance
            $this->departureLon = $this->lastTrip->arrivalLocation->longitude;
            $this->departureLat = $this->lastTrip->arrivalLocation->latitude;
            // Donne une itance à lier avec le nouveau trip
            $this->departure = $this->lastTrip->arrivalLocation;
            // Données nécessaires au placement du marqueur de départ sur la carte
            $this->latitudeLastTrip = $this->lastTrip->arrivalLocation->latitude;
            $this->longitudeLastTrip = $this->lastTrip->arrivalLocation->longitude;
            $this->zoomDefault = 9;
        }    
    }

    protected $listeners = [
        'updateDepartureLocation' => 'updateDepartureLocation', // 1er nom l'évènement, 2ème nom la méthode
        'updateArrivalLocation' => 'updateArrivalLocation'
    ];

    public function updateDepartureLocation($value)
    {
        $this->departureLocation = $value;
        \Log::info('Emplacement de départ mis à jour après submit : ' . $this->departureLocation);
    }
    
    public function updateArrivalLocation($value)
    {
        $this->arrivalLocation = $value; 
    }

    public function createLocations()
    {
        if($this->isFirstTrip)
        {
            [$this->departureLat, $this->departureLon] = explode(',', $this->departureLocation);
            $departureCountryName = $this->getCountryFromCoordinates($this->departureLat, $this->departureLon);
            $departureCountry = Country::where('name', $departureCountryName)->first();

            $this->departure = Location::firstOrCreate([
                'latitude' => $this->departureLat,
                'longitude' => $this->departureLon,
                'country_id' => $departureCountry->id
            ]);
            $this->departure->save();
        }

        [$this->arrivalLat, $this->arrivalLon] = explode(',', $this->arrivalLocation);
        $arrivalCountryName = $this->getCountryFromCoordinates($this->arrivalLat, $this->arrivalLon);
        $arrivalCountry = Country::where('name', $arrivalCountryName)->first();

        $this->arrival = Location::firstOrCreate([
            'latitude' => $this->arrivalLat,
            'longitude' => $this->arrivalLon,
            'country_id' => $arrivalCountry->id
        ]);
        $this->arrival->save();
    }

    private function getCountryFromCoordinates($lat, $lon)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lon}&zoom=5&addressdetails=1";

        $response = Http::withHeaders([
            'User-Agent' => 'MyTravelApp/1.0' // Important, sinon Nominatim rejette la requête
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['address']['country'] ?? 'Inconnu';
        }

        return 'Inconnu';
    }


    public function createTrip()
    {        
        if(!$this->isFirstTrip)
        {
            $orderNumber = Trip::where('travel_id', $this->travelID)->max('order_number') + 1;
        }
        else
        {
            $orderNumber = 1;
        }

        $trip = Trip::create([
            'travel_id' => $this->travelID,
            'transportation_id' => $this->transportation->id,
            'departure_location' => $this->departure->id,
            'arrival_location' => $this->arrival->id,
            'days_spent_at_destination' => $this->daysSpentAtDestination,
            'description' => $this->description,
            'length_in_km' => $this->distanceInKm,
            'departure_date' => $this->departureDate->format('Y-m-d'), 
            'co2_emission_in_kg' => $this->co2Emission,
            'order_number' => $orderNumber,
            // TO DO : Implémenter la sélection d'une image par défaut pour le trip
            'pictures' => 'default.jpg',
        ]);
        $trip->save();
    }

    public function rules()
    {
        $rules = [
            'departureLocation' => 'required|string',
            'arrivalLocation' => 'required|string|different:departureLocation',
            'transportationName' => 'required|in:driving,train,foot,bike',
            'daysSpentAtDestination' => 'required|integer|min:0|max:365',
            'description' => 'required|string|min:5|max:255',
        ];
    
        if ($this->isFirstTrip) {
            $rules['customDepartureDate'] = 'required|date|after_or_equal:today';
        }
    
        return $rules;
    }
    
    public function messages()
    {
        return [
            'departureLocation.required' => 'Le lieu de départ est requis.',
            'arrivalLocation.required' => 'Le lieu d\'arrivée est requis.',
            'arrivalLocation.different' => 'Le lieu d\'arrivée doit être différent du lieu de départ.',
            'transportationName.required' => 'Veuillez sélectionner un moyen de transport.',
            'transportationName.in' => 'Le moyen de transport sélectionné n\'est pas valide.',
            'daysSpentAtDestination.required' => 'Le nombre de jours passés est requis.',
            'daysSpentAtDestination.integer' => 'Le nombre de jours doit être un entier.',
            'daysSpentAtDestination.min' => 'Le nombre de jours ne peut pas être négatif.',
            'daysSpentAtDestination.max' => 'Le nombre de jours est trop élevé.',
            'description.required' => 'Une description est requise.',
            'description.min' => 'La description doit contenir au moins :min caractères.',
            'description.max' => 'La description ne peut pas dépasser :max caractères.',
            'customDepartureDate.required' => 'La date de départ est requise.',
            'customDepartureDate.date' => 'La date de départ doit être une date valide.',
            'customDepartureDate.after_or_equal' => 'La date de départ doit être aujourd\'hui ou dans le futur.',
        ];
    }

    public function submit()
    {        
        $validated = $this->validate();

        //$lastTrip = Trip::where('travel_id', $this->travelID)->orderBy('departure_date', 'desc')->first();

        $lastTrip = Trip::where('travel_id', $this->travelID)
        ->orderBy('departure_date', 'desc')
        ->orderBy('created_at', 'desc') 
        ->first();

        if ($lastTrip) {
            \Log::info('Dernier trip trouvé : ' . $lastTrip->id);
            \Log::info('Dernier trip trouvé : ' . $lastTrip->departure_date);
            \Log::info('Dernier trip trouvé : ' . $lastTrip->days_spent_at_destination);
            $lastDate = Carbon::parse($lastTrip->departure_date);
            $this->departureDate = $lastDate->addDays($lastTrip->days_spent_at_destination);
        } else {
            \Log::info('Aucun dernier trip trouvé, on utilise la date de départ personnalisée.');
            $newDate = Carbon::parse($this->customDepartureDate);
            $this->departureDate = $newDate;
        }
        
        $this->createLocations();

        $this->transportation = Transportation::where('name', $this->transportationName)->first();

        $this->getRoute();
    
        $this->createTrip();

        session()->flash('message', 'Étape ajoutée avec succès !');

        $this->isFirstTrip = false;

        $this->reset(['departureLocation', 'arrivalLocation', 'transportationName', 'daysSpentAtDestination', 'description', 'customDepartureDate']);
        $this->isFirstTrip();
        
        \Log::info('Données envoyées au front end pour le marqueur de départ : ' . $this->arrivalLat . ' ' . $this->arrivalLon);

        $this->dispatch('trip-added', [
            'lat' => $this->arrivalLat,
            'lng' => $this->arrivalLon,
        ]);        
    }
    
    public function getRoute()
    {
        $routeGeoJSON = ["type" => "FeatureCollection", "features" => []];        
        
            $profile = ($this->transportationName === 'foot') ? 'foot' : 'driving';
            $osrmPort = ($profile === 'foot') ? 5001 : 5000;

            $url = "http://localhost:{$osrmPort}/route/v1/{$profile}/{$this->departureLon},{$this->departureLat};{$this->arrivalLon},{$this->arrivalLat}?overview=full&geometries=geojson";

            $response = Http::get($url);

            if ($response->successful() && isset($response['routes'][0]['geometry'])) 
            {
                $distanceInMeters = $response['routes'][0]['distance'];
                $this->distanceInKm = $distanceInMeters / 1000;
                $this->travel->total_length = $this->travel->total_length + $this->distanceInKm;
                $this->co2Emission = ($this->transportation->co2_emission_per_km_grams * $this->distanceInKm) / 1000; 
                $this->travel->total_co2_emission_in_kg = $this->travel->total_co2_emission_in_kg + $this->co2Emission;    
            }
        $this->travel->save();
    }

    public function render()
    {
        return view('livewire.new-trip')->layout('layouts.app');
    }
}
