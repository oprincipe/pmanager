<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use function array_key_exists;
use function number_format;

class Task extends Model implements Monetizable
{
    use UserRelations, UserCanPermissions, MonetizableTrait;

    protected $fillable = array(
		'name',
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
     * Preloaded and in memory objects.
     * This is to prevent overloading system and keep in memory
     * changes upon saving operations
     *
     * @var TaskUser[]
     */
    protected $taskUsers = array();


    public function getMoneyFields()
    {
        return [
            'status_id' => 'setStatusId',
            'hours_real' => 'setHoursReal',
            'hours' => 'setHours',
            'price' => 'setPrice',
        ];
    }

    public function isMoneyField($fieldName)
    {
        return array_key_exists($fieldName, $this->getMoneyFields());
    }


    /**
     * Get the related owner if not the main task user
     */
    public function owner()
    {
        if($this->isOwner(Auth::id())) {
            return $this->user;
        }
        else {
            return $this->getTaskUser(Auth::user())->owner();
        }
    }


    /**
     * The task related to the logged user
     *
     * @return Task|TaskUser
     */
    public function getTaskUser(User $_worker = null)
    {
        if(!empty($worker) && $this->isOwner(Auth::id())) {
            return $this;
        }
        else {
            $worker = (empty($_worker)) ? Auth::user() : $_worker;

            //Check in memory object
            if(!array_key_exists($worker->id, $this->taskUsers)) {
                $tu = TaskUser::where("user_id", $worker->id)
                    ->where("task_id", $this->id)
                    ->first();
                if(!$tu) {
                    //No task defined to this user, creating new one
                    $tu = new TaskUser();
                    $tu->user_id = $worker->id;
                    $tu->task_id = $this->id;
                }

                $this->taskUsers[$worker->id] = $tu;
            }

            return $this->taskUsers[$worker->id];
        }
    }


    /**
     * Get the description from related table
     * @return TaskDescription
     */
    public function description()
    {
        return $this->hasOne("App\TaskDescription");
    }


	public function project()
	{
		return $this->belongsTo('App\Project');
	}

	public function status()
	{
        if($this->isOwner(Auth::id())) {
            return $this->belongsTo('App\TaskStatus');
        }
        else {
            return $this->getTaskUser()->status();
        }
	}

	public function save(array $options = [])
	{
	    if($this->isOwner(Auth::id())) {
            if(empty($this->getHours())) $this->setHours(0);
            if(empty($this->getHoursReal())) $this->setHoursReal(0);

            $this->value      = $this->getQuotedValue();
            $this->value_real = $this->getRealValue();

            return parent::save($options);
        }
		else {
	        return $this->getTaskUser()->save($options);
        }
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

		//Delete users
        $this->users()->delete();


		return parent::delete(); // TODO: Change the autogenerated stub
	}


	public function getViewRoute()
	{
		return route('tasks.show', ['task_id' => $this->id]);
	}


    public function getStatusId()
    {
        if($this->isOwner(Auth::id())) {
            return $this->status_id;
        }
        else {
            return $this->getTaskUser()->getStatusId();
        }
    }

    public function setStatusId($value)
    {
        if($this->isOwner(Auth::id())) {
            $this->status_id = $value;
            parent::setAttribute("status_id", $value);
        }
        else {
            $this->getTaskUser()->setStatusId($value);
        }
    }

	/**
     * The price depends by the user who it's related to
     *
	 * If the price is zero it will be set from the base_price taken
	 * from the first project's customer
	 */
	public function getPrice()
	{
        if($this->isOwner(Auth::id())) {
            if ($this->price > 0) {
                return $this->price;
            }

            //get the customer
            $customers = $this->project->customers;
            if (!empty($customers)) {
                $base_price = 0;
                foreach ($customers as $customer) {
                    if (!empty($customer->base_price)) {
                        $base_price = $customer->base_price;
                        break;
                    }
                }

                return $base_price;
            }
        }
        else {
            return $this->getTaskUser()->getPrice();
        }
	}

    /**
     * Set the price of this task for logged user
     */
	public function setPrice($value)
    {
        if($this->isOwner(Auth::id())) {
            $this->price = $value;
            parent::setAttribute("price", $value);
        }
        else {
            $this->getTaskUser()->setPrice($value);
        }
    }


	/**
	 * The value is defined with the price and the hours
	 */
	public function getQuotedValue()
	{
	    if($this->isOwner(Auth::id())) {
            $price = $this->getPrice();
            $hours = ($this->getHours() > 0) ? $this->getHours() : 0;
            $this->value = number_format($price * $hours, 2);
            return $this->value;
        }
	    else {
	        return $this->getTaskUser()->getQuotedValue();
        }

	}

	/**
	 * The value is defined with the price and the hours_real
	 */
	public function getRealValue()
	{
	    if($this->isOwner(Auth::id())) {
            $price = $this->getPrice();
            $hours = ($this->getHoursReal() > 0) ? $this->getHoursReal() : 0;
            $this->value_real = number_format($price * $hours, 2);
            return $this->value_real;
        }
        else {
	        return $this->getTaskUser()->getRealValue();
        }
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
	 * Permission to add an user to this task
	 *
	 * @param User $user
	 *
	 * @return bool
	 */
	public function userCanAddUser(User $user)
	{
		return true;
		//if($this->user_id == $user->id) return true;
		//return false;
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



	public function getHours()
    {
        if($this->isOwner(Auth::id()))
        {
            return (int) $this->hours;
        }
        else {
            return $this->getTaskUser()->getHours();
        }
    }


    /**
     * @inheritDoc
     */
    public function setHours($value)
    {
        if($this->isOwner(Auth::id()))
        {
            $this->hours = $value;
            parent::setAttribute("hours", $value);
        }
        else {
            return $this->getTaskUser()->setHours($value);
        }
    }

    /**
     * @inheritDoc
     */
    public function getHoursReal()
    {
        if($this->isOwner(Auth::id()))
        {
            return (int) $this->hours_real;
        }
        else {
            return $this->getTaskUser()->getHoursReal();
        }
    }

    /**
     * @inheritDoc
     */
    public function setHoursReal($value)
    {
        if($this->isOwner(Auth::id()))
        {
            $this->hours_real = $value;
            parent::setAttribute("hours_real", $value);
        }
        else {
            return $this->getTaskUser()->setHoursReal($value);
        }
    }


    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->getRealValue();
    }
}
