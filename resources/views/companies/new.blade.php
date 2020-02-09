@extends('layouts.app')

@section('content')

    {{ Breadcrumbs::render('companies') }}

    <div class="row">
        <div class="col">
            <h2>Empresas</h2>
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('companies.store')  }}">
                @csrf

                @include('companies._form')

            </form>
        </div>
    </div>

@endsection
