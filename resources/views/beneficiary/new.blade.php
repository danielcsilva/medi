@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            <h2>Beneficiários</h2>
        </div>
        <div class="col">
            <div class="float-right">
                <button type="button" class="btn btn-secondary">Voltar</button> <button type="button" class="btn btn-info">Salvar</button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('beneficiaries.store')  }}">
                @csrf

                @include('beneficiary._form')

            </form>
        </div>
    </div>

@endsection
