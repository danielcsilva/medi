@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('riskgrades') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('riskgrades.store')  }}">
                @csrf

                @include('riskgrades._form')

            </form>
        </div>
    </div>

@endsection
