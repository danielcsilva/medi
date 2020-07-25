@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('dashboards') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('dashboards.store')  }}">
                @csrf

                @include('dashboards._form')

            </form>
        </div>
    </div>

@endsection
