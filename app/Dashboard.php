<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $fillable = ['label', 'dashboard_link', 'company_id', 'active'];

    public function companies()
    {
        return $this->belongsTo('App\Company');
    }
}
