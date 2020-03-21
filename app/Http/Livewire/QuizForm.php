<?php

namespace App\Http\Livewire;

use App\HealthQuestion;
use App\Quiz;
use Illuminate\Database\Eloquent\Builder;
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
    public $routeParam;
    public $model;
    public $columns;
    public $labels;

    public $selectedItems = [];
    public $name;
    public $rowsHas;

    public function mount($editRoute, $routeParam, $model, $columns, $labels, $QuizId = null)
    {
        
        $this->editRoute = $editRoute;
        $this->routeParam = $routeParam;
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

            $this->loadQuestions();

        }

    }

    public function loadQuestions()
    {
        if ($this->QuizId !== null) {

            $this->rowsHas = HealthQuestion::whereHas('quizzes', function(Builder $query){
                $query->where('quiz_id', '=', $this->QuizId);
            })->get()->toArray();

        } else {

            $this->rowsHas = HealthQuestion::find($this->selectedItems)->toArray();
        }
    }

    public function submit()
    {

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
            $quiz = Quiz::findOrFail($this->QuizId);
            request()->session()->flash('success', 'Declaração de Saúde alterada com sucesso!');
        }

        $quiz->name = $this->name;
        $quiz->save();
        
        if ($this->QuizId === null) {
            $quiz->questions()->sync($this->selectedItems);
        }

        return redirect()->route('quizzes.index');
    }
    

    public function removeSelected($remove_id)
    {
        $this->selectItem($remove_id);
    }
    
    public function selectItem($question_id)
    {
        
        if (!in_array($question_id, $this->selectedItems)) {
            $this->selectedItems[] = $question_id;
        } else {
            $key = array_search($question_id, $this->selectedItems, true);
            unset($this->selectedItems[$key]);
        } 
        
        if ($this->QuizId !== null) {
            
            $quiz = Quiz::findOrFail($this->QuizId);
            $hq = HealthQuestion::find($question_id);

            if (in_array($question_id, $this->selectedItems)) {
                $quiz->questions()->attach($hq);
            } else {
                $quiz->questions()->detach($hq);
            }            
        }
        
        $this->loadQuestions();
    }

    public function render()
    {
              
        return view('livewire.quiz-form', [
            'rows' => $this->model::whereLike($this->columns, $this->search)
            ->paginate($this->perPage),
            'labels' => $this->labels,
            'routeParam' => $this->routeParam,
            'editRoute' => $this->editRoute,
            'columns' => $this->columns,
            'selectedItems' => (array)$this->selectedItems,
            'name' => $this->name,
            'selectedQuestions' => $this->rowsHas
        ]);

    }
}