<?php

namespace App\Http\Livewire;

use App\Accession;
use App\HealthDeclarationAnswer;
use App\HealthQuestion;
use App\Quiz;
use Livewire\Component;

class Healthdeclaration extends Component
{
    public $numberOfDependents = 0;
    public $answers = '';
    public $accession;
    public $quiz;
    public $quizzes;
    public $questions;


    protected $listeners = [
        'dependentAdded' => 'addNewDependent', 
        'dependentDeleted' => 'removeDependent',
        'quizChanged'
    ];

    public function addNewDependent() 
    {
        $this->numberOfDependents++;
    }

    public function removeDependent()
    {
        $this->numberOfDependents--;
    }

    public function quizChanged($quiz_id)
    {
        $this->quiz = Quiz::where('id', $quiz_id)->first();
        $this->questions = Quiz::with('questions:question,description')->where('id', $this->quiz->id)->first();
    }

    public function mount($accession)
    {
        if ($accession !== null) {
            $this->accession = Accession::where('id', $accession->id)->first();
            $this->quiz = Quiz::where('id', $accession->quiz_id)->first();
            $this->answers = HealthDeclarationAnswer::where('accession_id', $accession->id)->get();
            $this->questions = Quiz::with('questions:question,description')->where('id', $this->quiz->id)->first();
        }

        $this->quizzes = Quiz::all();
    }


    public function render()
    {
        

        return view('livewire.healthdeclaration', [
            'quizzes' => $this->quizzes, 
            'actual_quiz' => $this->quiz,
            'accession' => $this->accession, 
            'quiz_questions' => $this->questions,
            'numberOfDependents' => $this->numberOfDependents
        ]);
    }
}
