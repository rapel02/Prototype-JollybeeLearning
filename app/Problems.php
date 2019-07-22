<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Problems extends Model
{
    use Sortable;


    protected $fillable = [ 'onlinejudge', 'problemid','difficulty'];
    public $sortable = ['onlinejudge', 'problemid', 'title'];

    public function solution(){
        return $this->hasMany('App\Solutions','problems_id','id');
    }

    public function problem_topic_relation() {
        return $this->hasMany('App\problem_topic_relation','problem_id','id');
    }
    public function material_problem_relation() {
        return $this->hasMany('App\material_problem_relation','problem_id','id');
    }
}
