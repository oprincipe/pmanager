@extends("layouts.app")

@section('content_header')

@endsection

@section('content')
    <div class="row">

		<?php
		$form_method = (empty($task->id)) ? route('tasks.store') : route('tasks.update', [$task->id]);
		?>

        <form action="{{ $form_method }}" method="post" role="form">
            {{ csrf_field() }}
            <input type="hidden" name="project_id" id="project_id" value="{{ $task->project_id }}" />

            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="well">
                            @if (empty($task->id))
                                Create a new task for {{ $task->project->name }}
                            @else
                                Task: {{ $task->name }}
                                    <input type="hidden" name="_method" value="put" />
                                <span class="pull-right">Owner: {{ $task->owner()->fullName() }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Task</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label for="task-name"><i class="fa fa-user"></i> Name <span
                                                    class="required">*</span></label>
                                        <input type="text" class="form-control" name="name" id="task-name"
                                               placeholder="task name"
                                               required spellcheck="false" value="{{ old("name", $task->name) }}"
                                        />
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <label for="task-status-id"><i class="fa fa-info"></i> Status <span
                                                class="required">*</span></label>
                                    <div class="form-group">
                                        <select class="form-control" name="status_id" id="task-status-id">
                                            @foreach($task_statuses as $task_status)
                                                <option value="{{ $task_status->id }}"
                                                        @if($task_status->id == $task->getStatusId())
                                                        selected="selected"
                                                        @endif
                                                >{{ $task_status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Description</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <textarea class="form-control autosize-target text-left"
                                              name="description"
                                              id="task-description"
                                              placeholder="Task description"
                                              rows="5"
                                              spellcheck="false"
                                              style="resize: vertical"
                                    >{!! old("description", $task->description) !!}</textarea>
                                    <script>
                                        CKEDITOR.replace('task-description');
                                    </script>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <br /><br /><br />
                    </div>
                </div>

            </div>

            <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Actions</h3>
                    </div>
                    <div class="panel-body">
                        <ol class="list-unstyled">
                            @if(!empty($task->id))
                                <li><a href="{{ route('tasks.show', $task->id) }}"><i class="fa fa-tasks"></i> {{ __("View task") }}</a>
                                </li>
                            @endif
                            @if ($task->project->userCanView(Auth::user()))
                            <li><a href="{{ URL::to('/projects/'.$task->project_id) }}"><i class="fa fa-briefcase"></i>
                                    {{ __("View project") }}</a>
                            </li>
                            @endif
                        </ol>
                    </div>
                </div>

                @include("partials.save-navbar")


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Task previsions</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="task-hours"><i class="fa fa-clock-o"></i> {{ __("Quoted hours") }}<span
                                        class="required">*</span></label>
                            <input type="number" class="form-control" name="hours" id="task-hours"
                                   placeholder="Quote hours to complete"
                                   required
                                   spellcheck="false" value="{{ $task->getHours() }}"
                            />
                        </div>

                        <div class="form-group">
                            <label for="task-hours-real"><i class="fa fa-clock-o"></i> {{ __("Worked hours") }} </label>
                            <input type="number" class="form-control" name="hours_real" id="task-hours-reals"
                                   placeholder="How many hours you real take to complete this task"
                                   spellcheck="false" value="{{ $task->getHoursReal() }}"
                            />
                        </div>

                        <div class="form-group">
                            <label for="task-price"><i class="fa fa-euro"></i>/<i class="fa fa-clock-o"></i> {{ __("Price per hours") }}</label>
                            <input type="text" class="form-control" name="price" id="task-price"
                                   placeholder="Price per hours"
                                   spellcheck="false" value="{{ money($task->getPrice(), "EUR") }}"
                            />
                        </div>


                    </div>
                </div>

            </div>

        </form>
    </div>
@endsection

