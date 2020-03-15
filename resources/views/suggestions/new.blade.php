@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('suggestions') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('suggestions.store')  }}">
                @csrf

                @include('suggestions._form')

            </form>
        </div>
    </div>

@endsection
