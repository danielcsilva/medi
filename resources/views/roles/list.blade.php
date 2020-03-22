@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('statusprocess', 'list') }}
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('statusprocess.create') }}">Novo</a>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', ['editRoute' => 'statusprocess', 'routeParam' => 'statusprocess', 'model' => $model, 'columns' => ['status'], 'labels' => ['Status do Processo']])

@endsection
