<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class BeneficiariesTable extends Component
{
    public $search = "";

    public function render()
    {
        return view('livewire.beneficiaries.beneficiaries-table', [
            'beneficiaries' => DB::table('beneficiaries')
                ->where('name', 'LIKE', "%{$this->search}%")
                ->get(),
        ]);
    }
}
