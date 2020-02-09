@extends('layouts.app')

@section('content')    

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('companies', $company) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('companies.update', ['company' => $company->id])  }}">
                @csrf
                @method('PUT')

                @include('companies._form')

            </form>
        </div>
    </div>

@endsection
