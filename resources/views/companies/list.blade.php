@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        <h2>Empresas</h2>
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('companies.create') }}">Nova</a>
            </div>
        </div>
    </div>
</div>

@livewire('companies-table')

@endsection
