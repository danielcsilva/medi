<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    public function questions() 
    {
        return $this->belongsToMany('App\HealthQuestion', 'quiz_id');
    }
}
