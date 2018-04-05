<?php

namespace App\Http\Controllers\API;

use App\Customer;
use App\CustomerProject;
use App\Http\Controllers\Controller;
use App\Project;
use App\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class ProjectsController extends Controller
{
    public $successStatus = 200;
	private $data;
	private $project;

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
	    $user = Auth::user();
		$projects = $user->assigned_projects()->paginate(100);

		$task_statuses = TaskStatus::all();

		$data = array(
			"projects" => $projects,
			'task_statuses' => $task_statuses,
		);

        return response()->json([
            "res" => $data
        ], $this->successStatus);

	}


    /**
     * Display the specified resource.
     *
     * @param  \App\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function show($project_id)
    {
        $project = Project::find($project_id);

        if(empty($project) || !$project->userCanView(Auth::user())) {
            return response()->json([
                "res" => [
                    "error" => "Unauthorized action"
                ]
            ], 404);
        }


        if($project->id > 0 && ($project->hours <= 0 || $project->value <= 0)) {
            $project->updateHoursAndValue();
        }
        $this->project = $project;


        $task_statuses = TaskStatus::all()->sortBy("position");
        $comments = $project->comments()->orderBy('updated_at','created_at')->get();
        $files    = $project->files()->orderBy('updated_at','created_at')->get();
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
            'workers' => $project->users,
            'comments' => $comments,
            'files'     => $files,
            //'task_statuses' => $task_statuses,
            'tasks_resume' => $tasks_resume,
            'commentable_type' => "App\Project",
            'commentable_id' => $project->id,
            'uploadable_type' => "App\Project",
            'uploadable_id' => $project->id,
            'customers' => $customers,
            'customers_project' => $customers_project
        );

        return response()->json([
            "res" => $this->data
        ], $this->successStatus);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $Project)
    {

    }

}
