<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDescription extends Model
{

    protected $fillable = array(
        'description'
    );

    protected $primaryKey = "task_id";
    public $timestamps = false;

    public function task()
    {
        return $this->belongsTo('App\Task');
    }

    public function __toString()
    {
        return $this->description;
    }

}
