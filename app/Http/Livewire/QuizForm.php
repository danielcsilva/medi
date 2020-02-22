<?php

namespace App\Http\Livewire;

use App\Quiz;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class QuizForm extends Component
{
    use WithPagination;

    public $QuizId = null;
    public $search = "";

    public $perPage = 10;

    public $editRoute;
    public $modelEditParam;
    public $model;
    public $columns;
    public $labels;

    public $selectedItems = [];
    public $name;

    public function submit()
    {
        // dd(request()->all());
        $rules = [
            'name' => 'required|min:6',
            'selectedItems' => 'required'
        ];

        $messages = [
            'selectedItems.*' => 'Você precisa escolher pelo menos uma pergunta para a DS.'
        ];

        $validatedData = Validator::make([
            'name' => $this->name,
            'selectedItems' => $this->selectedItems
        ], $rules, $messages)->validated();
        
        $this->saveQuiz();
    }


    public function saveQuiz()
    {   
        if ($this->QuizId == null) {
            $quiz = new Quiz();
            request()->session()->flash('success', 'Declaração de Saúde adicionada!');
        } else {
            request()->session()->flash('success', 'Declaração de Saúde alterada com sucesso!');
            $quiz = Quiz::findOrFail($this->QuizId);
        }

        $quiz->name = $this->name;
        $quiz->save();
        $quiz->questions()->sync($this->selectedItems);

        return redirect()->route('quizzes.index');
    }
    

    public function mount($editRoute, $modelEditParam, $model, $columns, $labels, $QuizId = null)
    {
        
        $this->editRoute = $editRoute;
        $this->modelEditParam = $modelEditParam;
        $this->model = $model;
        $this->columns = $columns;
        $this->labels = $labels;

        if ($QuizId !== null) {
            $this->QuizId = $QuizId;
            $quiz = Quiz::findOrFail($this->QuizId);
            $this->name = $quiz->name;

            foreach($quiz->questions as $question) {
                $this->selectedItems[] = $question->id;
            }
        }

    }
    
    public function selectItem($question_id)
    {
        
        $key = array_search($question_id, $this->selectedItems);
        if ($key === false) {
            $this->selectedItems[] = $question_id;
        } else {
            unset($this->selectedItems[$key]);
        } 

    }

    public function render()
    {
        
        return view('livewire.quiz-form', [
            'rows' => $this->model::whereLike($this->columns, $this->search)
            ->paginate($this->perPage),
            'labels' => $this->labels,
            'modelEditParam' => $this->modelEditParam,
            'editRoute' => $this->editRoute,
            'columns' => $this->columns,
            'selectedItems' => $this->selectedItems,
            'name' => $this->name
        ]);
    }
}