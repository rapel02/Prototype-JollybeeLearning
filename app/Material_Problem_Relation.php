<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material_Problem_Relation extends Model
{
    protected $primary_key = ['material_id', 'problem_id'];
    public $incrementing = false;
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     *
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query->where('problem_id', '=', $this->getAttribute('problem_id'))->where('topic_id', '=', $this->getAttribute('topic_id'));
        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }

    public function materials() {
        return $this->belongsTo('App\Materials','material_id');
    }
    public function problems() {
        return $this->belongsTo('App\Problems','problem_id');
    }
}
