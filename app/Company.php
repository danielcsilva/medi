<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function beneficiaries()
    {
        $this->hasMany('App\Beneficiary', 'beneficiary_id');
    }

    public function healthplans()
    {
        $this->belongsToMany('App\HealthPlans', 'health_plan_company', 'company_id');
    }
}
