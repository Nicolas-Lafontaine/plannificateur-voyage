<?php

namespace App\Livewire;

use App\Models\Travel;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyTrips extends Component
{
    use WithPagination;

    public $minLength;
    public $maxLength;
    public $userId;

    public function mount()
    {
        $this->minLength = null;
        $this->maxLength = null;
        $this->userId = Auth::id(); 
    }

    public function updating($name, $value)
    {
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

        if ($this->maxLength) {
            $query->where('total_length', '<=', $this->maxLength);
        }

        if ($this->userId) {
            $query->where('user_id', '=', intval($this->userId));
        }

        // Récupérer les résultats paginés
        $travels = $query->paginate(5);

        return view('livewire.my-trips', ['travels' => $travels]);
    }
}
