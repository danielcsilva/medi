@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('roles') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('roles.store')  }}">
                @csrf

                @include('roles._form')

            </form>
        </div>
    </div>

@endsection
