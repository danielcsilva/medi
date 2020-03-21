<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RiskGrade extends Model
{
    protected $fillable = ['risk'];
    
    public function accession()
    {
        return $this->hasMany('App\Accession', 'risk_grade_id');
    }
}
