<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $fillable = ['suggestion'];
    
    public function accession()
    {
        return $this->belongsTo('App\Accession', 'suggestion_id');
    }
}
