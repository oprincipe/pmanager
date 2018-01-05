<?php

namespace App\Http\Controllers\CustomersArea;

use App\Http\Controllers\Controller;
use App\TaskStatus;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

	private $data;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware("auth:customer");
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$projects = Auth::user()->projects;

		$active_status = TaskStatus::STATUS_STAND_BY;
		$session_status = \session("selected_status");
		if(!empty($session_status)) {
			$active_status = $session_status;
		}
		else if(!empty(request()->get("task_status_id"))) {
			$active_status = (int) request()->get("task_status_id");
		}

		$this->data["task_statuses"] = TaskStatus::all();
		$this->data["active_status"] = $active_status;
		$this->data["projects"] = $projects;


		return view('customersarea.home', $this->data);
	}
}
