@extends('layouts.app')

@section('content')    

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('dashboards', $dashboard) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('dashboards.update', ['dashboard' => $dashboard->id])  }}">
                @csrf
                @method('PUT')

                @include('dashboards._form')

            </form>
        </div>
    </div>

@endsection
