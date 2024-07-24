<?php

namespace App\Livewire;

use App\Models\Travel;
use Livewire\Component;

class SearchItinerary extends Component
{
    public $minLength;
    public $maxLength;
    public $travels;

    public function mount()
    {
        // Initialisation des données, vous pouvez définir une valeur par défaut si nécessaire
        $this->minLength = null;
        $this->maxLength = null;
        $this->travels = Travel::all();
    }

    public function render()
    {
        $query = Travel::query();

        // Appliquer les filtres
        if ($this->minLength) {
            $query->where('total_length', '>=', $this->minLength);
        }

        if ($this->maxLength) {
            $query->where('total_length', '<=', $this->maxLength);
        }

        // Récupérer les résultats
        $this->travels = $query->get();

        return view('livewire.search-itinerary', ['travels' => $this->travels]);
    }
}