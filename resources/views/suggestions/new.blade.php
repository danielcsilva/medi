@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('healthplans') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('healthplans.store')  }}">
                @csrf

                @include('health_plans._form')

            </form>
        </div>
    </div>

@endsection
