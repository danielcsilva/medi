@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('users') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('users.store')  }}">
                @csrf

                @include('users._form')

            </form>
        </div>
    </div>

@endsection
