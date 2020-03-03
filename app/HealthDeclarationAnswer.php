<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthDeclarationAnswer extends Model
{
    protected $fillable = ['question', 'answer', 'accession_id', 'beneficiary_id'];

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function beneficiary()
    {
        return $this->belongsTo('App\Beneficiary', 'beneficiary_id');
    }
}
