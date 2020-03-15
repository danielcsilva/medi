@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col">
        {{ Breadcrumbs::render('healthquestions', 'list') }}
    </div>
    <div class="col">
        <div class="btn-group float-right">
            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Opções
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('healthquestions.create') }}">Nova</a>
            </div>
        </div>
    </div>
</div>

@livewire('data-tables', ['editRoute' => 'healthquestions', 'modelEditParam' => 'healthquestion', 'model' => $model, 'columns' => ['question', 'description', 'required'], 'labels' => ['Questão', 'Descrição', 'Obrigatório?'], 'booleans' => ['required']])


@endsection
