<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Cases extends Model
{
    public $with = ['events', 'client', 'firm', 'status', 'practice_area', 'leading_attoney'];
    public function events()
    {
        return $this->hasMany('App\models\Event', 'case_id');
    }

    public function client()
    {
        return $this->belongsTo('App\models\Client', 'client_id');
    }
    public function firm()
    {
        return $this->belongsTo('App\models\Firm', 'firm_id');
    }
    public function status()
    {
        return $this->belongsTo('App\models\Status', 'status');
    }
    public function practice_area()
    {
        return $this->belongsTo('App\models\Practice', 'practice_area');
    }
    public function leading_attoney()
    {
        return $this->belongsTo('App\User', 'leading_attoney');
    }
}
