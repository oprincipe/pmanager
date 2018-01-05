<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;
use function route;

class CustomerLoginController extends Controller
{

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = "/customersarea/dash";

	public function __construct()
	{
		//$this->middleware('auth:customer')->except(['showLoginForm','logout']);
	}

	public function showLoginForm()
	{
		return view("auth.customers.login");
	}

	public function login(Request $request)
	{
		//Validate form data
		$this->validate($request, [
			'supplier_code' => 'required|string|max:200',
			'email' => 'required|string|email|max:200',
			'password' => "required|string|min:4"
		]);

		// Attempt to log the customer in
		$credentials = [
			"user_id" => $request->supplier_code,
			"email" => $request->email,
			"password" => $request->password,
		];

		if(Auth::guard("customer")->attempt($credentials, $request->remember)) {
			// if successful then redirect to their intended location
			return redirect()->intended(route("customersarea.dash"));
		}
		else {
			// if unsuccessful then redirect back with input form
			return back()->withErrors("Login failed")->withInput($request->only("email", "remember"));
		}


	}
}
