<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $fillable = ['user_id', 'accession_id', 'action'];
}
