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
            'accession_id',
            'inconsistency_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function inconsistency()
    {
        return $this->belongsTo('App\Inconsistency', 'inconsistency_id');
    }
}

