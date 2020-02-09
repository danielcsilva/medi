<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class HealthPlansTable extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public function render()
    {
        return view('livewire.health-plans-table', [
            'healthplans' => DB::table('health_plans')
                ->where('name', 'LIKE', "%{$this->search}%")
                ->paginate($this->perPage),
        ]);
    }
}
