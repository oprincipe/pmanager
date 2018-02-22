<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
	public $table = "task_user";

	protected $fillable = array(
		'task_id',
		'user_id',
	);

	public function user()
	{
		return $this->belongsTo("App\User");
	}

	public function task()
	{
		return $this->belongsTo("App\Task");
	}


}
