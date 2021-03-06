<?php

namespace App\Http\Controllers;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Mail\TaskStatusChanged;
use App\Project;
use App\Role;
use App\Task;
use App\TaskDescription;
use App\TaskStatus;
use App\TaskUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function back;
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


	private function sendMails(Task $task, $task_status_text
    )
    {
        //Collect mails
        $mail_list = [];


        //Send mail to related users and owner
        $owner = $task->owner;
        if(!empty($owner->email)) {
            $mail_list[$owner->email] = $owner->email;
        }

        //Get whole project workers
        $related_users = $task->workers();
        foreach($related_users as $user)
        {
            if(!empty($user->email)) {
                $mail_list[$user->email] = $user->email;
            }
        }

        //Get task workers
        $users = $task->users;
        foreach($users as $user)
        {
            if(!empty($user->email)) {
                $mail_list[$user->email] = $user->email;
            }
        }

        //Send mail to everybody
        foreach($mail_list as $mail_addr)
        {
            Mail::to($mail_addr)->send(new TaskStatusChanged($task, $task_status_text));
        }

        return true;
    }


	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $task_statuses = TaskStatus::all();

        $tasks = $user->assigned_tasks();
        Task::processFilterCollection($tasks);
        $tasks = $tasks->paginate(10);

        $data = array(
            "tasks" => $tasks,
            'task_statuses' => $task_statuses,
        );

        return view("tasks.index", $data);
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
    		return back()->withInput()->withErrors(['Project must be selected']);
	    }

	    $project = Project::find($project_id);
	    if(false) $project = new Project();

    	if(!$project) {
		    return back()->withInput()->withErrors(['Project task not found']);
	    }

	    //Check permissions
	    if(!$project->userCanView(Auth::user())) {
	    	$this->accessDenied();
	    }

	    $task_statuses = TaskStatus::all();
	    $task = new Task();
        $task->project_id = $project->id;
        $task->user_id = Auth::id();

    	return view("tasks.form", ['task' => $task, 'task_statuses' => $task_statuses]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @todo Send mail to customers and/or task/project workers
     */
    public function store(Request $request)
    {

	    $validatedData = $request->validate(
	    	[
			    'project_id' => 'exists:projects,id',
			    'name' => 'required|max:191',
                'hours' => 'required|integer|min:1',
            ]);


	    $task = new Task();
	    if($validatedData) {

		    //Check permissions
		    $project = Project::find($request->post("project_id"));
		    if(false) $project = new Project();
		    if(!$project->userCanView(Auth::user())) {
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

		        //Store description after task updated
                $this->saveDescription($task, $request->post("description"));

                //Send mail to users
                $this->sendMails($task, __("New task created"));

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
     *
     * @todo Send mail to customers and/or task/project workers
     */
    public function update(Request $request, Task $task)
    {
	    $validatedData = $request->validate(
		    [
			    'project_id' => 'exists:projects,id',
			    'name' => 'required|max:191',
			    'hours' => 'required|integer|min:1',
		    ]);

	    $task = Task::find($task->id);

	    //Check permissions
	    if(!$task->userCanView(Auth::user())) {
		    $this->accessDenied();
	    }

	    if($task &&
		    $validatedData) {
	        if(false) $task = new Task();
		    $task->fill($request->all());

		    if(empty($task->user_id)) {
			    $task->user_id = Auth::user()->id;
		    }

		    if($task->save()) {

                //Store description after task updated
                $this->saveDescription($task, $request->post("description"));

			    if($request->post("send_email") > 0) {
				    //Send mail to users
                    $this->sendMails($task, __("Task updated"));
			    }

			    return redirect()->route('tasks.show', ['task_id' => $task->id])
			                     ->with(array(
					                        'success' => 'Task created successfully',
					                        'selected_status'  => $task->status_id
			                            ));
		    }
	    }

	    return back()->withInput()->withErrors('Errors saving task');
    }



    protected function saveDescription(Task $task, $description)
    {
        //Store description after task updated
        $taskDescription = $task->description;
        if(empty($taskDescription)) {
            $taskDescription = new TaskDescription();
        }
        $taskDescription->description = $description;
        $taskDescription->task_id = $task->id;
        $taskDescription->save();
        return true;
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //Check permissions
        if(!$task->userCanDelete(Auth::user())) {
            $this->accessDenied();
        }

        $this->sendMails($task,__("Task deleted"));
        $task->delete();

        return redirect()->route("projects.show", ['project_id' => $task->project_id])
                                ->with(array(
                                'success' => 'Task deleted successfully',
                                'selected_status'  => TaskStatus::STATUS_STAND_BY
                            ));
    }



	/**
	 * Add a user identified by mail to the project.
	 * This operation could by done by the owner of the
	 * project
	 *
	 * @param int $project
	 * @param Request $request
	 */
	public function addUser($task_id, Request $request)
	{
		$user_email = $request->post("worker_user_email");

		$task = Task::find($task_id);
		if(!$task) {
			return back()->withInput()->withErrors("Task not founds");
		}

		//Check permissions
		if(false) $task = new Project();
		if(!$task->userCanAddUser(Auth::user())) {
			return back()->withInput()->withErrors("Operation not allowed. Only the project owner can add workers");
		}

		//Load the user by mail
		$user = User::where("email", $user_email)->first();
		if(!$user || empty($user->id)) {
			return back()->withInput()->withErrors("User email $user_email not founds");
		}

		//Check if the user is the owner
		if($user->id == $task->user_id) {
			return back()->withInput()->withErrors("User email $user_email is already working on this task");
		}

		//Check if this user is already assigned
		$user_task = $task->users()->where("email", $user_email)->first();
		if(!empty($user_task->id)) {
			return back()->withInput()->withErrors("User email $user_email already assigned to this project");
		}

		//All good, insert ...
		$task_user = new TaskUser();
		$task_user->owner_id = Auth::id();
		$task_user->task_id = $task->id;
		$task_user->user_id = $user->id;
		$task_user->saveOrFail();

		return back()->with("success", "User worker added to task");
	}


	/**
	 * This function will delete a user from the list of workers
	 * of this task
	 */
	public function delUser($task_id, $user_id)
	{
		$user_id = (int) $user_id;
		$task = Task::find($task_id);
		if(!$task) {
			return back()->withInput()->withErrors("Task not founds");
		}

		//Check permissions
		if(false) $task = new Task();
		if($user_id !== Auth::user()->id && !$task->userCanDelUser(Auth::user())) {
			return back()->withInput()->withErrors("Operation not allowed. Only the task owner can delete workers or you could delete yourself");
		}

		//Load the user by mail
		$user = User::find($user_id);
		if(!$user || empty($user->id)) {
			return back()->withInput()->withErrors("User not founds");
		}

		//Check if the user is the owner
		if($user->id == $task->user_id) {
			return back()->withInput()->withErrors("The owner of the task can't be removed");
		}

		//Check if this user is already assigned
		$user_task = $task->users()->where("user_id", $user_id)->first();
		if(empty($user_task->id)) {
			return back()->withInput()->withErrors("This user is not assigned to this task");
		}

		//All good, insert ...
		$task_user = ProjectUser::where(
			[
				"task_id" => $task->id,
				"user_id" => $user->id
			])->first();
		$task_user->delete();

		if($user_id === Auth::user()->id) {
			return redirect(route("projects.index"))->with("success", "User removed from task");
		}

		return back()->with("success", "User worker removed from task");

	}


}
