@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('companies') }}
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
