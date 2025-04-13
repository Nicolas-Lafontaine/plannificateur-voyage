<?php

namespace App\Livewire;

use App\Models\Travel;
use App\Models\Trip;
use Livewire\Component;
use Carbon\Carbon;

class EditTravel extends Component
{
    public $travel;
    public $trips;
    public $total_length;
    public $total_co2_emission_in_kg;

    public function getRoute()
    {

    }

    public function deleteTrip($tripId)
    {
        $trip = Trip::find($tripId);

        if (!$trip) {
            session()->flash('error', 'Étape introuvable.');
            return;
        }
        $trip->delete();
    }

    public function calculateTotal()
    {
        $this->total_length = 0;
        $this->total_co2_emission_in_kg = 0;

        foreach ($this->trips as $trip) {
            $this->total_length += $trip->length_in_km;
            $trip->co2_emission_in_kg = ($trip->transportation->co2_emission_per_km_grams * $trip->length_in_km) / 1000;
            $trip->save();
            $this->total_co2_emission_in_kg += $trip->co2_emission_in_kg;
        }

        // Ajouter le total au voyage
        $this->travel->total_length = $this->total_length;
        //TO DO : Ajouter le total CO2 au voyage
        $this->travel->save();  
    }    

    public function calculateDepartureDatesForTrips()
    {
        $totalDuration = 0;

        // TO DO : Prévenir les erreurs qui surviendraient si un trip était placé avant le premier qui a été créé

        $firstTrip = $this->trips->first();
    
        $currentDate = Carbon::parse($firstTrip->departure_date);
    
        foreach ($this->trips as $index => $trip) {
            if ($index === 0) {
                $totalDuration += $trip->days_spent_at_destination;
                continue;
            }
    
            $currentDate = $currentDate->copy()->addDays($this->trips[$index - 1]->days_spent_at_destination);
    
            $trip->departure_date = $currentDate;
            $trip->save();
    
            $totalDuration += $trip->days_spent_at_destination;
        }
    
        $this->travel->total_duration = $totalDuration;
        $this->travel->save();
    }


    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
        $this->trips = $this->travel->trips()->orderBy('order_number')->get();
        $this->calculateDepartureDatesForTrips();
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.edit-travel')->layout('layouts.app');
    }
}
