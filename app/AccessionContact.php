<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessionContact extends Model
{
    protected $fillable = [
        'contacted_date', 
        'contacted_comments', 
        'inconsistency_id', 
        'user_id', 
        'accession_id'
    ];

    public function accession() 
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function inconsistency()
    {
        return $this->belongsTo('App\Inconsistency', 'inconsistency_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
