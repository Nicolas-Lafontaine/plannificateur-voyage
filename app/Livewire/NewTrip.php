<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Trip;
use App\Models\Location;
use App\Models\Transportation;
use App\Models\Travel;
use Carbon\Carbon;

class NewTrip extends Component
{
    public $travelID;
    public $transportationName;
    public $transportation;
    public $departureLocation;
    public $departure;
    public $arrival;
    public $arrivalLocation;
    public $daysSpentAtDestination;
    public $description;
    
    // TO DO : Prendre en compte les dates de départ et d'arrivée lors de la création d'un trip
    // en se basant sur la date de départ du trip précédent, si pas de trip, alors prendre la date d'ajourd'hui
    // pour $departureDate et ajouter les jours de $daysSpentAtDestination pour $arrivalDate

    // public $departureDate;
    // public $arrivalDate;

    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
        $this->travelID = $this->travel->id;
    }

    protected $listeners = [
        'updateDepartureLocation' => 'updateDepartureLocation', // 1er nom l'évènement, 2ème nom la méthode
        'updateArrivalLocation' => 'updateArrivalLocation'
    ];

    public function updateDepartureLocation($value)
    {
        $this->departureLocation = $value;
    }
    
    public function updateArrivalLocation($value)
    {
        $this->arrivalLocation = $value; 
    }

    public function createLocations()
    {
        [$departureLat, $departureLng] = explode(',', $this->departureLocation);
        [$arrivalLat, $arrivalLng] = explode(',', $this->arrivalLocation);
    
        $this->departure = Location::firstOrCreate([
            'latitude' => $departureLat,
            'longitude' => $departureLng,
            'country_id' => 1
        ]);
        $this->departure->save();

        $this->arrival = Location::firstOrCreate([
            'latitude' => $arrivalLat,
            'longitude' => $arrivalLng,
            'country_id' => 1
        ]);
        $this->arrival->save();
    }

    public function createTrip()
    {
        $trip = Trip::create([
            'travel_id' => $this->travelID,
            'transportation_id' => $this->transportation->id,
            'departure_location' => $this->departure->id,
            'arrival_location' => $this->arrival->id,
            'days_spent_at_destination' => $this->daysSpentAtDestination,
            'description' => $this->description,
            //TO DO : Calculer la distance entre les deux points pour déterminer lenght_in_km
            'length_in_km' => 333,
            //TO DO : Calculer la date de départ et d'arrivée en fonction de la date d'arrivée du précédent trip, si pas de trip précédent alors choisir la date d'aujourd'hui
            // 'departure_date' => $departure_date,
            // 'arrival_date' => $arrival_date,
            // TO DO : Calculer l'émission de CO2 en fonction du mode de transport et de la distance
            'co2_emission_in_kg' => 333,
            // TO DO : Attribuer un order_number en fonction de l'ordre des trips
            'order_number' => 1,
            // TO DO : Implémenter la sélection d'une image par défaut pour le trip
            'pictures' => 'default.jpg',
        ]);
        $trip->save();
    }

    public function rules()
    {
        return [
            'departureLocation' => 'required|string',
            'arrivalLocation' => 'required|string|different:departureLocation',
            'transportationName' => 'required|in:driving,train,foot,bike',
            'daysSpentAtDestination' => 'required|integer|min:0|max:365',
            'description' => 'required|string|min:5|max:255',
        ];
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
        ];
    }
    

    public function submit()
    {        
        $validated = $this->validate();

        $this->createLocations();

        $this->transportation = Transportation::where('name', $this->transportationName)->first();
    
        $this->createTrip();

        session()->flash('message', 'Étape ajoutée avec succès !');

    
        $this->reset(['departureLocation', 'arrivalLocation', 'transportationName', 'daysSpentAtDestination', 'description']);
    }
    

    public function render()
    {
        return view('livewire.new-trip')->layout('layouts.app');
    }
}
