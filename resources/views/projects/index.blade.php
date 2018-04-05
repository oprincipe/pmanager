@extends("layouts.app")

@section('content_header')
<h1>Project List</h1>
@endsection

@section('css')
    <link href="{{ asset('css/sticky_notes.css') }}" type="text/css" rel="stylesheet">
    <link  href="http://fonts.googleapis.com/css?family=Reenie+Beanie:regular" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/common.css') }}" type="text/css" rel="stylesheet">
@endsection

@section('content')


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">All projects
                    <a class="pull-right btn btn-success btn-sm" href="{{ route("projects.create") }}">Create new project</a>
                    </div>
                </div>


                <p class="panel-body">
                    <ul class="sticky">
                        @foreach($projects as $project)
                            <li>
                                <a href="{{ route("projects.show",$project->id) }}">
                                    <h2>{{ $project->name }}</h2>
                                    <p>
                                        {{ money($project->getValue()) }}
                                    </p>
                                    <p>
                                        Customers:
                                        <br>
                                        @foreach($project->customers as $customer)
                                            <span>{{ $customer }}</span>
                                        @endforeach
                                    </p>
                                    <p>
                                        <div class="sticky-footer tagcloud">
                                            @foreach($task_statuses as $task_status)
                                                <span class="badge">{{ $task_status->name }} <?=(int) $project->tasks_count($task_status->id)?></span>
                                            @endforeach
                                        </div>
                                    </p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                    {{  $projects->links() }}
                </div>


            </div>
        </div>
    </div>




@endsection


