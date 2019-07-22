<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solutions extends Model
{
    public $primarykey = 'id';
    public function problems()
    {
        return $this->belongsTo('App\Problems','problems_id');
    }
    public function user()
    {
        return $this->belongsTo('App\user','user_id');
    }
}
