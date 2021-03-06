<?php

namespace App;

use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Throwable;

class Accession extends Model
{
    protected $fillable = ['proposal_number', 'financier_id', 'company_id', 
                           'quiz_id', 'health_plan_id', 'received_at', 'comments',
                           'admin_partner', 'initial_validity', 'consult_partner', 
                           'broker_partner', 'entity', 'contacted_date', 'contacted_comments',
                           'to_contact', 'holder_id', 'to_medic_analysis'
                        ];

    public function financier()
    {
        return $this->hasOne('App\Beneficiary', 'accession_id');
    }

    public function beneficiaries() 
    {
        return $this->hasMany('App\Beneficiary');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function riskGrade()
    {
        return $this->belongsTo('App\RiskGrade', 'risk_grade_id');
    }

    public function suggestion()
    {
        return $this->belongsTo('App\Suggestion', 'suggestion_id');
    }

    public function healthplan()
    {
        return $this->belongsTo('App\HealthPlan', 'health_plan_id');
    }

    public function inconsistencies()
    {
        return $this->morphToMany('App\Inconsistency', 'inconsistent');
    }

    public function getReceivedAtAttribute($value)
    {
        return DateTime::createFromFormat('Y-m-d', $value)->format('d.m.Y');
    }
    
    public function setReceivedAtAttribute($value)
    {
        $this->attributes['received_at'] = $value;
        if (strpos($value, '.') !== false) {
            $this->attributes['received_at'] = DateTime::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        } 
    }

    public function getInitialValidityAttribute($value)
    {
        $date = DateTime::createFromFormat('Y-m-d', $value);
        if ($date) {
             return $date->format('d.m.Y');
        }
    }

    public function setInitialValidityAttribute($value)
    {
        $this->attributes['initial_validity'] = $value;
        if (strpos($value, '.') !== false) {
            $this->attributes['initial_validity'] = DateTime::createFromFormat('d.m.Y', $value)->format('Y-m-d');
        }
    }
    
}
