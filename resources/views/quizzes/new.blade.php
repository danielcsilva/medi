@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('quizzes') }}
        </div>  
    </div>

    <div class="row">
        <div class="col">
            
            @livewire('quiz-form',  'healthquestions', 'healthquestion', $modelAutoComplete, ['question'], ['Questão'], null)

        </div>
    </div>

@endsection
