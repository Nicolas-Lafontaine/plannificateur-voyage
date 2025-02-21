<?php

namespace App\Livewire;
use App\Models\Travel;

use Livewire\Component;

class ShowTravel extends Component
{
    public $travel;

    public function mount($id)
    {
        $this->travel = Travel::findOrFail($id);
    }

    public function render()
    {
        return view('livewire.show-travel');
    }
}
