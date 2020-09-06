<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthDeclarationSpecific extends Model
{
    protected $fillable = [
        'period_item', 
        'comment_item', 
        'comment_number', 
        'accession_id', 
        'question_id', 
        'quiz_id', 
        'beneficiary_id',
        'beneficiary_index'
    ];

    public function accession()
    {
        return $this->belongsTo('App\Accession', 'accession_id');
    }
}
