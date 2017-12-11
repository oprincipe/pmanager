<?php

namespace App\Http\Controllers;

use App\Company;
use App\Project;
use App\Task;
use App\TaskStatus;
use function back;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function is_null;

class ProjectsController extends Controller
{
	private $data;

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

		$task_statuses = TaskStatus::all();
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

		$this->data = array(
			'project' => $project,
			'comments' => $comments,
			'files'     => $files,
			'task_statuses' => $task_statuses,
			'commentable_type' => "App\Project",
			'commentable_id' => $project->id,
			'uploadable_type' => "App\Project",
			'uploadable_id' => $project->id,
			'active_status' => $active_status
		);

		return view("projects.show", $this->data);
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
