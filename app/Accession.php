<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Accession extends Model
{
    protected $fillable = ['proposal_number', 'financier_id', 'company_id', 
                           'quiz_id', 'health_plan_id', 'received_at', 'comments',
                           'admin_partner', 'initial_validity', 'consult_partner', 
                           'broker_partner', 'entity'
                        ];


    public function inconsistency()
    {
        return $this->belongsTo('App\Inconsistency', 'inconsistency_id');
    }

    public function financier()
    {
        return $this->hasOne('App\Beneficiary', 'accession_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    public function getReceivedAtAttribute($value)
    {
        return DateTime::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function getInitialValidityAttribute($value)
    {
        return DateTime::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    public function setInitialValidityAttribute($value)
    {
        // $this->attributes['initial_validity'] = str_replace('/', '-', $value);
        $this->attributes['initial_validity'] = DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');

    }
    
}
