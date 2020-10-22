<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessionMedicalAnalysis extends Model
{
    protected $table = 'accession_medical_analysis';

    protected $fillable = [
        'accession_id',
        'beneficiary_id',
        'risk_grade_id',
        'suggestion_id',
        'justification'
    ];

    public function beneficiary()
    {
        return $this->belongsTo('App\Beneficiary', 'beneficiary_id');
    }

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function suggestion()
    {
        return $this->belongsTo('App\Suggestion');
    }

    public function riskGrade()
    {
        return $this->belongsTo('App\RiskGrade');
    }

    public function cids()
    {
        return $this->belongsToMany('App\Cid', 'cids_medical_analysis', 'medical_analysis_id', 'cid_id');
    }
    
}
