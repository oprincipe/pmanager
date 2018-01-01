<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProject extends Model
{

	protected $fillable = array(
		'project_id',
		'customer_id',
	);

}
