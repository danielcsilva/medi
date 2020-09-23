<?php

namespace App\Http\Livewire;

use App\AccessionInterview;
use App\Cid;
use Livewire\Component;

class Cids extends Component
{
    public $cids = [];
    public $interviewId;
    public $cidSelected;
    public $allCids;
    public $message;

    public function addCid()
    {
        if (strlen($this->cidSelected) == 0){
            return false;
        }

        foreach($this->cids as $cid) {
            if ($cid == $this->cidSelected) {
                return false;
            }
        }

        $this->cids[] = $this->cidSelected;
        $this->cidSelected = "";
        $this->initCids();
    }

    public function removeCid($key)
    {
        if ($key === 0) {
            $this->cids = [];
        } else {
            unset($this->cids[$key]);
        }
    }

    public function searchCid($part) 
    {
        if ($part != "") {
            $this->allCids = Cid::where('cid', 'LIKE', '%' . $part . '%')->limit(100)->get();
        } else {
            $this->initCids();
        }
    }

    public function mount($interviewId = null)
    {
        if ($interviewId !== null) {
            $accessionInterview = AccessionInterview::findOrFail($interviewId);
            if(isset($accessionInterview->cids) && count($accessionInterview->cids) > 0) {
                foreach($accessionInterview->cids as $cid) {
                    $this->cids[] = $cid->cid . ' - ' . $cid->description;
                }
            }
        }

        $this->interviewId = $interviewId;
        $this->initCids();
    }

    public function saveCids()
    {
        $accessionInterview = AccessionInterview::findOrFail($this->interviewId);
        
        foreach($this->cids as $cid) {
            $cid = Cid::where('cid', substr($cid, 0, strpos($cid, "-") - 1))->first();
            if ($cid) {
               $cids[] = $cid->id; 
            }
        }
        
        $accessionInterview->cids()->sync($cids);

        $this->message = 'CIDs salvos com sucesso!';

        $this->emit('savedCids');
    }

    public function initCids()
    {
        $this->allCids = Cid::limit(100)->get();
    }

    public function render()
    {
        // dd($this->searchResults);
        return view('livewire.cids', [
            'cids' => $this->cids,
            'cidSelected' => $this->cidSelected,
            'allCids' => $this->allCids,
            'message' => $this->message
        ]);
    }
}
