<?php

namespace App\Http\Controllers;

use App\CustomerProject;
use Illuminate\Http\Request;

class CustomerProjectController extends Controller
{
	private $data;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cp = new CustomerProject();
        $cp->project_id = (int) $request->post("project_id");
        $cp->customer_id = (int) $request->post("customer_id");
	    if(!$cp->saveOrFail()) {
		    return back()->withErrors("Errors while adding customer to project")->withInput();
	    }

	    return redirect(route("projects.show", ['project_id' => $cp->project_id]));
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$cp = CustomerProject::find($id);
		if(false) $cp = new CustomerProject();
		if(!$cp->delete()) {
			return back()->withErrors("Errors while removing customer to project")->withInput();
		}

		return redirect(route("projects.show", ['project_id' => $cp->project_id]));
	}


	/**
	 * Unlink the customer from the project
	 *
	 * @param  int  $customer_id
	 * @param  int  $project_id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function unlink($customer_id, $project_id)
	{
		$cp = CustomerProject::where("customer_id", $customer_id)
							 ->where("project_id", $project_id)
						 	 ->first();

		if(!$cp) {
			return back()->withErrors("Errors while searching customer for the project")->withInput();
		}

		if(false) $cp = new CustomerProject();
		if(!$cp->delete()) {
			return back()->withErrors("Errors while removing customer to project")->withInput();
		}

		return redirect(route("projects.show", ['project_id' => $cp->project_id]));
	}


}
