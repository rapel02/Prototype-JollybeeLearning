<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    public $primarykey = 'id';

    public function materials()
    {
        return $this->hasMany('App\Materials', 'topics_id','id');
    }
    public function problem_topic_relation() {
        return $this->hasMany('App\problem_topic_relation','topic_id','id');
    }
    public function material_topic_relation() {
        return $this->hasMany('App\material_topic_relation','topic_id','id');
    }
}
