<?php

namespace App\Livewire;
use App\Models\Travel;
use Livewire\Component;

class NewTravel extends Component
{
    public $travelName;
    public $isPublic;

    public function createTravel()
    {
        $this->validate([
            'travelName' => 'required|string|max:50',
        ]);

        $travel = new Travel();
        $travel->user_id = auth()->id();
        $travel->name = $this->travelName;
        $travel->total_length = 0;
        $travel->image_url = "images/travels/default_travel_image.jpg";
        $travel->public = $this->isPublic ? 1 : 0; 
        $travel->save();
    }
    public function submit()
    {
        $this->createTravel();
        return redirect()->route('mytrips'); 
    }
    public function render()
    {
        return view('livewire.new-travel')->layout('layouts.app');
    }
}
