@extends("layouts.app")

@section("content_header")
    <h1>{{ $task->name }}</h1>
@endsection

@section("add_script")

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

        $(".progress-bar").each(function() {

            var _value = $(this).attr("aria-valuenow");
            var _add_class = "";
            if(_value > 10 && _value <= 50) {
                _add_class = "progress-bar-info";
            }
            else if(_value > 50 && _value <= 99) {
                _add_class = "progress-bar-warning";
            }
            else if(_value >= 100) {
                _add_class = "progress-bar-success";
            }
            $(this).addClass(_add_class);
        });


    </script>

@endsection

@section('content')


    <div class="row">
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
				$form_method = (empty($task->id)) ? route('tasks.store') : route('tasks.update', [$task->id]);
				?>
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Workers</h3>
                                </div>
                                <div class="panel-body">

                                    @if($task->userCanAddUser(Auth::user()))
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                                            </div>
                                        </div>
                                        <br />
                                    @endif

                                    @if(!empty($task->workers->count()))
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                            <div class="panel panel-info">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title">{{ __("Task workers") }}</h3>
                                                </div>
                                                <div class="panel-body">
                                                    <table class="table table-striped table-hover">
                                                        <tr>
                                                            <th>Worker</th>
                                                            <th>Task status</th>
                                                            <th>Quoted hours</th>
                                                            <th>Worked hours</th>
                                                            <th>Price/Hrs</th>
                                                            <th>Quoted Value</th>
                                                            <th>Worked Value</th>
                                                        </tr>
                                                        @foreach($task->workers as $worker)
                                                            <?php
                                                            $del_link = "";
                                                            if(Auth::user()->id == $worker->id || $task->userCanAddUser(Auth::user())) {
                                                                $onclick = (Auth::user()->id == $worker->id) ? "confirmDeleteYourself" : "confirmDeleteUser";
                                                                $del_link = '<a href="#" onclick="'.$onclick.'('.$task->id.','.$worker->id.')"><span><i class="fa fa-trash" style="color: white"></i></span></a>';
                                                            }
                                                            ?>
                                                            <tr>
                                                                <td>
                                                                    <span class="label label-default">{!! $del_link !!} {{ $worker }}</span>
                                                                </td>
                                                                <td>
                                                                    {!! $task->getTaskUser($worker)->status->icon() !!}
                                                                </td>
                                                                <td>
                                                                    {{ $task->getTaskUser($worker)->getHours() }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->getTaskUser($worker)->getHoursReal() }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->getTaskUser($worker)->getPrice() }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->getTaskUser($worker)->getQuotedValue() }}
                                                                </td>
                                                                <td>
                                                                    {{ $task->getTaskUser($worker)->getRealValue() }}
                                                                </td>
                                                            </tr>

                                                        @endforeach
                                                    </table>
                                                </div>
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

    <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Task info</h3>
                    </div>
                    <div class="panel-body">
                        @if($task->project->userCanView(Auth::user()))
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <b><i class="fa fa-briefcase"></i> Project:</b> {!! $task->project->name !!}
                        </div>
                        @endif

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <b><i class="fa fa-info"></i> Status:</b> {!! $task->status->icon() !!} {{ $task->status->name }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <i class="fa fa-clock-o"></i> Quoted hours:
                            {{ $task->getHours() }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <i class="fa fa-clock-o"></i> Worked hours:
                            {{ $task->getHoursReal() }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <i class="fa fa-eur"></i>/<i class="fa fa-clock-o"></i> Price per hours:
                            {{ money($task->getPrice()) }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <i class="fa fa-eur"></i>/<i class="fa fa-clock-o"></i> Quoted value:
                            {{ money($task->getQuotedValue()) }}
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <i class="fa fa-eur"></i>/<i class="fa fa-clock-o"></i> Worked value:
                            {{ money($task->getRealValue()) }}
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div style="padding-top: 10px !important;">
                                <span class="left">{{ __("Completition percentage") }}</span>
                                <span class="pull-right">{{ $task->getCompletitionPercentage() }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                     style="width: {{ $task->getCompletitionPercentage() }}%;"
                                     aria-valuenow="{{ $task->getCompletitionPercentage() }}"
                                     aria-valuemin="0" aria-valuemax="100"
                                >{{ $task->getCompletitionPercentage() }}%</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Actions</h3>
            </div>
            <div class="panel-body">
                <ol class="list-unstyled">
                    <li><a href="{{ route('tasks.edit', $task->id) }}"><i class="fa fa-edit"></i> Edit task</a></li>


                    @if ($task->project->userCanView(Auth::user()))
                    <li><a href="{{ URL::to('/projects/'.$task->project_id) }}"><i class="fa fa-briefcase"></i> {{ __("View project") }}</a></li>
                    @endif

                    @if ($task->userCanDelete(Auth::user()))
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

        @if(!empty($task->workers->count()))
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ __("Status by workers") }}</h3>
                    </div>
                    <div class="panel-body">
                        @foreach($task->workers as $worker)
                            <div class="col-xs-12">
                                <div style="padding-top: 10px !important;">
                                    <span class="left">{{ $worker }}</span>
                                    <span class="pull-right">{{ $task->getTaskUser($worker)->getCompletitionPercentage() }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: {{ $task->getTaskUser($worker)->getCompletitionPercentage() }}%;"
                                         aria-valuenow="{{ $task->getTaskUser($worker)->getCompletitionPercentage() }}"
                                         aria-valuemin="0" aria-valuemax="100"
                                    >{{ $task->getTaskUser($worker)->getCompletitionPercentage() }}%</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif

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

