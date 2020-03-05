<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class DataTables extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public $editRoute;
    public $modelEditParam;
    public $model;
    public $columns;
    public $labels;
    public $booleans;
    

    public function mount($editRoute, $modelEditParam, $model, $columns, $labels, $booleans = [])
    {
        $this->editRoute = $editRoute;
        $this->modelEditParam = $modelEditParam;
        $this->model = $model;
        $this->columns = $columns;
        $this->labels = $labels;
        $this->booleans = $booleans;

        $this->emit('rewriteTable', 'rewrite');
    }

    public function render()
    {
        $this->emit('rewriteTable', 'rewrite');
        // dd($this->columns);
        return view('livewire.data-tables', [
            'rows' => $this->model::whereLike($this->columns, $this->search)
            ->paginate($this->perPage),
            'labels' => $this->labels,
            'modelEditParam' => $this->modelEditParam,
            'editRoute' => $this->editRoute,
            'columns' => $this->columns,
            'booleans' => $this->booleans
        ]);
    }
}