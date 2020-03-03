<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthDeclaration extends Model
{
    protected $fillable = ['period_item', 'comments', 'comment_item', 'comment_number', 'accession_id'];

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }
}
