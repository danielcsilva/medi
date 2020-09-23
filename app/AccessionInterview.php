<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessionInterview extends Model
{
    protected $fillable = [
            'interviewed_name', 
            'interview_date', 
            'interviewed_by', 
            'interview_comments', 
            'interview_validated', 
            'user_id', 
            'accession_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function inconsistencies()
    {
        return $this->morphToMany('App\Inconsistency', 'inconsistent');
    }

    public function cids()
    {
        return $this->belongsToMany('App\Cid', 'cids_interviews', 'interview_id', 'cid_id');
    }
}

