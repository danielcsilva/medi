@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('accessions', 'list') }}
    </div>
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
</div>

@livewire('data-tables', ['editRoute' => 'accessions', 'routeParam' => 'accession', 'model' => $model, 'columns' => ['proposal_number', 'received_at', 'financier.name', 'company.name'], 'labels' => ['Proposta', 'Recebida', 'Financiamento', 'Cliente']])

@endsection