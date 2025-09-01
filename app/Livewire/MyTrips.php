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
    public $minDuration;
    public $maxDuration;
    public $userId;

    public function mount()
    {
        $this->minLength = null;
        $this->maxLength = null;
        $this->minDuration = null;
        $this->maxDuration = null;
        $this->userId = Auth::id(); 
    }

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    public function deleteTravel($id)
    {
        $travel = Travel::find($id);

        if ($travel) {
            $travel->delete();
        }

    // Recharge la liste
    $this->render();
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

        if ($this->minDuration) {
            $query->where('total_duration', '>=', $this->minDuration);
        }

        if ($this->maxDuration) {
            $query->where('total_duration', '<=', $this->maxDuration);
        }

        if ($this->userId) {
            $query->where('user_id', '=', intval($this->userId));
        }

        // Récupérer les résultats paginés
        $travels = $query->paginate(5);

        return view('livewire.my-trips', ['travels' => $travels]);
    }
}
