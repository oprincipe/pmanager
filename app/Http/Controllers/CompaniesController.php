<?php

namespace App\Http\Controllers;

use App\Company;
use App\Role;
use App\User;
use function compact;
use function dd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function view;

class CompaniesController extends Controller
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
    	if(Auth::user()->role_id == 1) {
		    $companies = Company::all();
	    }
    	else {
    		$companies = Company::where("user_id", Auth::user()->id)->get();
	    }

        return view("companies.index", array("companies" => $companies));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	if(Auth::user()->role_id != 1) {
    		return $this->accessDenied();
        }

    	$company = new Company();
    	return view("companies.form", ["company" => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$user_id = $request->input("user_id");
    	if(empty($user_id)) {
    		$user_id = Auth::user()->id;
	    }

        $company = Company::create([
        	'name' => $request->input("name"),
	        "description" => $request->input("description"),
	        "user_id" => $user_id,
	        'address' => ''.$request->input("address"),
	        'cap' => ''.$request->input("cap"),
	        'city' => ''.$request->input("city"),
	        'prov' => ''.$request->input("prov"),
	        'country' => ''.$request->input("country"),
	        'tel' => ''.$request->input("tel"),
	        'fax' => ''.$request->input("fax"),
	        'email' => ''.$request->input("email"),
	        'pec' => ''.$request->input("pec"),
	        'skype' => ''.$request->input("skype"),
	        'website' => ''.$request->input("website"),
	        'contactName' => ''.$request->input("contactName"),
	        'vatCode' => ''.$request->input("vatCode"),
	        'cfCode' => ''.$request->input("cfCode"),
        ]);

        if($company) {
        	return redirect()->route('companies.show', ['company' => $company->id])
		        ->with("success", "Company created successfully");
        }
        else {
        	return back()->withInput()->with("error", "Errors while creating company");
        }
    }

    /**
     * Display the company if the user is the owner or is the administrator
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
	    $company = $company->find($company->id);

	    if(Auth::user()->role_id != 1 && $company->user_id !== Auth::user()->id) {
		    return $this->accessDenied();
	    }

	    $data = array(
		    'company' => $company,
		    'comments' => $company->comments,
		    'commentable_type' => "App\Company",
		    'commentable_id' => $company->id
	    );

        return view("companies.show", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {

	    $data = [
	    	'users'   => User::all(),
	    	'company' => $company
	    ];

        return view("companies.form", $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
	    $user_id = $request->input("user_id");
	    if(empty($user_id)) {
		    $user_id = $company->user_id;
	    }

    	//Save data
        $companyUpdate = Company::find($company->id)
								        ->update([
								            'user_id' => $user_id,
								        	'name' => $request->input("name"),
									        'description' => $request->input("description"),
								            'cap' => ''.$request->input("cap"),
								            'address' => ''.$request->input("address"),
								            'city' => ''.$request->input("city"),
								            'prov' => ''.$request->input("prov"),
								            'country' => ''.$request->input("country"),
								            'tel' => ''.$request->input("tel"),
								            'fax' => ''.$request->input("fax"),
								            'email' => ''.$request->input("email"),
								            'pec' => ''.$request->input("pec"),
								            'skype' => ''.$request->input("skype"),
								            'website' => ''.$request->input("website"),
								            'contactName' => ''.$request->input("contactName"),
								            'vatCode' => ''.$request->input("vatCode"),
								            'cfCode' => ''.$request->input("cfCode"),
								                 ]);

        //Redirect
	    if($companyUpdate) {
	    	return redirect()->route('companies.show', ['company' => $company->id])
		                     ->with('success', 'Company updated successfully');
	    }
	    else {
		    return back()->withInput();
	    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $findCompany = Company::find($company->id);
        if($findCompany->delete()) {
        	return redirect()->route('companies.index')
		        ->with('success', 'Company deleted successfully');
        }

        return back()->withInput()->with('error', 'Company could not be deleted');
    }
}
