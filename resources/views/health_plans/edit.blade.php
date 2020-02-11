@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('healthplans', $healthplan) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('healthplans.update', ['healthplan' => $healthplan->id])  }}">
                @csrf
                @method('PUT')

                @include('health_plans._form')

            </form>
        </div>
    </div>

@endsection
