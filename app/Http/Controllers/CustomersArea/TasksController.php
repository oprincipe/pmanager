<?php

namespace App\Http\Controllers\CustomersArea;

use App\Http\Controllers\Controller;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;

class TasksController extends Controller
{

	public function __construct()
	{
		$this->middleware("auth:customer");
	}


	private function accessDenied($msg = "")
	{
		if(empty($msg)) {
			$msg = "Access denied";
		}
		return redirect()->route('customersarea.dash')->withErrors($msg);
	}


	/**
	 * Show the task resume
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show($task_id)
	{
		$task = Task::find($task_id);
		if(!$task) {
			return $this->accessDenied("Task not found");
		}

		//Verify the customer owner
		$project = $task->project;
		$customer = $project->customers()->where("customer_id", Auth::user()->id)->first();
		if(empty($customer->id)) {
			return $this->accessDenied();
		}

		$comments = $task->comments()->orderBy('updated_at','created_at')->get();
		$files    = $task->files()->orderBy('updated_at','created_at')->get();

		$data = array(
			'task' => $task,
			'comments' => $comments,
			'files' => $files,
			'commentable_type' => "App\Task",
			'commentable_id' => $task->id,
			'uploadable_type' => "App\Task",
			'uploadable_id' => $task->id,
		);

		return view("customersarea.tasks.show", $data);
	}

}
