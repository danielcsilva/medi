<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function questions() 
    {
        return $this->belongsToMany('App\HealthQuestion');
    }
}
