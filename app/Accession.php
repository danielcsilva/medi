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
                           'broker_partner', 'entity', 'contacted_date', 'contacted_comments'
                        ];


    public function inconsistencies()
    {
        return $this->belongsToMany('App\Inconsistency', 'acession_inconsistency');
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
        $date = DateTime::createFromFormat('Y-m-d', $value);
        if ($date) {
             return $date->format('d/m/Y');
        }
    }

    public function setInitialValidityAttribute($value)
    {
        $this->attributes['initial_validity'] = DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getContactedDateAttribute($value)
    {
        $date = null;

        try {
            
            $date = DateTime::createFromFormat('Y-m-d', $value)->format('d/m/Y');

        } catch(Throwable $t){

        }
        
        return $date;
    }


    public function setContactedDateAttribute($value)
    {
        $this->attributes['contacted_date'] = DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    
}
