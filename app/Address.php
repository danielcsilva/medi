<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['cep', 'address', 'number', 'complement', 'accession_id', 'city', 'state'];

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }
}
