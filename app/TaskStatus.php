<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
	const STATUS_STAND_BY = 1;
	const STATUS_WAITING = 2;
	const STATUS_WORKING = 3;
	const STATUS_CLOSED = 4;

    protected $fillable = array(
		'name'
    );

	/**
	 * Status could be found on many tasks
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
    public function tasks()
    {
    	return $this->belongsToMany("App\Task");
    }


    public function icon()
    {
    	switch ($this->id):
		    case self::STATUS_STAND_BY: return '<i class="fa fa-clock-o"></i>';
		    case self::STATUS_WAITING: return '<i class="fa fa-check"></i>';
		    case self::STATUS_WORKING: return '<i class="fa fa-play"></i>';
		    case self::STATUS_CLOSED: return '<i class="fa fa-lock"></i>';
		    default: return '<i class="fa fa-question"></i>';
	    endswitch;
    }

}
