@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('companies', 'list') }}
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('companies.create') }}">Novo</a>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', 'companies', 'company', $model, ['name', 'contract', 'cnpj', 'telephone', 'email'], ['Nome', 'Contrato', 'CNPJ', 'Telefone', 'Email'])

@endsection
