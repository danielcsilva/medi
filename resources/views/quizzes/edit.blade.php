@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col">
            {{ Breadcrumbs::render('quizzes', $quiz) }}
        </div>  
    </div>

    <div class="row">
        <div class="col">            
                
            @livewire('quiz-form',  ['editRoute' => 'healthquestions', 'routeParam' => 'healthquestion', 'model' => $modelAutoComplete, 'columns' => ['question'], 'labels' => ['Questão'], 'QuizId' => $quiz->id ])

        </div>
    </div>

@endsection
