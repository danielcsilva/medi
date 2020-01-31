<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthPlan extends Model
{
    public function companies()
    {
        $this->belongsToMany('App\Company', 'health_plan_company', 'healthplan_id');
    }
}
