<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class BeneficiariesTable extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public function render()
    {
        return view('livewire.beneficiaries.beneficiaries-table', [
            'beneficiaries' => DB::table('beneficiaries')
                ->where('name', 'LIKE', "%{$this->search}%")
                ->orWhere('email', 'LIKE', "%{$this->search}%")
                ->orWhere('birth_date', 'LIKE', "%{$this->search}%")
                ->paginate($this->perPage),
        ]);
    }
}
