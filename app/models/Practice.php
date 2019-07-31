<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    public function cases()
    {
        return $this->hasMany('App\models\Case', 'practice_area');
    }
}
