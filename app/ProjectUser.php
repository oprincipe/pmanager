<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectUser extends Model
{
	protected $fillable = array(
		'project_id',
		'user_id',
	);
}
