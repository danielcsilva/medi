<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessStatus extends Model
{
    protected $table = 'process_status';

    protected $fillable = ['status'];

    public function accsessions()
    {
        return $this->hasMany('App\Accessions', 'process_status_id');
    }
}
