<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

	const SUPER_ADMIN   = 1;
	const COMPANY_OWNER = 2;
	const CUSTOMER      = 3;


	protected $fillable = array(
		'name',
	);


	/**
	 * A role has many users
	 */
	public function users()
	{
		return $this->hasMany("App\User");
	}


}
