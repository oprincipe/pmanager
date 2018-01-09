<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">
			Tasks
			<span class="pull-right">
                                <a style="color: white" href="{{ route('tasks.create')."/".$project->id }}">
                                    <i class="glyphicon glyphicon-plus"></i>
				</a>
                            </span>
		</h3>
		<span class="pull-right">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                @foreach($task_statuses as $task_status)
                                    <li class="@if($task_status->id == $active_status) {{ "active" }} @endif">
                                        <a href="#tab{{ $task_status->id }}" data-toggle="tab">
                                            {!! $task_status->icon() !!}  {{ $task_status->name }}
                                            <span class="badge"><?=(int) $project->tasks_count($task_status->id)?></span>
                                        </a>
	                            </li>
                                @endforeach
                            </ul>
                        </span>
	</div>
	<div class="panel-body">
		<div class="tab-content">

			@foreach($task_statuses as $task_status)
			<div class="tab-pane @if($task_status->id == $active_status) {{ "active" }} @endif" id="tab{{ $task_status->id }}">

			<div class="table table-responsive">
				<table class="table table-striped">
					<thead>
					<tr>
						<th>#</th>
						<th>Status</th>
						<th>Name</th>
						<th>Hours</th>
						<th>Creation</th>
						<th>Last update</th>
					</tr>
					</thead>
					<tbody>
					@foreach($project->tasks($task_status->id) as $task)
					<tr>
						<td>
							<label title="{{ $task->status->name }}">{!! $task->status->icon() !!}</label>
						</td>
						<td class="text-nowrap">

							<a href="{{ route('tasks.show', ['task_id' => $task->id]) }}"
							><i class="fa fa-tasks"></i>
							</a>

							<a href="{{ route('tasks.edit', ['task_id' => $task->id]) }}"
							><i class="fa fa-pencil"></i>
							</a>

							@if (Auth::user()->role_id == 1)
							<a href="#"
							   onclick="
                                                                   var result = confirm('Are you sure you wish to delete this task?');
                                                                   if(result) {
                                                                   event.preventDefault();
                                                                   $('#delete-task-{{ $task->id }}').submit();
                                                                   }"><i class="fa fa-trash"></i></a>

							<form id="delete-task-{{ $task->id }}" action="{{ route("tasks.destroy", [$task->id]) }}"
							method="post" style="display: none">
							{{ csrf_field() }}
							<input type="hidden" name="_method" value="delete" />
							</form>
							@endif

						</td>
						<td>
							<b>{!! $task->name !!}</b>
							@if(!empty($task->description))
							<p><i>{!! \Illuminate\Support\Str::words($task->description, 10, '...') !!}</i></p>
							@endif
						</td>
						<td>
							{{ $task->hours }}
							@if(!empty($task->days))
							({{ $task->days }} days)
							@endif
						</td>
						<td>
							{{ $task->created_at->format('d/m/Y H:i:s') }}
						</td>
						<td>
							{{ $task->updated_at->format('d/m/Y H:i:s') }}
						</td>
					</tr>
					</tbody>
					@endforeach
				</table>
			</div>

		</div>
		@endforeach
	</div>
</div>
</div>