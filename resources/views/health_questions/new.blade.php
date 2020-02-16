@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('healthquestions') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('healthquestions.store')  }}">
                @csrf

                @include('health_questions._form')

            </form>
        </div>
    </div>

@endsection
