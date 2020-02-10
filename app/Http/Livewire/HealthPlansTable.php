<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use App\HealthPlan;

class HealthPlansTable extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public function render()
    {
        return view('livewire.health_plans.health-plans-table', [
            'health_plans' => HealthPlan::whereLike(['name'], $this->search)
                ->paginate($this->perPage),
        ]);
    }
}
