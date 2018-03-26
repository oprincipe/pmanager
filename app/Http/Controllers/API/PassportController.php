<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PassportController extends Controller
{
    public $successStatus = 200;


    /**
     * login api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if(Auth::attempt([
            'email' => \request('email'),
            'password' => \request('password')
            ]
        ))
        {
            $user = Auth::user();
            if(false) $user = new User();
            $res['token'] = $user->createToken(env("APP_NAME"))->accessToken;
            $res['user'] = $user;

            return response()->json([
                'res' => $res,
            ],$this->successStatus);
        }
        else {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }


    }

    /**
     * Registration API
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(), 'request' => $request->json()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id']  = Role::COMPANY_OWNER;

        $user = User::create($input);
        if(false) $user = new User();
        $res['token'] =  $user->createToken(env("APP_NAME"))->accessToken;
        $res['name'] =  $user->fullName();

        return response()->json(['res'=>$res], $this->successStatus);
    }


    /**
     * User details API
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails()
    {
        $user = Auth::user();
        return response()->json([
           "res" => $user
        ], $this->successStatus);
    }



}
