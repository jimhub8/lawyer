<?php

namespace App\models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Client extends Model
{
    use SoftDeletes;

    public function scopeUserid($query)
    {
        if (!Auth::user()->hasRole('Admin')) {
            return $query->where('user_id', Auth::id());
        }
    }

    public function orders()
    {
        return $this->hasMany('App\models\Saleorder', 'sender_id');
    }
}
