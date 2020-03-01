<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accession extends Model
{
    protected $fillable = ['proposal_number', 'beneficiary_id', 'financier_id', 'company_id', 'address_id', 'health_plan_id', 'received_at'];


    public function inconsistency()
    {
        return $this->belongsTo('App\Inconsistency', 'inconsistency_id');
    }

    public function financier()
    {
        return $this->belongsTo('App\Beneficiary', 'beneficiary_id');
    }

    public function beneficiary()
    {
        return $this->belongsTo('App\Beneficiary', 'beneficiary_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id');
    }

    
}
