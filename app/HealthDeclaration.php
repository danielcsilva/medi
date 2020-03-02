<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthDeclaration extends Model
{
    protected $fillable = ['question', 'answer', 'period', 'comments', 'item_number_obs', 'item_number', 'accession_id'];

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }
}
