<?php

namespace App\Mail;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
	public $task_status_text;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(Task $task, $task_status_text = "")
	{
		$this->task = $task;
		$this->task_status_text = (empty($task_status_text)) ? __("task") : $task_status_text;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{

		$view_url = route('tasks.show', ['task_id' => $this->task->id]);

		$title = $this->task_status_text;
		return $this->subject($title)
					->from("noreply@programmatoriphp.it")
					//->bcc("principe.sviluppo@gmail.com")
		            ->markdown("tasks.mails.status")
			        ->with([
			        	'task_title' => $title,
						'view_url' => $view_url
			        ]);
	}
}
