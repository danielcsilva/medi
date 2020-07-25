@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('dashboards', 'list') }}
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('dashboards.create') }}">Novo</a>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', ['editRoute' => 'dashboards', 'routeParam' => 'dashboard', 'model' => $model, 'columns' => ['label', 'dashboard_link', 'active'], 'labels' => ['Título', 'Link', 'Ativo']])

@endsection
