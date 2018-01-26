<?php

namespace App\Http\Controllers;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Mail\TaskStatusChanged;
use App\Project;
use App\Role;
use App\Task;
use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function back;
use function env;
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

		    //Fix time and user
		    $task->user_id = Auth::user()->id;
		    if(empty($task->hours)) {
			    $task->hours = 1;
		    }

		    /*
		     * The price could be set by the super admin
		     */
		    if(Auth::user()->role_id != Role::SUPER_ADMIN) {
				$task->price = $task->getPrice();
		    }
		    else {
		    	//Price is derived by the owner configurations
			    //Convert money
			    $task_price = $task->price;
			    $price = new Money($task_price, Currency::EUR(), true);
			    $price_str = str_replace(",",".",$price->formatSimple());
			    $task->price = $price_str;
		    }

			if($task->save()) {

				//Send mail to company owner
				$owner_mail = $project->company->email;
				if(!empty($owner_mail) && env("APP_ENV") !== "local") {
					Mail::to($owner_mail)->send(new TaskStatusChanged($task, true));
				}

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
	    if(Auth::user()->role_id !== Role::SUPER_ADMIN && $project->company->user_id !== Auth::user()->id) {
		    $this->accessDenied();
	    }

	    if($task &&
		    $validatedData) {
		    $task->fill($request->all());

		    if(empty($task->user_id)) {
			    $task->user_id = Auth::user()->id;
		    }


		    /*
		     * The price could be set by the super admin
		     */
		    if(Auth::user()->role_id != Role::SUPER_ADMIN) {
			    $task->price = $task->getPrice();
		    }
		    else {
			    //Convert money
			    $task_price = $task->price;
			    $price = new Money($task_price, Currency::EUR(), true);

			    $price_str = str_replace(",",".",$price->formatSimple());
			    $task->price = $price_str;
		    }



		    if($task->save()) {

		    	//Send mail to company owner
			    $owner_mail = $project->company->email;
			    if(!empty($owner_mail) && env("APP_ENV") !== "local") {
			    	Mail::to($owner_mail)->send(new TaskStatusChanged($task));
			    }


			    return redirect()->route('projects.show', ['project_id' => $task->project_id])
			                     ->with(array(
					                        'success' => 'Task created successfully',
					                        'selected_status'  => $task->status_id
			                            ));
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
