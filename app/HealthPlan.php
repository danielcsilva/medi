<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthPlan extends Model
{
    protected $fillable = ['name'];
    
    public function companies()
    {
        $this->belongsToMany('App\Company', 'health_plan_company', 'healthplan_id');
    }
}
