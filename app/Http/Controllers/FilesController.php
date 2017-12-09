<?php

namespace App\Http\Controllers;

use App\Company;
use App\File;
use function back;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use function response;
use function str_replace;

class FilesController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
	}

	private function checkPermissions(File $file)
	{
		if(empty($file) || empty($file->id)) {
			return back()->withInput()->withErrors("File not founds");
		}

		if(Auth::user()->id == $file->user_id) {
			return true;
		}

		//Verifico permessi. Solo admin e proprietario della compagnia
		$uploadable = $file->uploadable;
		if($uploadable instanceof Company) {
			$company      = $uploadable;
		}
		else {
			$company      = $uploadable->company;
		}
		$company_user = $company->user;



		if(Auth::user()->role_id != 1 && Auth::user()->id != $company_user->id) {
			return back()->withInput()->withErrors("Permission denied");
		}

		return true;
	}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $uploaded_file = $request->file('filename');
		$userid = Auth::user()->id;

	    $filepath = $uploaded_file->store($request->input("uploadable_type"));
	    if($filepath) {
		    try {

		    	$file = File::create([
				                         "filename"           => $uploaded_file->getClientOriginalName(),
				                         "ext"                => $uploaded_file->extension(),
				                         "type"               => $uploaded_file->getMimeType(),
				                         "size"               => $uploaded_file->getSize(),
				                         "filepath"           => $filepath,
				                         "uploadable_type"    => $request->input("uploadable_type"),
				                         "uploadable_id"      => $request->input("uploadable_id"),
				                         "user_id"            => $userid
			                         ]);
			    return back()->with("success", "File uploaded successfully");

		    }
		    catch (Exception $e) {
			    //Errori nel trasferimento, rimozione del file
			    Storage::delete($filepath);
			    return back()->withInput()->with("error", "Errors while uploading file");
		    }


	    }


	    return back()->withInput()->with("error", "Errors while uploading file");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\File $file
     *
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\File  $file
     *
     * @return \Illuminate\Http\Response
     */
	public function destroy(File $file)
    {
	    //Check file permissions
	    $this->checkPermissions($file);

	    if($file->delete()) {
		    return back()->withInput()->withErrors("Errors while deleting file ".$file->filename);
	    }

	    return back()->with("success", "File ".$file->filename." deleted successfully");
    }
}
