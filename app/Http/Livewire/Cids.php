<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Cids extends Component
{
    public $cids = [];

    public function mount($interview = null)
    {
        
    }

    public function render()
    {
        return view('livewire.cids');
    }
}
