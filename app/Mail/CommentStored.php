<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentStored extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Comment
	 */
    public $comment;

    /**
     * Create a new message instance.
     *
     * @param Comment $comment
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //return $this->markdown('comments.mails.stored');

        //Get the comment polymorphic object
	    $commentable = $this->comment->commentable;

	    $view_url = $commentable->getViewRoute();

        $title = "New comment";
	    return $this->subject($title)
	                ->from("orazio.principe@programmatoriphp.it")
	                ->bcc("principe.sviluppo@gmail.com")
	                ->markdown("comments.mails.stored")
	                ->with([
		                       'task_title' => $title,
		                       'view_url' => $view_url
	                       ]);

    }
}
