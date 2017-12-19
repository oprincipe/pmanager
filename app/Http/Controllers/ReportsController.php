<?php

namespace App\Http\Controllers;

use App\Company;
use App\TaskStatus;
use function back;
use PDF;
use function redirect;
use function view;

class ReportsController extends Controller
{
	private $data;

	public function __construct()
	{
		$this->middleware('auth');
	}


	public function company_info($company_id)
	{
		$company = Company::find($company_id);
		if(!$company) {
			return redirect("/");
		}
		$task_statuses = TaskStatus::all();
		$comments = $company->comments()->orderBy('updated_at','created_at')->get();
		$files = $company->files()->orderBy('updated_at','created_at')->get();

		$data = [
			'company' => $company,
			'task_statuses' => $task_statuses,
			'comments' => $comments,
			'files' => $files,
		];

		//return view("reports.companies.info", $data);

		$pdf = PDF::loadView('reports.companies.info', $data);
		return $pdf->stream();
	}

}
