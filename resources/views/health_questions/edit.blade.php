@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('healthquestions', $healthquestion) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            <form method="post" action="{{ route('healthquestions.update', ['healthquestion' => $healthquestion->id])  }}">
                @csrf
                @method('PUT')

                @include('health_questions._form')

            </form>
        </div>
    </div>

@endsection
