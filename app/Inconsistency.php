<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inconsistency extends Model
{
    protected $fillable = ['name'];

    public function accessions()
    {
        return $this->belongsToMany('App\Accession', 'acession_inconsistency');
    }
}
