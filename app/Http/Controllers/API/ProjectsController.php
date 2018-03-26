<?php

namespace App\Http\Controllers\API;

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
		$projects = $user->assigned_projects()->paginate(10);

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
