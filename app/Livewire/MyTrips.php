<?php

namespace App\Livewire;

use App\Models\Travel;
use Livewire\Component;

class MyTrips extends Component
{
    public $numbers;
    public $travels;


    public function mount()
    {
        // Initialiser la variable avec une liste de nombres pour le test
        $this->numbers = [1, 2, 3, 4, 5];
        $query = Travel::query();
        $this->travels = $query->get();

    }

    public function render()
    {
        return view('livewire.my-trips', ['travels' => $this->travels]);
    }
}
