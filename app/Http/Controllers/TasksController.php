<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use App\TaskStatus;
use function back;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;

class TasksController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}


	private function accessDenied($msg = "")
	{
		if(empty($msg)) {
			$msg = "Access denied";
		}
		return redirect()->route('companies.index')->withErrors($msg);
	}


	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Non c'è un indice per i task, redirect a companies
	    return redirect()->route('companies.index');
    }

    /**
     * Show the form for creating a new task.
     * The user must be administrator or must be the owner of the project
     *
     * @return \Illuminate\Http\Response
     */
    public function create($project_id = null)
    {
    	if(empty($project_id)) {
    		return back()->withInput()->withErrors(['Company must be selected','Project must be selected']);
	    }

	    $project = Project::find($project_id);
	    if(!$project) {
		    return back()->withInput()->withErrors(['Project task not found']);
	    }

	    //Check permissions
	    if(Auth::user()->role_id !== 1 && $project->company->user_id !== Auth::user()->id) {
	    	$this->accessDenied();
	    }

	    $task_statuses = TaskStatus::all();
	    $task = new Task();
        $task->project_id = $project->id;
        $task->company_id = $project->company_id;

    	return view("tasks.form", ['task' => $task, 'task_statuses' => $task_statuses]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

	    $validatedData = $request->validate(
	    	[
			    'company_id' => 'exists:companies,id',
			    'project_id' => 'exists:projects,id',
			    'name' => 'required|max:191',
                'hours' => 'required|integer|min:1',
            ]);


	    $task = new Task();
	    if($validatedData) {

		    //Check permissions
		    $project = Project::find($request->post("project_id"));
		    if(Auth::user()->role_id !== 1 && $project->company->user_id !== Auth::user()->id) {
			    $this->accessDenied();
		    }

			$task->fill($request->all());
			$task->user_id = Auth::user()->id;
			if(empty($task->hours)) {
				$task->hours = 1;
			}

			if($task->save()) {
				return redirect()->route('projects.show', ['project_id' => $task->project_id])
					->with('success', 'Task created successfully');
			}
		}

	    return back()->withInput()->withErrors('Errors saving task');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
    	$comments = $task->comments;

	    $data = array(
		    'task' => $task,
		    'comments' => $comments,
		    'commentable_type' => "App\Task",
		    'commentable_id' => $task->id
	    );

	    return view("tasks.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
    	$task_statuses = TaskStatus::all();
	    return view("tasks.form", [
	    	'task' => $task,
		    'task_statuses' => $task_statuses
	    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
	    $validatedData = $request->validate(
		    [
			    'company_id' => 'exists:companies,id',
			    'project_id' => 'exists:projects,id',
			    'name' => 'required|max:191',
			    'hours' => 'required|integer|min:1',
		    ]);

	    $task = Task::find($task->id);

	    //Check permissions
	    $project = $task->project;
	    if(Auth::user()->role_id !== 1 && $project->company->user_id !== Auth::user()->id) {
		    $this->accessDenied();
	    }

	    if($task &&
		    $validatedData) {
		    $task->fill($request->all());
		    if(empty($task->user_id)) {
			    $task->user_id = Auth::user()->id;
		    }

		    if($task->save()) {
			    return redirect()->route('projects.show', ['project_id' => $task->project_id])
			                     ->with('success', 'Task created successfully');
		    }
	    }

	    return back()->withInput()->withErrors('Errors saving task');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
