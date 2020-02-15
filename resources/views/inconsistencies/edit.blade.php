@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('inconsistencies', $inconsistency) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('inconsistencies.update', ['inconsistency' => $inconsistency->id])  }}">
                @csrf
                @method('PUT')

                @include('inconsistencies._form')

            </form>
        </div>
    </div>

@endsection
