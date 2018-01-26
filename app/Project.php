<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{

	protected $fillable = array(
		'name',
		'description',
		'company_id',
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
	 * - company
	 */
	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function company()
	{
		return $this->belongsTo('App\Company');
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
				    `pmanager`.`tasks` t
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

	public function getContactMail()
	{
		return $this->company->getContactMail();
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
