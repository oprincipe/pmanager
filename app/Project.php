<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{

	protected $fillable = array(
		'name',
		'description',
		'user_id',
		'hours',
		'value'
	);

	public function save(array $options = [])
	{
		$retval = parent::save($options);

		if($retval && $this->id > 0 && ($this->hours <= 0 || $this->value <= 0)) {
			$this->updateHoursAndValue();
		}

		return $retval;
	}


	/**
	 * A project belongs to:
	 * - user (many)
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	/**
	 * @see user()
	 */
	public function owner()
	{
		return $this->user();
	}

	/**
	 * @param int $user_id
	 *
	 * @return bool
	 */
	public function isOwner(int $user_id)
	{
		return $this->user_id === $user_id;
	}


	/**
	 * Return the list of Users related to ProjectUsers
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users()
	{
		return $this->belongsToMany("App\User");
	}



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


	public function userCanAddUser(User $user)
	{
		//Return true if is the owner
		if($this->user_id == $user->id) return true;
		return false;
	}

	/**
	 * The project's owner could delete other users
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



	/**
	 * Count how many task are on project
	 *
	 * @param int|null $status_id
	 *
	 * @return mixed
	 */
	public function tasks($status_id = null)
	{
		if(!empty($status_id)) {
			return $this->hasMany('App\Task')->where(['status_id' => $status_id])->get();
		}
		return $this->hasMany('App\Task');
	}

	/**
	 * Count how many task are on project
	 *
	 * @param int|null $status_id
	 *
	 * @return mixed
	 */
	public function tasks_count($status_id = null)
	{
		$data = ['project_id' => $this->id];
		if($status_id !== null) {
			$data['status_id'] = $status_id;
		}
		$res = Task::where($data)->count();
		return $res;
	}

	/**
	 * Count hours took for every status id
	 */
	public function get_task_hours_resume()
	{
		$sql = "SELECT
				t.`status_id`,
				t2.`name`,
				    SUM(t.`hours`) AS `tot_hours`,
				    SUM(t.`hours_real`) AS `tot_hours_real`,
				    SUM(t.value) AS `tot_values`
				FROM
				    `tasks` t
				INNER JOIN task_statuses t2 ON t.status_id = t2.id
				WHERE
				t.`project_id` = ".$this->id."
				GROUP BY t.`status_id`, t2.name";
		$rs = DB::select($sql);
		return $rs;
	}


	/**
	 * A project belongs to many Customers
	 * Laravel search for a Model named CustomerProject
	 */
	public function customers()
	{
		return $this->belongsToMany("App\Customer", "customer_projects");
	}


	public function comments()
	{
		return $this->morphMany('App\Comment', 'commentable');
	}

	public function files()
	{
		return $this->morphMany('App\File', 'uploadable');
	}


	public function delete()
	{
		//Delete comments
		$this->comments()->delete();

		return parent::delete(); // TODO: Change the autogenerated stub
	}


	public function updateHoursAndValue()
	{
		$sql = "UPDATE projects p SET p.`hours` = (SELECT IFNULL(SUM(t.`hours_real`),0) FROM tasks t WHERE t.`project_id` = p.`id`)
				WHERE p.id = ".$this->id;
		DB::connection()->getPdo()->exec($sql);
		$sql = "UPDATE projects p SET p.`value` = (SELECT IFNULL(SUM(t.`value_real`),0) FROM tasks t WHERE t.`project_id` = p.`id`)
				WHERE p.id = ".$this->id;
		DB::connection()->getPdo()->exec($sql);
	}

	public function getViewRoute()
	{
		return route('projects.show', ['project_id' => $this->id]);
	}
}
