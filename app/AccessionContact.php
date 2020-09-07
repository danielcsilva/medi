<?php

namespace App;

use DateTime;
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

    public function setContactedDateAttribute($value)
    {
        $this->attributes['contacted_date'] = DateTime::createFromFormat('d.m.Y', $value)->format('Y-m-d');
    }

    public function getContactedDateAttribute($value)
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('d.m.Y');
    }

}
