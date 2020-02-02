<?php

namespace App\Http\Livewire;

use Livewire\Component;

class BeneficiaryTelephone extends Component
{

    public $telephonesInput = 1;

    public function addTelephone()
    {
        $this->telephonesInput++;
        $this->render();
    }

    public function render()
    {
        return view('livewire.beneficiaries.beneficiary-telephone', ['telephonesInput' => $this->telephonesInput]);
    }
}
