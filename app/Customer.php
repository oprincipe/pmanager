<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

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
		"base_price",
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

	public function __toString()
	{
		return $this->fullName();
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

	/**
	 * Update user's tasks values if:
	 * - the task is related to a project with this customer
	 * - the customer is the first (or the only one) in the project
	 * - the task price is empty
	 */
	public function updateTaskPricesAndValues()
	{
	    $tasks = Auth::user()->assigned_tasks();
        foreach($tasks as $task)
        {
            if(false) $task = new Task();
            $price = $task->getPrice();
            if($price > 0) continue;
            $task->setPrice($this->base_price);
            $task->save();
  		}

	}


}
