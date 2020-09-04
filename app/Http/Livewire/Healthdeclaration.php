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
    public $answers;
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
        'quizChanged',
        'addSpecific',
        'removeSpecific'
    ];

    public function addNewDependent() 
    {
        $this->numberOfDependents++;
    }

    public function removeDependent()
    {
        $this->numberOfDependents--;
    }

    public function addSpecific($beneficiary_name, $index, $question_id)
    {
        $exists = false;
        
        foreach($this->specifics as $spec) {
            if ($spec['beneficiary_name'] == $beneficiary_name 
                && $spec['quiz_id'] == $this->quiz->id 
                && $spec['question_id'] == $question_id) {

                $exists = true;
            }
        }

        if (!$exists) {

            $specific = [
                'beneficiary_name' => $beneficiary_name,
                'comment_item' => '',
                'period_item' => '',
                'quiz_id' => $this->quiz->id,
                'comment_number' => $index + 1,
                'question_id' => $question_id
            ];
    
            $this->specifics[] = $specific;
        }
    }

    public function removeSpecific($beneficiary_name, $question_id)
    {
        foreach($this->specifics as $k => $spec) {
            if ($spec['beneficiary_name'] == $beneficiary_name 
                && $spec['quiz_id'] == $this->quiz->id 
                && $spec['question_id'] == $question_id) {
                    
                unset($this->specifics[$k]);
            }
        }

    }

    public function quizChanged($quiz_id)
    {
        $this->answerBeneficiary = [];

        $this->quiz = Quiz::where('id', $quiz_id)->first();
        $this->questions = Quiz::with('questions')->where('id', $this->quiz->id)->first();
        
        $this->refreshQuiz();
        $this->refreshQuizSpecifics();
    }

    public function answerQuestion($question_id, $beneficiary_index, $answer, $question_index)
    {
        
        $question = HealthQuestion::findOrFail($question_id);

        if ($answer == 'S') {

            $this->answerBeneficiary[$question->id]['beneficiary_' . $beneficiary_index] = [
                'short' => $answer, 
                'long' => ($answer == 'S' ? 'Sim' : 'Não'),
                'beneficiary_name' => $this->beneficiaries[$beneficiary_index]->name
            ];

            $this->addSpecific($this->beneficiaries[$beneficiary_index]->name, $question_index, $question_id);

        } else {
            unset($this->answerBeneficiary[$question->id]['beneficiary_' . $beneficiary_index]);

            $this->removeSpecific($this->beneficiaries[$beneficiary_index]->name, $question_id);

        }

    }

    public function mount($accession, $beneficiaries)
    {
        $this->answerBeneficiary = [];
        $this->accession = $accession;

        if ($accession !== null) {

            $this->accession = Accession::where('id', $accession->id)->first();
            $this->quiz = Quiz::where('id', $accession->quiz_id)->first();
            $this->answers = HealthDeclarationAnswer::where('accession_id', $accession->id)->get();
            $this->questions = Quiz::with('questions')->where('id', $this->quiz->id)->first(); // Quiz with questions
            $this->actualSpecifics = HealthDeclarationSpecific::where('accession_id', $accession->id)->get();
            $this->beneficiaries = $beneficiaries;            

            $this->refreshQuiz();
            $this->refreshQuizSpecifics();
        }

        $this->quizzes = Quiz::all();
    }


    public function refreshQuiz()
    {

        if (isset($this->answers) && count($this->answers) > 0) {

            foreach($this->answers as $keyAnswer => $answer) {
    
                if ($answer->quiz_id == $this->quiz->id) {
    
                    foreach($this->beneficiaries as $k => $beneficiary) {
                        $this->answerBeneficiary[$answer->question]['beneficiary_' . $k] = [
                            'short' => $answer->answer, 
                            'long' => ($answer->answer == 'S' ? 'Sim' : 'Não'),
                            'beneficiary_name' => $beneficiary->name
                        ];
                    }
    
                } 
                
            }

        }
    }

    public function refreshQuizSpecifics()
    {
        $specific = [];
        $this->specifics = [];
        
        if (isset($this->actualSpecifics) && count($this->actualSpecifics) > 0){

            foreach($this->questions->questions as $question) {
    
                foreach($this->actualSpecifics as $spec) {
    
                    foreach($this->beneficiaries as $beneficiary) {
                        
                        if ($beneficiary->id == $spec->beneficiary_id 
                            && $question->id == $spec->question_id 
                            && $spec->accession_id == $this->accession->id
                            && $spec->quiz_id == $this->quiz->id) {
                                
                            $specific['beneficiary_name'] = $beneficiary->name;
                            $specific['comment_number'] = $spec->comment_number;
                            $specific['comment_item'] = $spec->comment_item;
                            $specific['period_item'] = $spec->period_item;
                            $specific['quiz_id'] = $this->quiz->id;
                            $specific['question_id'] = $spec->question_id;
                            
                            $this->specifics[] = $specific;
                        }
                    }
                }
    
            }

        }

    }

    public function render()
    {

        return view('livewire.healthdeclaration', [
            'quizzes' => $this->quizzes, 
            'actual_quiz' => $this->quiz,
            'accession' => $this->accession, 
            'quiz_questions' => $this->questions,
            'answers' => $this->answers,
            'beneficiaries' => $this->beneficiaries,
            'answersQuiz' => $this->answerBeneficiary,
            'specifics' => $this->specifics,
            'numberOfDependents' => $this->numberOfDependents
        ]);

    }
}