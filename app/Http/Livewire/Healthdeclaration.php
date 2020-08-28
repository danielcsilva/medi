<?php

namespace App\Http\Livewire;

use App\Accession;
use App\HealthDeclarationAnswer;
use App\HealthDeclarationSpecific;
use App\HealthQuestion;
use App\Quiz;
use Livewire\Component;

class Healthdeclaration extends Component
{
    public $numberOfDependents = 1;
    public $answers = '';
    public $accession;
    public $quiz;
    public $quizzes;
    public $questions;
    public $beneficiaries;
    public $answerBeneficiary;
    public $specifics = [];
    public $actualSpecifics;


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

    public function mount($accession, $beneficiaries)
    {

        if ($accession !== null) {
            $this->answerBeneficiary = [];

            $this->accession = Accession::where('id', $accession->id)->first();
            $this->quiz = Quiz::where('id', $accession->quiz_id)->first();
            $this->answers = HealthDeclarationAnswer::where('accession_id', $accession->id)->get();
            $this->questions = Quiz::with('questions:question,description')->where('id', $this->quiz->id)->first();
            $this->actualSpecifics = HealthDeclarationSpecific::where('accession_id', $accession->id)->get();
            $this->beneficiaries = $beneficiaries;
            
            foreach($this->answers as $keyAnswer => $answer) {
                foreach($beneficiaries as $k => $beneficiary) {
                    $this->answerBeneficiary[$answer->question]['beneficiary_' . $k] = ['short' => $answer->answer, 'long' => ($answer->answer == 'S' ? 'Sim' : 'Não')];
                    
                    if ($answer->answer == 'S') {
                        $this->specifics[] = [
                            'item' => $keyAnswer, 
                            'beneficiary' => $beneficiary->name, 
                            'beneficiary_id' => $beneficiary->id
                        ];
                    }
                }

            }

        }

        $this->quizzes = Quiz::all();
    }


    public function render()
    {
        
        // dd($this->specifics);
        return view('livewire.healthdeclaration', [
            'quizzes' => $this->quizzes, 
            'actual_quiz' => $this->quiz,
            'accession' => $this->accession, 
            'quiz_questions' => $this->questions,
            'answers' => $this->answers,
            'beneficiaries' => $this->beneficiaries,
            'answersQuiz' => $this->answerBeneficiary,
            'specifics' => $this->specifics,
            'actual_specifics' => $this->actualSpecifics,
            'numberOfDependents' => $this->numberOfDependents
        ]);

    }
}
