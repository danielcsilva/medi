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
        'Financiamento', 
        'Cliente'
    ],
    'filter' => $filter,
    'deleteRoute' => $deleteRoute ?? null,
    'filterField' => [
        'companies' => ['label' => 'Cliente', 'field' => 'company_id', 'model' => 'App\Company', 'itens' => []]
    ]
])

@endsection