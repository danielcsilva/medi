<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    public function telephones()
    {
        $this->hasMany('App\Beneficiary', 'beneficiary_id');
    }

    public function accession()
    {
        return $this->hasMany('App\Accession', 'beneficiary_id');
    }
}
