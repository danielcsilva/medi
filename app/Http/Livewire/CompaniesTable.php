<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class CompaniesTable extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public function render()
    {
        return view('livewire.companies.companies-table', [
            'companies' => DB::table('companies')
                ->where('name', 'LIKE', "%{$this->search}%")
                ->orWhere('contract', 'LIKE', "%{$this->search}%")
                ->paginate($this->perPage),
        ]);
    }
}
