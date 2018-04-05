<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{

    public $successStatus = 200;

	public function __construct()
	{
		$this->middleware('auth');
	}


    /**
     * This method load a class from App namespace and try to call comments method to
     * get all comments referred to the loaded object
     *
     * @param $commentable_type
     * @param $commentable_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($commentable_type, $commentable_id)
    {
        $commentable_type = "App\\".$commentable_type;
        $object = $commentable_type::find($commentable_id);

        if(empty($object) || !$object->userCanView(Auth::user())) {
            return response()->json([
                "res" => [
                    "error" => "Unauthorized action"
                ]
            ], 404);
        }

        //Get comments
        $comments = $object->comments()->orderBy('updated_at','created_at')->get();

        //Set user and display name for each comments
        foreach($comments as &$comment)
        {
            $comment->user_display_name = $comment->user->fullName();
        }


        $data = array(
            "comments" => $comments,
        );

        return response()->json([
            "res" => $data
        ], $this->successStatus);

    }
}
