<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cid extends Model
{   
    protected $table = 'cids';
    
    protected $fillable = ['cid', 'description'];

    public function interviews()
    {
        return $this->belongsToMany('App\Cid', 'cids_interviews', 'cid_id', 'interview_id');
    }
}
