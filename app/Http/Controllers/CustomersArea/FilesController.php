<?php

namespace App\Http\Controllers\CustomersArea;

use App\File;
use App\Http\Controllers\Controller;
use App\Project;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
	public function __construct()
	{
		$this->middleware("auth:customer");
	}


	private function accessDenied($msg = "")
	{
		if(empty($msg)) {
			$msg = "Access denied";
		}
		return redirect()->route('customersarea.dash')->withErrors($msg);
	}


	private function checkPermissions(File $file)
	{
		if(empty($file) || empty($file->id)) {
			return $this->accessDenied("File not founds");
		}

		//Verify the customer owner
		$object = $file->uploadable;
		if($object instanceof Project) {
			$project = $object;
		}
		else if($object instanceof Task) {
			$project = $object->project;
		}
		else {
			return $this->accessDenied();
		}

		$customer = $project->customers()->where("customer_id", Auth::user()->id)->first();
		if(empty($customer->id)) {
			return $this->accessDenied();
		}

		return true;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\File $file
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show($file_id)
	{
		$file = File::find($file_id);

		//Check file permissions
		$this->checkPermissions($file);

		//Record file trovato, verifico il file fisico
		$exists = Storage::disk('local')->exists($file->filepath);
		if(!$exists) {
			return back()->withInput()->withErrors("File ".$file->filename." doesn't exists");
		}

		$headers = array(
			'Content-Type: '.$file->type,
			'Content-Lenght: '.$file->size
		);

		return response()->download($file->getRealPath(), $file->filename, $headers);
	}
}
