@extends("layouts.basic")


@section('content')

    <div class="row">
    <div class="col-xs-12 col-sm-10  col-xs-offset-1">

        <div class="well well-sm">
            <div class="container-fluid">
                <h3>{{ $task->name }}</h3>
                <div class="pull-right">
                    <a class="btn btn-primary" href="{{ route("customersarea.dash") }}">Back</a>
                </div>
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
                        <label for="task-hours"><i class="fa fa-user"></i> Expected hours:</label>
                        {{ $task->hours }}
                    </div>
                    @if(!empty($task->days))
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <label for="task-days"><i class="fa fa-user"></i> Expected days:</label>
                            {{ $task->days }}
                        </div>
                    @endif
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                @include("customersarea.tasks.files")
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

@endsection

