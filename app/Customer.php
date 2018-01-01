<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

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
		"deleted",
	];


	/**
	 * A customer is associated to many user
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function user()
	{
		return $this->belongsTo("\App\User");
	}

	public function projects()
	{
		return $this->belongsToMany("App\Project");
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
