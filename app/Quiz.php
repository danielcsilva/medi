<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['name'];
    
    public function questions() 
    {
        return $this->belongsToMany('App\HealthQuestion');
    }
}
