@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">    
        {{-- {{ dd($breadcrumb) }} --}}
        {{ Breadcrumbs::render('delegation', $breadcrumb ?? 'list') }}                
    </div>
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
    'options' => [
        'editable' => false
    ]
])

@endsection