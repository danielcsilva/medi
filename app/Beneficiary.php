<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = ['name', 'email', 'cpf', 'birth_date', 'height', 'weight', 'imc', 'gender'];

    public function telephones()
    {
        $this->hasMany('App\Beneficiary', 'beneficiary_id');
    }

    public function accession()
    {
        return $this->hasMany('App\Accession', 'beneficiary_id');
    }

    public function getBirthDateAttribute($value)
    {   
        return DateTime::createFromFormat('Y-m-d', $value)->format('d/m/Y');
    }

    // public function setBirthDateAttribute($value)
    // {   
    //     $this->attributes['birth_date'] = DateTime::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }

    public function setCpfAttribute($value)
    {   
        $this->attributes['cpf'] = str_replace(['.', '-'], '', $value);
    }

    public function setHeightAttribute($value)
    {           
        $this->attributes['height'] = str_replace(',', '.', $value);
    }

    public function setWeightAttribute($value)
    {   
        $this->attributes['weight'] = str_replace(',', '.', $value);
    }

    public function getHeightAttribute($value)
    {   
        return str_replace('.', ',', $value);
    }

    public function getWeightAttribute($value)
    {   
        return str_replace('.', ',', $value);
    }

}
