<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $with =  ['user'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'assigned_to');
    }
}
