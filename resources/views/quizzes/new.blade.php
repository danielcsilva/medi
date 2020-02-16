@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('quizzes') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('quizzes.store')  }}">
                @csrf

                @include('quizzes._form')

            </form>
        </div>
    </div>

@endsection
