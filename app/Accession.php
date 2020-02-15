<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accession extends Model
{
    protected $fillable = ['proposal_number', 'beneficiary_id', 'financier_id', 'company_id', 'address_id', 'health_plan_id'];


    public function inconsistency()
    {
        $this->belongsTo('App\Inconsistency', 'inconsistency_id');
    }

}
