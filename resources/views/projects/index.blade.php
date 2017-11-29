@extends("layouts.app")


@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">All projects
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
    </div>
@endsection