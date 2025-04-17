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
    public $departureLocation;
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
        // Ajoutez une vérification pour voir ce que vous recevez
        \Log::info('Valeur reçue pour departureLocation', ['value' => $value]);
        \Log::info( $value);
        $this->departureLocation = $value; // Assurez-vous que $value est bien une chaîne ou un tableau
    }
    
    public function updateArrivalLocation($value)
    {
        // Ajoutez une vérification pour voir ce que vous recevez
        \Log::info('Valeur reçue pour arrivalLocation', ['value' => $value]);
        $this->arrivalLocation = $value; // Assurez-vous que $value est bien une chaîne ou un tableau
    }
    
    
    

    public function submit()
    {
        \Log::info('transportation: ' . $this->transportationName);
        \Log::info('departureLocation: ' . $this->departureLocation);
        \Log::info('arrivalLocation: ' . $this->arrivalLocation);
        \Log::info('daysSpentAtDestination: ' . $this->daysSpentAtDestination);
        \Log::info('description: ' . $this->description);
        \Log::info('travelID: ' . $this->travelID);
        \Log::info('submit() called');
        // $this->validate([
        //     'transportation' => 'required',
        //     'departureLocation' => 'required',
        //     'arrivalLocation' => 'required',
        //     'daysSpentAtDestination' => 'required|integer|min:0',
        //     'description' => 'nullable|string|max:255',
        // ]);

    
        [$departureLat, $departureLng] = explode(',', $this->departureLocation);
        [$arrivalLat, $arrivalLng] = explode(',', $this->arrivalLocation);

        \Log::info('departureLat: ' . $departureLat);
        \Log::info('departureLng: ' . $departureLng);
        \Log::info('arrivalLat: ' . $arrivalLat);
        \Log::info('arrivalLng: ' . $arrivalLng);
    
        $departure = Location::firstOrCreate([
            'latitude' => $departureLat,
            'longitude' => $departureLng,
            'country_id' => 1
        ]);
        $departure->save();

        $arrival = Location::firstOrCreate([
            'latitude' => $arrivalLat,
            'longitude' => $arrivalLng,
            'country_id' => 1
        ]);
        $arrival->save();

        $transportation = Transportation::where('name', $this->transportationName)->first();
        \Log::info($this->transportationName);

    
        $trip = Trip::create([
            'travel_id' => $this->travelID,
            'transportation_id' => $transportation->id,
            'departure_location' => $departure->id,
            'arrival_location' => $arrival->id,
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
        session()->flash('success', 'Étape ajoutée avec succès !');
    
        // Optionnel : reset les champs
        $this->reset(['departureLocation', 'arrivalLocation', 'transportationName', 'daysSpentAtDestination', 'description']);
    }
    

    public function render()
    {
        return view('livewire.new-trip')->layout('layouts.app');
    }
}
