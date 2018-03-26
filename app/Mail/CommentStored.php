<?php

namespace App\Mail;

use App\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
        //Get the comment polymorphic object
	    $commentable = $this->comment->commentable;

	    $view_url = $commentable->getViewRoute();

        $title = "New comment";
	    return $this->subject($title)
	                ->from("noreply@programmatoriphp.it")
	                //->bcc("principe.sviluppo@gmail.com")
	                ->markdown("comments.mails.stored")
	                ->with([
		                       'task_title' => $title,
		                       'view_url' => $view_url
	                       ]);

    }
}
