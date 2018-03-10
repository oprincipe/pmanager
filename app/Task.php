<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use function number_format;

class Task extends Model
{
	protected $fillable = array(
		'name',
		'description',
		'status_id',
		'project_id',
		'user_id',
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
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function project()
	{
		return $this->belongsTo('App\Project');
	}

	public function status()
	{
		return $this->belongsTo('App\TaskStatus');
	}

	public function save(array $options = [])
	{
		if(empty($this->hours)) $this->hours = 0;
		if(empty($this->hours_real)) $this->hours_real = 0;

		$this->value      = $this->getQuotedValue();
		$this->value_real = $this->getRealValue();

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

    /**
     * @todo This function will be related to workers and/or customers
     */
	public function getContactMail()
	{
		//return $this->company->getContactMail();
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
			$base_price = 0;
			foreach($customers as $customer)
			{
				if(!empty($customer->base_price)) {
					$base_price = $customer->base_price;
					break;
				}
			}

			return $base_price;
		}
	}


	/**
	 * The value is defined with the price and the hours
	 */
	public function getQuotedValue()
	{
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
		$price = $this->getPrice();
		$hours = ($this->hours_real > 0) ? $this->hours_real : 0;
		$this->value_real = number_format($price * $hours, 2);
		return $this->value;
	}


    /**
     * Process filters collection after running a search form
     * @param Collection $tasks
     * @return bool
     */
	public static function processFilterCollection(&$tasks)
    {
        if(Input::has("search_task_name")) {
            $tasks->where("name", "like", "%".Input::get("search_task_name")."%");
        }

        if(!empty(Input::get("search_task_status_id"))) {
            if(Input::get("search_task_status_id") == "actives") {
                $tasks->whereIn("status_id", TaskStatus::getActiveIds());
            }
            else {
                $tasks->where("status_id", (int) Input::get("search_task_status_id"));
            }
        }

        return true;
    }



	/**
	 * Permission to view this task
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function userCanView(User $user)
	{
		//Return true if is the owner
		if($this->user_id == $user->id) return true;

		/**
		 * Return true if the user is inside the users
		 * list
		 */
		$worker = $this->users()->where("user_id", $user->id)->first();
		if($worker) {
			return true;
		}

		return false;
	}

	/**
	 * Permission to add an user to this task
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function userCanAddUser(User $user)
	{
		//Return true if is the owner
		if($this->user_id == $user->id) return true;
		return false;
	}

	/**
	 * The task's owner could delete other users
	 * or a user can delete himself
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function userCanDelUser(User $user)
	{
		//Return true if is the owner
		if($this->user_id == $user->id) return true;
		return false;
	}


}
