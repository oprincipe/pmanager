@extends("layouts.app")


@section('content')

    <script>
        function confirmDeleteUser(_task_id, _user_id)
        {
            if(!confirm("Are you sure to remove this user from the task?")) return;
            location.href = "/tasks/del_user/" + _task_id + "/" + _user_id;
        }

        function confirmDeleteYourself(_task_id, _user_id)
        {
            if(!confirm("Are you sure to remove yourself from this task?")) return;
            location.href = "/tasks/del_user/" + _task_id + "/" + _user_id;
        }
    </script>


    <div class="row">
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">


        <!-- Example row of columns -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
				$form_method = (empty($task->id)) ? route('tasks.store') : route('tasks.update', [$task->id]);
				?>

                    <div class="well well-sm">
                        <div class="container-fluid">
                            <h3>{{ $task->name }}</h3>
                        </div>
                    </div>


                    <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Task info</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <b><i class="fa fa-briefcase"></i> Project:</b> {!! $task->project->name !!}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <b><i class="fa fa-info"></i> Status:</b> {!! $task->status->icon() !!} {{ $task->status->name }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="task-hours"><i class="fa fa-clock-o"></i> Quoted hours:</label>
                                    {{ $task->hours }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="task-hours-real"><i class="fa fa-clock-o"></i> Real hours:</label>
                                    {{ $task->hours_real }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="task-value"><i class="fa fa-eur"></i>/<i class="fa fa-clock-o"></i> Quoted value:</label>
                                    {{ money($task->getQuotedValue()) }}
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="task-value"><i class="fa fa-eur"></i>/<i class="fa fa-clock-o"></i> Worked value:</label>
                                    {{ money($task->getRealValue()) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Workers</h3>
                                </div>
                                <div class="panel-body">

                                    @if($task->userCanAddUser(Auth::user()))
                                        <form action="{{ route("tasks.add_user", ["task_id" => $task->id]) }}"
                                              method="post" class="form-inline" role="form">
                                            {{ csrf_field() }}
                                            <div class="input-group col-xs-8">
                                                <input type="email" class="form-control"
                                                       name="worker_user_email" id="worker_user_email"
                                                       placeholder="Add new worker by mail" aria-describedby="basic-addon1"
                                                       value="{{ old("worker_user_email") }}"
                                                >
                                            </div>
                                            <div class="input-group col-xs-3">
                                                <button type="submit" class="btn btn-primary">Confirm</button>
                                            </div>
                                        </form>
                                    @endif

                                    <div class="col-lg-12 tagcloud">
                                        <br />
                                        @foreach($task->users as $worker)
											<?php
											$del_link = "";
											if(Auth::user()->id == $worker->id || $task->userCanAddUser(Auth::user())) {
												$onclick = (Auth::user()->id == $worker->id) ? "confirmDeleteYourself" : "confirmDeleteUser";
												$del_link = '<a href="#" onclick="'.$onclick.'('.$task->id.','.$worker->id.')"><span><i class="fa fa-trash" style="color: white"></i></span></a>';
											}
											?>
                                            <span class="label label-default">{!! $del_link !!} {{ $worker }}</span>
                                        @endforeach
                                    </div>

                                    @if(!empty($task->getUsersFromParentObjects()))
                                        <br />
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">{{ __("Global workers") }}</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="col-lg-12 tagcloud">
                                                    @foreach($task->getUsersFromParentObjects() as $worker)
                                                        <span class="label label-default">{{ $worker }}</span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                            @include("partials.file-form")
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-left">
                            @include("partials.files")
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Main informations</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="container-fluid">
                                    {!! $task->description !!}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
            </div>

        </div>
    </div>

    <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Actions</h3>
            </div>
            <div class="panel-body">
                <ol class="list-unstyled">
                    <li><a href="{{ route('tasks.edit', $task->id) }}"><i class="fa fa-edit"></i> Edit task</a></li>
                    <li><a href="{{ URL::to('/projects/'.$task->project_id) }}"><i class="fa fa-briefcase"></i> View project</a></li>

                    @if (Auth::user()->role_id == 1)
                        <br />
                        <a href="#"
                           onclick="
                                   var result = confirm('Are you sure you wish to delete this task?');
                                   if(result) {
                                   event.preventDefault();
                                   $('#delete-task-{{ $task->id }}').submit();
                                   }"><i class="fa fa-trash"></i> Delete task</a>

                        <form id="delete-task-{{ $task->id }}" action="{{ route("tasks.destroy", [$task->id]) }}"
                              method="post" style="display: none">
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="delete" />
                        </form>
                    @endif

                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @include("partials.comment-form")
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @include("partials.comments")
            </div>
        </div>

    </div>
    </div>
@endsection

