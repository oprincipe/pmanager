<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
	protected $fillable = array(
		'task_id',
		'user_id',
	);



}
