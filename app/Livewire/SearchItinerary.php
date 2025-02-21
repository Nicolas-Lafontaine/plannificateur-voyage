<?php

namespace App\Livewire;

use App\Models\Travel;
use Livewire\Component;
use Livewire\WithPagination;

class SearchItinerary extends Component
{
    use WithPagination;

    public $minLength;
    public $maxLength;

    public function mount()
    {
        // Initialisation des données, vous pouvez définir une valeur par défaut si nécessaire
        $this->minLength = null;
        $this->maxLength = null;
    }

    public function updating($name, $value)
    {
        // Réinitialise la pagination à la première page lorsque les filtres changent
        $this->resetPage();
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

        // Récupérer les résultats paginés
        $travels = $query->paginate(5);

        return view('livewire.search-itinerary', ['travels' => $travels]);
    }
}
