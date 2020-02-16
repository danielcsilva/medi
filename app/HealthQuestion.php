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
}
