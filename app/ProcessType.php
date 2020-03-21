<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessType extends Model
{
    protected $table = 'process_types';

    protected $fillable = ['type_of_process'];

    public function accessions()
    {
        return $this->hasMany('App\Accessions', 'process_type_id');
    }
}
