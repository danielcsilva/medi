<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cid extends Model
{   
    protected $table = 'cids';
    
    protected $fillable = ['cid', 'description'];

    public function analysis()
    {
        return $this->belongsToMany('App\Cid', 'cids_medical_analysis', 'cid_id', 'medical_analysis_id');
    }
}
