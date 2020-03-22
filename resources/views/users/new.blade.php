@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('inconsistencies') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('inconsistencies.store')  }}">
                @csrf

                @include('inconsistencies._form')

            </form>
        </div>
    </div>

@endsection
