@extends("layouts.app")


@section('content')

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-md-offset-3 col-lg-offset-3">

        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Companies
                <a class="pull-right btn btn-success btn-sm" href="{{ route("projects.create") }}">Create new project</a>
                </div>
            </div>
            <div class="panel-body">

                <ul class="list-group">
                    @foreach($projects as $project)

                        <li class="list-group-item">
                            <a href="{{ URL::to("/projects/".$project->id) }}">
                            {{ $project->name }}
                            </a>
                        </li>

                    @endforeach
                </ul>

            </div>
            <div class="panel-footer">
                {{ $projects->links() }}
            </div>
        </div>
    </div>

@endsection