@extends("layouts.app")


@section('content')
    <div class="row">

    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">


        <!-- Example row of columns -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                $form_method = (empty($task->id)) ? route('tasks.store') : route('tasks.update', [$task->id]);
                ?>
                <form action="{{ $form_method }}" method="post" role="form">

                    {{ csrf_field() }}


                    <legend>
                        @if (empty($task->id))
                            Create a new task for {{ $task->project->name }}
                        @else
                            Task: {{ $task->name }}
                            <input type="hidden" name="_method" value="put" />
                        @endif
                    </legend>

                    <input type="hidden" name="company_id" id="company_id" value="{{ $task->company_id }}" />
                    <input type="hidden" name="project_id" id="project_id" value="{{ $task->project_id }}" />


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Task status</h3>
                            </div>
                            <div class="panel-body">
                                @if (Auth::user()->role_id == 1)
                                    <div class="form-group">
                                        <select class="form-control" name="status_id" id="task-status-id">
                                            @foreach($task_statuses as $task_status)
                                                <option value="{{ $task_status->id }}"
                                                @if($task_status->id == $task->status_id)
                                                    selected="selected"
                                                @endif
                                                >{{ $task_status->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="status_id" id="task-status-id" value="{{ (empty($task->id)) ? 1 : $task->status_id }}" />
                                    {{ empty($task->id) ? App\TaskStatus::find(1)->name : $task->status->name }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Main informations</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="task-name"><i class="fa fa-user"></i> Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="task-name" placeholder="task name"
                                           required spellcheck="false" value="{{ $task->name }}"
                                    />
                                </div>


                                <div class="form-group">
                                    <label for="task-description"><i class="fa fa-list"></i> Description</label>
                                    <textarea class="form-control autosize-target text-left"
                                              name="description"
                                              id="task-description"
                                              placeholder="Task description"
                                              rows="5"
                                              spellcheck="false"
                                              style="resize: vertical"
                                    >{!! $task->description !!}</textarea>
                                    <script>
                                        CKEDITOR.replace('task-description');
                                    </script>
                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Task previsions</h3>
                            </div>
                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="task-hours"><i class="fa fa-user"></i> Expected hours <span class="required">*</span></label>
                                    <input type="number" class="form-control" name="hours" id="task-hours"
                                           placeholder="How many hours you expect to complete this task"
                                           required
                                           spellcheck="false" value="{{ $task->hours }}"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="task-days"><i class="fa fa-user"></i> Expected days </label>
                                    <input type="number" class="form-control" name="days" id="task-days"
                                           placeholder="How many days you expect to complete this task"
                                           spellcheck="false" value="{{ $task->days }}"
                                    />
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <br /><br /><br />
                    </div>

                    <nav class="navbar navbar-default navbar-collapse navbar-fixed-bottom">
                        <div class="container">
                            <ul class="nav navbar-nav">
                                <li>
                                    <button type="submit" class="btn btn-primary navbar-btn"><i class="fa fa-floppy-o"></i> Save</button>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </form>
            </div>

        </div>
    </div>

    <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div>-->
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                @if(!empty($task->id))
                    <li><a href="{{ route('tasks.show', $task->id) }}"><i class="fa fa-tasks"></i> View task</a></li>
                @endif
                <li><a href="{{ URL::to('/companies/'.$task->company_id) }}"><i class="fa fa-building"></i> View company</a></li>
                <li><a href="{{ URL::to('/projects/'.$task->project_id) }}"><i class="fa fa-briefcase"></i> View project</a></li>
                <li><a href="{{ URL::to('/companies/') }}"><i class="fa fa-list"></i> All companies</a></li>
            </ol>
        </div>

    </div>
    </div>
@endsection

