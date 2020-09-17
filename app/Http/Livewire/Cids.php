<?php

namespace App\Http\Livewire;

use App\Cid;
use Livewire\Component;

class Cids extends Component
{
    public $cids = [];
    public $searchResults;

    public function addCid()
    {

    }

    public function completeCid($part)
    {
        if ($part == "") {
            $this->searchResults = null;
        } else {
            $this->searchResults = Cid::where('cid', 'LIKE', '%' . $part . '%')->get();
        }
    }

    public function mount($interview = null)
    {
        
    }

    public function render()
    {
        return view('livewire.cids', [
            'cids' => $this->cids,
            'searchResults' => $this->searchResults ?? json_encode($this->searchResults)    
        ]);
    }
}
