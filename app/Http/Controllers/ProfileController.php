<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Validator;
use function back;
use function redirect;
use function route;
use function view;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        redirect(route("profile.show"));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data["user"]  = Auth::user();
        $projects_count = Auth::user()->assigned_projects()->count();

        $data["projects_count"] = $projects_count;
        return view("profile.index", $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data["user"]  = Auth::user();
        $data["projects_count"] = Auth::user()->assigned_projects()->count();
        return view("profile.edit", $data);
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
            $fields["password"] = 'min:8|regex:/^.*(?=.{3,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%@]).*$/';
            //$fields["password"] = 'min:8';
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
    public function update(Request $request)
    {
        $u = Auth::user();

        $validator = $this->validator($request->all(), $u);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $fields = ["first_name", "middle_name", "last_name", "email", "city"];
        foreach($fields as $field)
        {
            $u->$field = $request->post($field);
        }

        if(!empty($request->post("password"))) {
            $u->password = bcrypt($request->post('password'));
        }

        //Check for avatar
        $image = $request->file("profile-file");
        if(!empty($image)) {
            $destination_path = "avatars";
            $destination_filename = md5($u->id).".jpeg";

            //Delete previous image if exists
            if(Storage::exists($destination_filename.$destination_filename)) {
                Storage::delete($destination_filename.$destination_filename);
            }

            $image->storeAs($destination_path, $destination_filename);

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
        return back()->withErrors("Your profile can't be deleted yet. This utility will be available as soon as possible");
    }
}
