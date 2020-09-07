<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inconsistency extends Model
{
    protected $fillable = ['name'];

    public function accessions()
    {
        return $this->morphedByMany('App\Accession', 'inconsistent');
    }

    public function accessionContacts()
    {
        return $this->morphedByMany('App\AccessionContact', 'inconsistent');
    }

    public function accessionInterviews()
    {
        return $this->morphedByMany('App\AccessionInterview', 'inconsistent');
    }
}
