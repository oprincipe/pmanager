@extends("layouts.app")

@section('content_header')
    <h1>Tasks List</h1>
@endsection

@section('content')

    <div class="row">
        @include("tasks.search")
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">All tasks
                        <a class="pull-right btn btn-success btn-sm" href="{{ route("projects.index") }}">
                            <i class="fa fa-briefcase"></i> View projects
                        </a>
                    </div>
                </div>
                <div class="panel-body">

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Quoted hours</th>
                            <th>Real hours</th>
                            <th>Price/hr</th>
                            <th>Quoted Value</th>
                            <th>Real Value</th>
                            <th>Last update</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="text-nowrap">

                                    <a href="{{ route('tasks.show', ['task_id' => $task->id]) }}"
                                    ><i class="fa fa-tasks"></i>
                                    </a>

                                    <a href="{{ route('tasks.edit', ['task_id' => $task->id]) }}"
                                    ><i class="fa fa-pencil"></i>
                                    </a>

                                    @if ($task->userCanDelUser(Auth::user()))
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
                                    <label title="{{ $task->status->name }}">{!! $task->status->icon() !!}</label>
                                </td>
                                <td style="white-space: normal">
                                    {{ $task->name }}
                                    <br />
                                    <em>{{ __("Project") }} {{ $task->project->name }}</em>
                                </td>
                                <td>
                                    {{ $task->hours }}
                                </td>
                                <td>
                                    {{ 1*$task->hours_real }}
                                </td>
                                <td class="text-nowrap">
                                    {{ money($task->getPrice()) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ money($task->getQuotedValue()) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ money($task->getRealValue()) }}
                                </td>
                                <td>
                                    {{ $task->updated_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

            </div>
            <div class="panel-footer">
                <?php
                try {
                    $tasks->links();
                }
                catch (Exception $e) {}
                ?>
            </div>
        </div>
    </div>
    </div>
@endsection