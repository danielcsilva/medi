<?php

namespace App\Http\Livewire;

use App\AccessionMedicalAnalysis;
use App\Cid;
use Livewire\Component;

class Cids extends Component
{
    public $cids = [];
    public $medicalAnalysisId;
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

    public function mount($medicalAnalysisId = null)
    {
        if ($medicalAnalysisId !== null) {
            $medicalAnalysisCids = AccessionMedicalAnalysis::findOrFail($medicalAnalysisId);
            if(isset($medicalAnalysisCids->cids) && count($medicalAnalysisCids->cids) > 0) {
                foreach($medicalAnalysisCids->cids as $cid) {
                    $this->cids[] = $cid->cid . ' - ' . $cid->description;
                }
            }
        }

        $this->medicalAnalysisId = $medicalAnalysisId;
        $this->initCids();
    }

    public function saveCids()
    {
        $medicalAnalysisCids = AccessionMedicalAnalysis::findOrFail($this->medicalAnalysisId);
        
        foreach($this->cids as $cid) {
            $cid = Cid::where('cid', substr($cid, 0, strpos($cid, "-") - 1))->first();
            if ($cid) {
               $cids[] = $cid->id; 
            }
        }
        
        $medicalAnalysisCids->cids()->sync($cids);

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
