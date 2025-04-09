<?php

namespace App\Livewire;

use App\Models\Travel;
use App\Models\Trip;
use Livewire\Component;

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
            $this->total_co2_emission_in_kg += ($trip->transportation->co2_emission_per_km_grams * $trip->length_in_km) / 1000;
        }

            // Ajouter le total au voyage
            $this->travel->total_length = $this->total_length;
            //TO DO : Ajouter le total CO2 au voyage
            $this->travel->save();  
    }    


    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
        $this->trips = $this->travel->trips()->orderBy('order_number')->get();
        $this->calculateTotal();
    }

    public function render()
    {
        return view('livewire.edit-travel')->layout('layouts.app');
    }
}
