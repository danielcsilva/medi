<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthQuestion extends Model
{
    public function quizzes() 
    {
        return $this->belongsToMany('App\Quiz');
    }
}
