<?php

namespace App\Http\Livewire;

use App\Quiz;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class QuizForm extends Component
{
    use WithPagination;

    public $search = "";

    public $perPage = 10;

    public $editRoute;
    public $modelEditParam;
    public $model;
    public $columns;
    public $labels;

    public $selectedItems = [];
    

    public function mount($editRoute, $modelEditParam, $model, $columns, $labels)
    {
        $this->editRoute = $editRoute;
        $this->modelEditParam = $modelEditParam;
        $this->model = $model;
        $this->columns = $columns;
        $this->labels = $labels;

    }
    
    public function selectItem($quizz_id = null, $question_id)
    {
        $this->selectedItems[] = $question_id;

        if ($quizz_id == null) {
            $quiz = new Quiz();
        } else {
            $quiz = Quiz::findOrFail($quizz_id);
        }

        $quiz->questions()->attach($question_id);

    }

    public function render()
    {
        
        return view('livewire.quiz-form', [
            'rows' => $this->model::whereLike($this->columns, $this->search)
            ->paginate($this->perPage),
            'labels' => $this->labels,
            'modelEditParam' => $this->modelEditParam,
            'editRoute' => $this->editRoute,
            'columns' => $this->columns
        ]);
    }
}