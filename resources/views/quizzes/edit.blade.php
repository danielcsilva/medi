@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('quizzes', $inconsistency) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('quizzes.update', ['inconsistency' => $inconsistency->id])  }}">
                @csrf
                @method('PUT')

                @include('quizzes._form')

            </form>
        </div>
    </div>

@endsection
