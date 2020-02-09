<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\Beneficiary;

class BeneficiariesTable extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public function render()
    {
        return view('livewire.beneficiaries.beneficiaries-table', [
            'beneficiaries' => Beneficiary::whereLike(['name', 'email', 'birth_date'], $this->search)
                ->paginate($this->perPage),
        ]);
    }
}
