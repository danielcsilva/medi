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
    public $routeParam;
    public $deleteRoute;
    public $model;
    public $columns;
    public $labels;
    public $booleans;

    public $edit = true;
    public $delete = true;

    public $filter;
    

    public function mount($editRoute, $routeParam, $model, $columns, $labels, $booleans = [], $edit = true, $delete = true, $filter = [], $deleteRoute = null)
    {
        $this->editRoute = $editRoute;
        $this->routeParam = $routeParam;
        $this->model = $model;
        $this->columns = $columns;
        $this->labels = $labels;
        $this->booleans = $booleans;
        $this->edit = $edit;
        $this->delete = $delete;
        $this->filter = $filter;
        $this->deleteRoute = $deleteRoute ?? $this->editRoute;
        // $this->deleteRoute = $this->deleteRoute ?? $this->editRoute;
        $this->emit('rewriteTable', 'rewrite');
    }

    public function render()
    {
        $this->emit('rewriteTable', 'rewrite');
                
        $rows = $this->model::whereLike($this->columns, $this->search);
        if (!empty($this->filter)) {
            $rows = $rows->where($this->filter);
        }

        if (strpos($this->editRoute, '.') === false) {
            $this->editRoute .= '.edit';
        }
        
        return view('livewire.data-tables', [
            'rows' => $rows->paginate($this->perPage),
            'labels' => $this->labels,
            'routeParam' => $this->routeParam,
            'editRoute' => $this->editRoute,
            'columns' => $this->columns,
            'booleans' => $this->booleans,
            'edit' => $this->edit,
            'delete' => $this->delete
        ]);

    }
}