<?php

namespace App\Livewire;
use App\Models\Travel;

use Livewire\Component;

class ShowTravel extends Component
{
    public $travel;

    public $latitude = 45.5017; // Valeur par défaut pour Montréal
    public $longitude = -73.5673; // Valeur par défaut pour Montréal

    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.show-travel')->layout('layouts.app');
    }
}
