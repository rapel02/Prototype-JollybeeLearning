<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    public $primarykey = 'id';
    protected $attributes = array(
      'content' => ''
    );

    public function topics()
    {
        return $this->belongsTo('App\Topics','topics_id');
    }
    public function material_topic_relation() {
        return $this->hasMany('App\material_topic_relation','material_id','id');
    }
    public function material_problem_relation() {
        return $this->hasMany('App\material_problem_relation','material_id','id');
    }
}
