<?php

namespace App\Http\Livewire;

use App\Accession;
use App\Beneficiary;
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
    public $beneficiaries = [];
    public $answerBeneficiary;
    public $specifics = [];
    public $actualSpecifics;
    public $edit = true;


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

    public function addSpecific($beneficiary_name, $index, $question_id, $beneficiary_index)
    {
        $exists = false;
        
        foreach($this->specifics as $spec) {
            if ($spec['beneficiary_name'] == $beneficiary_name
                && $spec['beneficiary_index'] == $beneficiary_index 
                && $spec['quiz_id'] == $this->quiz->id 
                && $spec['question_id'] == $question_id) {

                $exists = true;
            }
        }

        if (!$exists) {

            $specific = [
                'beneficiary_name' => $beneficiary_name,
                'beneficiary_index' => $beneficiary_index,
                'comment_item' => '',
                'period_item' => '',
                'quiz_id' => $this->quiz->id,
                'comment_number' => $index + 1,
                'question_id' => $question_id
            ];
    
            $this->specifics[] = $specific;
        }
    }

    public function removeSpecific($beneficiary_name, $question_id, $beneficiary_index)
    {
        foreach($this->specifics as $k => $spec) {
            if ($spec['beneficiary_name'] == $beneficiary_name 
                && $spec['beneficiary_index'] == $beneficiary_index 
                && $spec['quiz_id'] == $this->quiz->id 
                && $spec['question_id'] == $question_id) {
                    
                unset($this->specifics[$k]);
            }
        }

    }

    public function quizChanged($quiz_id)
    {
        $this->answerBeneficiary = [];

        if (is_numeric($quiz_id)) {

            $this->quiz = Quiz::where('id', $quiz_id)->first();
            $this->questions = Quiz::with('questions')->where('id', $this->quiz->id)->first();
    
            $this->refreshQuiz();
            $this->refreshQuizSpecifics();

        } else {
            $this->questions = [];
            $this->quiz = null;
        }
    }

    public function answerQuestion($question_id, $beneficiary_index, $answer, $question_index)
    {
        
        if ($this->edit) {
            
            $question = HealthQuestion::findOrFail($question_id);
    
            if ($answer == 'S') {
    
                $this->answerBeneficiary[$question->id]['beneficiary_' . $beneficiary_index] = [
                    'short' => $answer, 
                    'long' => ($answer == 'S' ? 'Sim' : 'Não'),
                    'beneficiary_name' =>  $beneficiary_index == 0 ? 'Titular' : 'Dependente ' . $beneficiary_index,
                    'beneficiary_id' => ''
                 ];
    
                $this->addSpecific($beneficiary_index == 0 ? 'Titular' : 'Dependente ' . $beneficiary_index, $question_index, $question_id, $beneficiary_index);
    
            } else {
                unset($this->answerBeneficiary[$question->id]['beneficiary_' . $beneficiary_index]);
    
                $this->removeSpecific($beneficiary_index == 0 ? 'Titular' : 'Dependente ' . $beneficiary_index, $question_id, $beneficiary_index);
    
            }
        }


    }

    public function mount($accession, $beneficiaries, $edit = true)
    {
        $this->answerBeneficiary = [];
        $this->accession = $accession;
        $this->edit = $edit;

        if ($accession !== null) {

            $this->accession = Accession::where('id', $accession->id)->first();
            $this->quiz = Quiz::where('id', $accession->quiz_id)->first();
            $this->answers = HealthDeclarationAnswer::where('accession_id', $accession->id)->get();
            $this->questions = Quiz::with('questions')->where('id', $this->quiz->id)->first(); // Quiz with questions
            $this->actualSpecifics = HealthDeclarationSpecific::where('accession_id', $accession->id)->get();
            $this->beneficiaries = $beneficiaries;

            if ($beneficiaries !== null) {
                $this->numberOfDependents = count($beneficiaries);
            }
            
            $this->refreshQuiz();
            $this->refreshQuizSpecifics();
        }

        $this->quizzes = Quiz::all();
    }


    public function refreshQuiz()
    {

        foreach($this->beneficiaries as $k => $beneficiary) {
            
            foreach($this->questions->questions as $question) {
                            
                $answers = HealthDeclarationAnswer::where(['quiz_id' => $this->quiz->id, 'beneficiary_id' => $beneficiary->id, 'question_id' => $question->id])->get();
                
                if ($answers) {
                    foreach($answers as $answer) {
                                               
                        $this->answerBeneficiary[$question->id]['beneficiary_' . $k] = [
                            'short' => $answer->answer, 
                            'long' => ($answer->answer == 'S' ? 'Sim' : 'Não'),
                            'beneficiary_name' => $k == 0 ? 'Titular' : 'Dependente ' . $k,
                            'beneficiary_id' => $beneficiary->id
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
    
                foreach($this->actualSpecifics as $k => $spec) {
                            
                    if ($question->id == $spec->question_id 
                        && $spec->accession_id == $this->accession->id
                        && $spec->quiz_id == $this->quiz->id) {
                            
                        $specific['beneficiary_name'] = $spec->beneficiary_index == 0 ? 'Titular' : 'Dependente ' . $spec->beneficiary_index;
                        $specific['beneficiary_index'] = $spec->beneficiary_index;
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
            'numberOfDependents' => $this->numberOfDependents,
            'canEdit' => $this->edit
        ]);

    }
}