@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('users', $user) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('users.update', ['user' => $user->id])  }}">
                @csrf
                @method('PUT')

                @include('users._form')

            </form>
        </div>
    </div>

@endsection
