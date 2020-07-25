<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Company == customer for Medi Consultoria
 */
class Company extends Model
{
    protected $fillable = ['name', 'email', 'cnpj', 'telephone', 'contract'];

    public function accessions()
    {
        return $this->hasMany('App\Accession', 'company_id');
    }

    public function healthplans()
    {
        $this->belongsToMany('App\HealthPlans', 'health_plan_company', 'company_id');
    }

    public function getCnpjAttribute($value)
    {
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) . '/' . substr($value, 8, 4). '-' . substr($value, 12, 2);
    }

    public function setCnpjAttribute($value)
    {        
        return $this->attributes['cnpj'] = str_replace(['.', '-', '/'], '', $value);
    }

    public function users()
    {
        return $this->hasMany('App\User', 'company_id');
    }

    public function dashboards()
    {
        return $this->hasMany('App\Dashboard', 'company_id');
    }

}