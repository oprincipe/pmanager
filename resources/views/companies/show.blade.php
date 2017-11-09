@extends("layouts.app")


@section('content')



    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <!-- Jumbotron -->
            <div class="jumbotron">
                <h3>{{ $company->name }}</h3>
                <p class="lead">{{ $company->address }} {{ $company->city }} {{ $company->cap }} {{ $company->prov }} {{ $company->country }}</p>
                <p class="lead">
                    <ul class="list-unstyled">
                        @if(!empty($company->website))
                            <li><a href="{{ URL::to($company->website) }}" target="_blank"><i class="fa fa-external-link"></i> {{ $company->website }}</a></li>
                        @endif
                        @if(!empty($company->contactName))<li><i class="fa fa-user"></i> {{ $company->contactName }}</li>@endif
                        @if(!empty($company->tel))<li><a href="tel:+39{{$company->tel}}"><i class="fa fa-phone"></i> {{ $company->tel }}</a></li>@endif
                        @if(!empty($company->email))<li><a href="mailto:{{ $company->email }}"><i class="fa fa-envelope"></i> {{ $company->email }}</a></li>@endif
                        @if(!empty($company->pec))<li><a href="mailto:{{ $company->pec }}"><i class="fa fa-envelope-square"></i> {{ $company->pec }}</a></li>@endif
                        @if(!empty($company->skype))<li><a href="skype:{{$company->skype}}?chat"><i class="fa fa-skype"></i> {{ $company->skype }}</a></li>@endif
                    </ul>
                </p>
                <!--<p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>-->
            </div>
        </div>

        <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
            @include("partials.comment-form")
        </div>

        @if(!empty($company->description))
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-height: 300px; overflow: auto;">
                    <pre>{{ $company->description }}</pre>
                </div>
            </div>
            <br>
        @endif

        @if (!empty($company->projects))
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Projects
                            <span class="pull-right">
                                <a style="color: white" href="{{ route('projects.create')."/".$company->id }}">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </a>
                            </span>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <td>Tasks</td>
                                    <th>Last update</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($company->projects as $project)
                                    <tr>
                                        <td class="text-nowrap">

                                            <a href="{{ route('projects.show', ['project_id' => $project->id]) }}"
                                            ><i class="fa fa-briefcase"></i>
                                            </a>

                                            <a href="{{ route('projects.edit', ['project_id' => $project->id]) }}"
                                            ><i class="fa fa-pencil"></i>
                                            </a>

                                            <a href="#"
                                               onclick="
                                                       var result = confirm('Are you sure you wish to delete this project?');
                                                       if(result) {
                                                       event.preventDefault();
                                                       $('#delete-project-{{ $project->id }}').submit();
                                                       }"><i class="fa fa-trash"></i></a>

                                            <form id="delete-project-{{ $project->id }}" action="{{ route("projects.destroy", [$project->id]) }}"
                                                  method="post" style="display: none">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="delete" />
                                            </form>

                                        </td>
                                        <td>
                                            <b>{!! $project->name !!}</b>
                                            @if(!empty($project->description))
                                                <p><i>{!! \Illuminate\Support\Str::words($project->description, 10, '...') !!}</i></p>
                                            @endif
                                        </td>
                                        <td class="text-nowrap col-xs-3">
                                            <ul class="list-group">
                                            <?php
                                                $task_statuses = App\TaskStatus::all();
                                                foreach($task_statuses as $task_status)
                                                {
                                                	if($task_status->id == App\TaskStatus::STATUS_CLOSED) continue;

                                                    $tasks_count = $project->tasks_count($task_status->id);

                                                    if($tasks_count > 0) {
                                                    ?>
                                                    <li class="list-group-item">
                                                        <span class="badge"><?=(int) $tasks_count?></span>
	                                                    <?=$task_status->icon()." ".$task_status->name?>
                                                    </li>
                                                    <?
                                                    }
                                                }
                                            ?>
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $project->updated_at->format('d/m/Y H:i:s') }}
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div>-->
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="{{ URL::to('/companies') }}"><i class="fa fa-list"></i> Back to list</a></li>
                <li><a href="{{ URL::to('/companies/'.$company->id.'/edit') }}"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                <li><a href="{{ URL::to('/projects/create/'.$company->id) }}"><i class="fa fa-plus"></i> Add project</a></li>


                <br />
                <li>
                    <a href="#"
                       onclick="
                       var result = confirm('Are you sure you wish to delete this Company?');
                       if(result) {
                           event.preventDefault();
                           $('#delete-form').submit();
                       }"><i class="fa fa-trash"></i> Delete</a>

                    <form id="delete-form" action="{{ route("companies.destroy", [$company->id]) }}"
                          method="post" style="display: none">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="delete" />
                    </form>

                </li>
            </ol>

            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                @include("partials.comments")
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




@endsection