<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessionContact extends Model
{
    protected $fillable = [
        'contacted_date', 
        'contacted_comments', 
        'user_id', 
        'accession_id'
    ];

    public function accession() 
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function inconsistencies()
    {
        return $this->morphToMany('App\Inconsistency', 'inconsistent');
    }

}
