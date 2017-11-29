<?php

namespace App\Http\Controllers;

use App\Company;
use App\Project;
use App\TaskStatus;
use function back;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
		$projects = Project::where("user_id", Auth::user()->id)->paginate(20);

		return view("projects.index", array("projects" => $projects));
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


		$this->data = array(
			'project' => $project,
			'comments' => $comments,
			'task_statuses' => $task_statuses,
			'commentable_type' => "App\Project",
			'commentable_id' => $project->id
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
