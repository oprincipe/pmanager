<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use function back;
use function redirect;
use function route;
use function view;

class UsersController extends Controller
{

	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('auth.superadmin');
	}



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    $data = array();
    	if(Auth::user()->role_id == Role::SUPER_ADMIN) {
		    $users = User::where('role_id', '>' , Role::SUPER_ADMIN)
		        ->orderBy('first_name','last_name')
			    ->take(10)
			    ->get();
	    }

	    $data["users"] = $users;

	    return view("users.index", $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $roles = Role::all();
	    $data["user"]  = new User();
	    $data["roles"] = $roles;

	    return view("users.create", $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $validator = $this->validator($request->all(), new User());
	    if($validator->fails()) {
		    return back()->withErrors($validator)->withInput();
	    }

	    $user = new User($request->all());
	    if(!empty($request->post("password"))) {
		    $user->password = bcrypt($request->post('password'));
	    }

	    if(!$user->saveOrFail()) {
		    return back()->withErrors("Errors while creating user")->withInput();
	    }
	    else {
		    return redirect(route("users.index"))->with(["success" => "User ".$user->fullName()." created"]);
	    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
	    $roles = Role::all();

	    $data["user"]  = $user;
	    $data["roles"] = $roles;

	    return view("users.edit", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return $this->show($user);
    }


	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	private function validator(array $data, User $user)
	{
		$fields = [
			'role_id' => 'required|int',
			'first_name' => 'required|string|max:255',
			'email' => [
				'required',
				'string',
				'email',
				'max:255',
			],
		];

		if($user->id > 0) {
			$fields[] = Rule::unique('users')->ignore($user->id);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
		$u = User::find($user->id);

        $validator = $this->validator($request->all(), $user);
        if($validator->fails()) {
        	return back()->withErrors($validator)->withInput();
        }

	    $fields = ["first_name", "middle_name", "last_name", "email", "city", "role_id"];
        foreach($fields as $field)
        {
        	$u->$field = $request->post($field);
        }

        if(!empty($request->post("password"))) {
        	$u->password = bcrypt($request->post('password'));
        }

        if(!$u->saveOrFail()) {
        	return back()->withErrors("Errors while updating user")->withInput();
        }
        else {
        	return back()->with(["success" => "User ".$u->fullName()." updated"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
	    return back()->withErrors("User can't be deleted");
    }
}
