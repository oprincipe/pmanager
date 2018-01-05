<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticable
{
	use Notifiable;

	protected $guard = "customer";

	protected $fillable = [
		"user_id",
		"name",
		"surname",
		"city",
		"address",
		"pcode",
		"province",
		"country",
		"vat",
		"pid",
		"email",
		"pec",
		"phone",
		"fax",
		"mobile",
		"type",
		"password",
		"deleted",
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];


	/**
	 * A customer is associated to an user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
	{
		return $this->belongsTo("App\User");
	}


	public function projects()
	{
		return $this->belongsToMany("App\Project", "customer_projects");
	}


	public function fullName()
	{
		return $this->name." ".$this->surname;
	}

	public function fullAddress()
	{
		$address = "";

		if(!empty($this->address)) $address .= $this->address;
		if(!empty($this->city)) $address .= " ".$this->city;
		if(!empty($this->province)) $address .= " (".$this->province.")";
		if(!empty($this->country)) $address .= " - ".$this->country;

		return trim($address);
	}




}
