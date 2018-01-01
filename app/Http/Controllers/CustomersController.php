<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function back;
use function redirect;
use function route;
use function view;

class CustomersController extends Controller
{

	private $data;

	public function __construct()
	{
		$this->middleware("auth");
		$this->middleware("auth.company-owner");
	}


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	private function validator(array $data, Customer $customer)
	{
		$fields = [
			'type' => 'required|string',
			'surname' => 'max:200',
			'name' => 'required|string|max:200',
			'pid' => 'max:20',
			'email' => [
				'required',
				'string',
				'email',
				'max:200',
			]
		];

		if($data["type"] !== "private") {
			$fields['vat'] = 'required|string|max:20';
		}

		if(!empty($data["pec"])) {
			$fields['pec'] = 'string|email|max:200';
		}


		if($customer->id > 0) {
			$fields['email'] = 'unique_with:customers,user_id,'.$customer->id;
		}
		else {
			//'<field1>' => 'unique_with:<table>,<field2>[,<field3>,...,<ignore_rowid>]',
			$fields['email'] = 'unique_with:customers,user_id';
		}

		if(!empty($data["password"])) {
			/*
			 * To enable strong password setting
			 *
			 * The password contains characters from at least three of the following five categories:
			 * English uppercase characters (A – Z)
			 * English lowercase characters (a – z)
			 * Base 10 digits (0 – 9)
			 * Non-alphanumeric (For example: !, $, #, or %)
			 * Unicode characters
			 */
			//$fields["password"] = 'min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/';
			$fields["password"] = 'min:8';
		}


		return Validator::make($data, $fields);
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $this->data["customers"] = Customer::where("user_id", Auth::user()->id)->get();

	    return view("customers.index", $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view("customers.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = new Customer();

        $datas = $request->all();
        $datas["user_id"] = Auth::user()->id;
        $validator = $this->validator($datas, $customer);
        if($validator->fails()) {
        	return back()->withErrors($validator)->withInput();
        }

	    $fields = $customer->getFillable();
	    foreach($fields as $field)
	    {
		    $customer->$field = $request->post($field);
	    }

	    $customer->user_id = Auth::user()->id;
	    $customer->deleted = false;


	    //Store the customer
	    if(!$customer->saveOrFail()) {
		    return back()->withErrors("Errors while saving the customer")->withInput();
	    }

	    return redirect(route("customers.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
    	$this->data["customer"] = $customer;
	    return view("customers.edit", $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
	    $validator = $this->validator($request->all(), $customer);
	    if($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
	    }

	    $fields = $customer->getFillable();
	    foreach($fields as $field)
	    {
		    $customer->$field = $request->post($field);
	    }

	    $customer->deleted = false;
	    $customer->user_id = Auth::user()->id;


	    //Store the customer
	    if(!$customer->saveOrFail()) {
		    return back()->withErrors("Errors while saving the customer")->withInput();
	    }

	    return redirect(route("customers.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
