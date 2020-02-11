@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('beneficiaries', 'list') }}
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('beneficiaries.create') }}">Novo</a>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', 'beneficiaries', 'beneficiary', '\App\\Beneficiary', ['name', 'email', 'cpf', 'birth_date', 'height', 'weight'], ['Nome', 'Email', 'CPF', 'Nasc.', 'ALtura', 'Peso'])

@endsection
