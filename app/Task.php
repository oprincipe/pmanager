<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function array_key_exists;
use function number_format;

class Task extends Model
{
	protected $fillable = array(
		'name',
		'description',
		'status_id',
		'project_id',
		'user_id',
		'company_id',
		'hours_real',
		'hours',
		'price',
		'value',
		'value_real'
	);



	/**
	 * A task belongs to:
	 * - user
	 * - project
	 * - company
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function project()
	{
		return $this->belongsTo('App\Project');
	}

	public function company()
	{
		return $this->belongsTo('App\Company');
	}

	public function status()
	{
		return $this->belongsTo('App\TaskStatus');
	}

	public function save(array $options = [])
	{
		if(empty($this->hours)) $this->hours = 0;
		if(empty($this->hours_real)) $this->hours_real = 0;

		if(!array_key_exists("no_calc", $options)) {
			$this->value      = $this->getQuotedValue();
			$this->value_real = $this->getRealValue();
		}

		return parent::save($options);
	}

	/**
	 * A task belongs to many users
	 * Laravel search for a Model named TaskUser
	 */
	public function users()
	{
		return $this->belongsToMany("App\User");
	}


	public function comments()
	{
		return $this->morphMany("App\Comment", "commentable");
	}

	public function files()
	{
		return $this->morphMany("App\File", "uploadable");
	}

	public function delete()
	{
		//Delete comments
		$this->comments()->delete();

		return parent::delete(); // TODO: Change the autogenerated stub
	}

	public function getContactMail()
	{
		return $this->company->getContactMail();
	}

	public function getViewRoute()
	{
		return route('tasks.show', ['task_id' => $this->id]);
	}

	/**
	 * If the price is zero it will be set from the base_price taken
	 * from the first project's customer
	 */
	public function getPrice()
	{
		if($this->price > 0) {
			return $this->price;
		}

		//get the customer
		$customers = $this->project->customers;
		if(!empty($customers)) {
			$customer = $customers->first();
			return $customer->base_price;
		}
	}


	/**
	 * The value is defined with the price and the hours
	 */
	public function getQuotedValue()
	{
		if($this->value > 0) {
			return $this->value;
		}

		$price = $this->getPrice();
		$hours = ($this->hours > 0) ? $this->hours : 0;
		$this->value = number_format($price * $hours, 2);
		return $this->value;
	}

	/**
	 * The value is defined with the price and the hours_real
	 */
	public function getRealValue()
	{
		if($this->value_real > 0) {
			return $this->value_real;
		}
		$price = $this->getPrice();
		$hours = ($this->hours_real > 0) ? $this->hours_real : 0;
		$this->value_real = number_format($price * $hours, 2);
		return $this->value;
	}

}
