@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('suggestions', $suggestion) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('suggestions.update', ['suggestion' => $suggestion->id])  }}">
                @csrf
                @method('PUT')

                @include('suggestions._form')

            </form>
        </div>
    </div>

@endsection
