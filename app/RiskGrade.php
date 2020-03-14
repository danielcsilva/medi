<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskGrade extends Model
{
    protected $fillable = ['risk'];
    
    public function accession()
    {
        return $this->belongsTo('App\Accession', 'suggestion_id');
    }
}
