<?php

namespace App\Mail;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TaskStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

	/**
	 * @var Task
	 */
	public $task;

	/**
	 * @var bool Task is new o updated
	 */
	public $new;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Task $task, $new = false)
	{
		$this->task = $task;
		$this->new = $new;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$view_url = route('tasks.show', ['task_id' => $this->task->id]);

		$title = $this->new ? "New task created" : "Task updated";
		return $this->subject($title)
					->from("principe.sviluppo@gmail.com")
					->bcc("principe.sviluppo@gmail.com")
		            ->markdown("tasks.mails.status")
			        ->with([
			        	'task_title' => $title,
						'view_url' => $view_url
			        ]);
	}
}
