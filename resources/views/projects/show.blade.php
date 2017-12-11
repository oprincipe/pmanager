@extends("layouts.app")


@section('content')
    <div class="row">

    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 pull-left">

        <!-- Jumbotron -->
        <div class="well well-lg">
            <h1>{{ $project->name }}</h1>
            <!--<p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>-->
        </div>

        <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Project info</h3>
                </div>
                <div class="panel-body" style="height: 240px; overflow: auto">
                    <p class="small">{!! nl2br($project->description) !!}</p>
                </div>
            </div>

        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                @include("partials.comment-form")
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
            </div>
        </div>

    </div>

    <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div>-->
        <div class="sidebar-module">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">
                    <ol class="list-unstyled">
                        <li><a href="{{ URL::to('/projects/'.$project->id.'/edit') }}"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a href="{{ URL::to('/projects/create') }}"><i class="fa fa-plus"></i> Add project</a></li>
                        <li><a href="{{ URL::to('/companies/'.$project->company_id) }}"><i class="fa fa-list"></i> Projects list</a></li>

                        <br />
                        <li><a href="{{ route('tasks.create')."/".$project->id }}"><i class="fa fa-tasks"></i> New task</a></li>

                        <br />

                        @if (Auth::user()->role_id == 1)
                            <li>
                                <a href="#"
                                   onclick="
                                   var result = confirm('Are you sure you wish to delete this Project?');
                                   if(result) {
                                       event.preventDefault();
                                       $('#delete-form').submit();
                                   }"><i class="fa fa-trash"></i> Delete</a>

                                <form id="delete-form" action="{{ route("projects.destroy", [$project->id]) }}"
                                      method="post" style="display: none">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="_method" value="delete" />
                                </form>

                            </li>
                        @endif
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    @include("partials.comments")
                </div>
            </div>

        </div>

        <!--
        <div class="sidebar-module">
            <h4>Members</h4>
            <ol class="list-unstyled">
                    <li><a href="#">member 1</a></li>

            </ol>
        </div>
        -->

    </div>
    </div>
@endsection