<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Mail\CommentStored;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use function explode;
use function last;
use function redirect;
use function str_plural;
use function strtolower;

class CommentsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * A new mail will be send to owner and relate users
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

	    $comment = Comment::create([
                       'body'               => $request->input("body"),
                       "url"                => $request->input("url"),
                       "commentable_type"   => $request->input("commentable_type"),
                       "commentable_id"     => $request->input("commentable_id"),
                       "user_id" => Auth::user()->id
                   ]);

	    if($comment) {

            //Collect mails
            $mail_list = [];

            $mail_sent = " - mail sent to related users";

            //Send mail
		    if(false) $comment = new Comment();
		    $commentable = $comment->commentable;

		    //Send mail to the owner
            $owner = $commentable->owner;
		    if(!empty($owner->email)) {
                $mail_list[$owner->email] = $owner->email;
            }

            //Send mail to inherit users
            $users = $commentable->getUsersFromParentObjects();
            foreach($users as $user)
            {
                if(!empty($user->email)) {
                    $mail_list[$user->email] = $user->email;
                }
            }

            //Send mail to direct users
            $users = $commentable->users;
            foreach($users as $user)
            {
                if(!empty($user->email)) {
                    $mail_list[$user->email] = $user->email;
                }
            }

            //Send mail to everybody
            foreach($mail_list as $mail_addr)
            {
                Mail::to($mail_addr)->send(new CommentStored($comment));
            }


            return back()->with("success", "Comment added successfully".$mail_sent);
	    }

        return back()->withInput()->with("error", "Errors while creating comment");

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
    	$comment = Comment::find($comment->id);
        $ObjectRedirectToStr = $comment->commentable_type;
		$els = explode("\\", $ObjectRedirectToStr);
	    $commentable_obj = $comment->commentable;
	    $ObjectRedirectTo = str_plural(strtolower(last($els)));

        $comment->delete();
	    return redirect()->route($ObjectRedirectTo.'.show', [$ObjectRedirectTo => $commentable_obj->id])
	                     ->with("success", "Comment deleted successfully");

    }
}
