<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function case()
    {
        return $this->belongsTo('App\models\Cases', 'case_id');
    }
}
