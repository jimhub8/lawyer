<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function cases()
    {
        return $this->hasMany('App\models\Case', 'status');
    }
}
