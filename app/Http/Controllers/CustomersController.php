<?php

namespace App\Http\Controllers;

use Akaunting\Money\Currency;
use Akaunting\Money\Money;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use function back;
use function redirect;
use function route;
use function str_replace;
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
			//dd($customer);
			//$fields['email'] = 'unique_with:customers,user_id,'.$customer->id." = id";

			//Validation after this method
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
			//$fields['password'] = 'required|string|min:6|confirmed';
			//$fields["password"] = 'min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/';
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

	    if(!empty($request->post("password"))) {
		    $customer->password = bcrypt($request->post('password'));
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

	    //Check unique email for this user id account
	    if(!empty($customer->id)) {
		    $c = Customer::where("user_id", Auth::user()->id)->where("email", Request::capture()->post("email"))->whereNotIn("id", [$customer->id])->first();
		    if(!empty($c)) {
			    $validator->getMessageBag()->add('email', 'This email is already used by another customer');
			    return back()->withErrors($validator)->withInput();
		    }
	    }


	    $fields = $customer->getFillable();
	    foreach($fields as $field)
	    {
	    	//Convert money
		    if($field == "base_price") {
		    	$base_price = $request->post($field);
		    	$price = new Money($base_price, Currency::EUR(), true);

		    	$price_str = str_replace(",",".",$price->formatSimple());
			    $customer->$field = $price_str;
		    }
			else {
				$customer->$field = $request->post($field);
			}

	    }

	    if(!empty($request->post("password"))) {
		    $customer->password = bcrypt($request->post('password'));
	    }

	    $customer->deleted = false;
	    $customer->user_id = Auth::user()->id;


	    //Store the customer
	    if(!$customer->saveOrFail()) {
		    return back()->withErrors("Errors while saving the customer")->withInput();
	    }

	    //Check if the user want to update tasks with zero values on prices
	    if((int) $request->post("base_price_update_ref") === 1) {
			$customer->updateTaskPricesAndValues();
	    }


	    return redirect(route("customers.index"));
    }


	/**
	 * Create the account to let the customer login on backend
	 *
	 * @param int $customer_id
	 */
    public function createAccount($customer_id, Request $request)
    {
    	//Load customer
    	$customer = Customer::find($customer_id);

    	//Load the user owner
	    $user = $customer->user;
	    //dd($user);

		//Verify if customer has already a login account with his email
    	$account = $customer->account;
		if(empty($account->id)) {
			dd($customer);
		}
		else {
			dd($account);
		}

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
