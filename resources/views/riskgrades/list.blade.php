@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('riskgrades', 'list') }}
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('riskgrades.create') }}">Nova</a>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', ['editRoute' => 'riskgrades', 'routeParam' => 'riskgrade', 'model' => $model, 'columns' => ['risk'], 'labels' => ['Grau de Risco']])

@endsection
