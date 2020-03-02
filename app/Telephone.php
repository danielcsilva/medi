<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Telephone extends Model
{
    protected $fillable = ['telephone', 'accession_id'];

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }

    public function setTelephoneAttribute($value)
    {
        $this->attributes['telephone'] = str_replace(['(', ')', '-'], '', $value);
    }
}
