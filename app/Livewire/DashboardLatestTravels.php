<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Travel;

class DashboardLatestTravels extends Component
{
    public $latestTravels;

    public function mount()
    {
        $this->latestTravels = Travel::where('public', true)->orderBy('created_at', 'desc')->take(3)->get();
    }

    public function render()
    {
        return view('livewire.dashboard-latest-travels', ['latestTravels' => $this->latestTravels,]);
    }
}
