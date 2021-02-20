@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">    
        {{-- {{ dd($breadcrumb) }} --}}
        {{ Breadcrumbs::render('accessions', $breadcrumb ?? 'list') }}                
    </div>
    @can('Editar Processos')
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('accessions.create') }}">Novo</a>
            </div>
        </div>
    </div>
    @endcan
</div>

@livewire('data-tables', [
    'editRoute' => $editRoute, 
    'routeParam' => $routeParam, 
    'model' => $model, 
    'columns' => [
        'proposal_number', 
        'received_at', 
        'financier.name', 
        'company.name'
    ], 
    'labels' => [
        'Proposta', 
        'Recebida', 
        'Resp. Financeiro', 
        'Cliente'
    ],
    'delete' => $delete ?? true,
    'filter' => $filter,
    'deleteRoute' => $deleteRoute ?? null,
    'filterField' => $filterField,
    'options' => [
        'selectAble' => $selectAble ?? false,
        'actions' => [
            $dataTablesActions ?? []
        ],
        'editable' => $editable ?? true,
        'items' => $items ?? ""
    ]
])

@endsection