<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\Company;

class CompaniesTable extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public function render()
    {
        return view('livewire.companies.companies-table', [
            'companies' => Company::whereLike(['name', 'contract', 'cnpj', 'email', 'telephone'], $this->search)
            ->paginate($this->perPage),
        ]);
    }
}