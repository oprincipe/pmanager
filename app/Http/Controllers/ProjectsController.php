<?php

namespace App\Http\Controllers;

use App\Company;
use App\Customer;
use App\CustomerProject;
use App\Mail\TaskStatusChanged;
use App\Project;
use App\Task;
use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use function back;
use function is_null;
use function view;

class ProjectsController extends Controller
{
	private $data;
	private $project;

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user_companies = Auth::user()->companies()->get();
		$company_ids = array();
		foreach($user_companies as $company)
		{
			$company_ids[] = $company->id;
		}

		$projects = Project::where("user_id", Auth::user()->id)
			->whereIn("company_id", $company_ids, "or")
            ->paginate(20);

		/*
		$projects = DB::table("projects")
		->whereIn("company_id", $company_ids, "or")
		->get();
		 */

		$task_statuses = TaskStatus::all();

		$data = array(
			"projects" => $projects,
			'task_statuses' => $task_statuses,
		);
		return view("projects.index", $data);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param int $company_id company_id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create($company_id = null)
	{
		$companies = null;
		if(is_null($company_id)) {
			$companies = Company::where("user_id", Auth::user()->id)->get();
			if(empty($companies)) {
				return back()->withInput()->withErrors('You must create a company first before create a project');
			}
		}

		$this->data = array(
			'company_id' => $company_id,
			'companies' => $companies,
		);

		return view("projects.create",$this->data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$project = Project::create([
			                           'name' => $request->input("name"),
			                           "description" => $request->input("description"),
			                           "company_id" => $request->input("company_id"),
			                           "user_id" => Auth::user()->id
		                           ]);

		if($project) {
			return redirect()->route('projects.show', ['project' => $project->id])
			                 ->with("success", "Project created successfully");
		}
		else {
			return back()->withInput()->with("error", "Errors while creating Project");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Project $project
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(Project $project)
	{
		$project = $project->find($project->id);
		$this->project = $project;

		$task_statuses = TaskStatus::all()->sortBy("position");
		$comments = $project->comments()->orderBy('updated_at','created_at')->get();
		$files    = $project->files()->orderBy('updated_at','created_at')->get();

		$active_status = TaskStatus::STATUS_STAND_BY;
		$session_status = \session("selected_status");
		if(!empty($session_status)) {
			$active_status = $session_status;
		}
		else if(!empty(request()->get("task_status_id"))) {
			$active_status = (int) request()->get("task_status_id");
		}
		$tasks_resume = $project->get_task_hours_resume();

		//User customer's list
		$customers = Customer::where("user_id", Auth::user()->id)
		                     ->whereNOTIn("id", function($query) {
			                     $query->select('customer_id')
			                           ->from(with(new CustomerProject())->getTable())
			                           ->where('project_id', $this->project->id);
		                     })
		                     ->orderBy('name')->orderBy('surname')->get();

		//User project customers
		$customers_project = $project->customers()->where('user_id', Auth::user()->id)
		                                          ->orderBy('name')->orderBy('surname')->get();

		$this->data = array(
			'project' => $project,
			'comments' => $comments,
			'files'     => $files,
			'task_statuses' => $task_statuses,
			'tasks_resume' => $tasks_resume,
			'commentable_type' => "App\Project",
			'commentable_id' => $project->id,
			'uploadable_type' => "App\Project",
			'uploadable_id' => $project->id,
			'active_status' => $active_status,
			'customers' => $customers,
			'customers_project' => $customers_project
		);

		return view("projects.show", $this->data);
	}

	/**
	 * Return json element with the list of tasks
	 * depending of their status
	 *
	 * @param $project_id
	 * @param $task_status_id
	 */
	public function ajax_getProjectTasks(Request $request)
	{
		$project_id = $request->project_id;
		$task_status_id = $request->task_status_id;

		$project = Project::find($project_id);
		$task_status = TaskStatus::find($task_status_id);
		$tasks = $project->tasks($task_status_id);

		$data = [
			"project" => $project,
			"task_status" => $task_status,
			"taks" => $tasks
		];

		$view = View::make("partials.tasks-project-list-block-status", $data);
		$res = [
			"html" => $view->render()
		];

		return \response()->json($res);
	}


	/**
	 * Change the status of a given task
	 *
	 * @param Request $request
	 */
	public function ajax_changeTaskStatus(Request $request)
	{
		$project_id = $request->project_id;
		$task_id    = $request->task_id;
		$task_status_id = $request->task_status_id;

		if(empty($project_id)) {
			$res = [
				"err" => true,
				"msg" => "Project not set"
			];
		}
		else if(empty($task_id)) {
			$res = [
				"err" => true,
				"msg" => "Task not set"
			];
		}
		else if(empty($task_status_id)) {
			$res = [
				"err" => true,
				"msg" => "Task status not set"
			];
		}
		else {
			$project = Project::find($project_id);
			$task    = Task::find($task_id);
			$old_status = TaskStatus::find($task->status_id);

			if(false) $task = new Task();
			$task->status_id = (int) $task_status_id;
			if($task->save()) {

				//Send mail to company owner
				$owner_mail = $project->company->email;
				if(!empty($owner_mail)) {
					Mail::to($owner_mail)->send(new TaskStatusChanged($task, true));
				}

				$res = [
					"err" => false,
					"task" => $task,
					"project" => $project,
					"old_status" => $old_status
				];

			}
			else {
				$res = [
					"err" => true,
					"msg" => "Errors while saving task",
					"task" => $task,
					"project" => $project,
					"old_status" => $old_status
				];
			}

		}


		return response()->json($res);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Project  $Project
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Project $Project)
	{
		return view("projects.edit", ['project' => $Project]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Project  $Project
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Project $Project)
	{
		//Save data
		$ProjectUpdate = Project::find($Project->id)
		                        ->update([
			                                 'name' => $request->input("name"),
			                                 'description' => $request->input("description")
		                                 ]);

		//Redirect
		if($ProjectUpdate) {
			return redirect()->route('projects.show', ['project' => $Project->id])
			                 ->with('success', 'Project updated successfully');
		}
		else {
			return back()->withInput();
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Project  $Project
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Project $Project)
	{
		$findProject = Project::find($Project->id);
		if($findProject->delete()) {
			return redirect()->route('companies.show',['company' => $Project->company_id])
			                 ->with('success', 'Project deleted successfully');
		}

		return back()->withInput()->with('error', 'Project could not be deleted');
	}
}
