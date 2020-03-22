@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('roles', $role) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('roles.update', ['role' => $role->id])  }}">
                @csrf
                @method('PUT')

                @include('roles._form')

            </form>
        </div>
    </div>

@endsection
