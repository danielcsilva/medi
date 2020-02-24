<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthQuestion extends Model
{

    protected $fillable = ['question', 'description', 'required'];

    public function quizzes() 
    {
        return $this->belongsToMany('App\Quiz');
    }

    public function scopeSelectedQuestions($query)
    {
        return $query->leftJoin('health_question_quiz', 'health_questions.id', '=', 'health_question_quiz.health_question_id');
    }
}
