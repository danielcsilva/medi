<?php

namespace App\Http\Livewire;

use Livewire\Component;
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
    public $process_count;
    public $filterField;
    public $selectedItems;
    public $selectAble;
    public $actions;
    // public $defaultFilter;

    public $edit = true;
    public $delete = true;

    public $filter;
    
    protected $listeners = [
        'filterSelected' => 'applySelectedFilter',
        'selectItem' => 'selectItem',
        'removeItem' => 'removeItem'
    ];

    public function mount($editRoute, $routeParam, $model, $columns, $labels, $booleans = [], $edit = true, $delete = true, $filter = [], $deleteRoute = null, $filterField = [], $options = [])
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
        // $this->defaultFilter = $filter;
        $this->deleteRoute = $deleteRoute ?? $this->editRoute;
        $this->filterField = $filterField;
        $this->selectAble = $options['selectAble'] ?? false;

        $this->actions = $options['actions'] ?? false;

        $this->emit('rewriteTable', 'rewrite');
    }


    public function applySelectedFilter($value)
    {   
        if (strpos($value, ".") !== false) {
            $filters = explode(".", $value);
            $this->filter[$filters[0]] = $filters[1];
        } else {
            unset($this->filter[array_key_last($this->filter)]);
            // dd($this->filter, count($this->filter));
        }
    }

    public function filterField() 
    {
        if (!empty($this->filterField)) {
            
            foreach($this->filterField as $k => $fField) {
                $this->filterField[$k]['itens'] = $fField['model']::select('id', 'name')->get();                
            }
    
        }
    }

    public function selectItem($item_id) 
    {
        $this->selectedItems[] = $item_id;
    }

    public function removeItem($item_id) 
    {   
        if (($key = array_search($item_id, $this->selectedItems)) !== false) {
            unset($this->selectedItems[$key]);
        }
    }

    public function render()
    {
        $this->emit('rewriteTable', 'rewrite');

        $rows = $this->model::whereLike($this->columns, $this->search);
        if (!empty($this->filter)) {
            $rows = $rows->where($this->filter);
        }

        $this->filterField();

        if (strpos($this->editRoute, '.') === false) {
            $this->editRoute .= '.edit';
        }

        $this->process_count = $rows->count();
        
        return view('livewire.data-tables', [
            'rows' => $rows->paginate($this->perPage),
            'labels' => $this->labels,
            'routeParam' => $this->routeParam,
            'editRoute' => $this->editRoute,
            'columns' => $this->columns,
            'booleans' => $this->booleans,
            'edit' => $this->edit,
            'delete' => $this->delete,
            'filterField' => $this->filterField ?? false,
            'selectAble' => $this->selectAble,
            'selectedItems' => $this->selectedItems ?? false
        ]);

    }
}