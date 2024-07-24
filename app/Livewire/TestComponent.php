<?php

namespace App\Livewire;

use Livewire\Component;

class TestComponent extends Component
{
    public $travels;

    public function mount()
    {
        // $this->travels = Travel::all();

        $query = Travel::query();
        $this->travels = $query->get();

    }

    public function render()
    {
        return view('livewire.test-component')
        ->extends("layouts.app");
    }
}
