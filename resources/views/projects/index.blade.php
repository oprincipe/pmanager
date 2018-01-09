@extends("layouts.app")

@section('content_header')
<h1>Project List</h1>
@endsection;

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">All projects
                <a class="pull-right btn btn-success btn-sm" href="{{ route("projects.create") }}">Create new project</a>
                </div>
            </div>
            <td class="panel-body">

                <table class="table table-hover">
                    <col width="5%">
                    <col width="20%">
                    <col width="55%">
                    <col width="20%">
                    <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Company</th>
                        <th>Project</th>
                        <th>Tasks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($projects as $project)
                        <tr>
                            <td>
                                <a href="{{ route("projects.show",$project->id) }}"><i class="fa fa-folder-open"></i> </a>
                            </td>
                            <td>
                                <a href="{{ route("companies.show", $project->company_id) }}">{{ $project->company->name }}</a>
                            </td>
                            <td>
                                <a href="{{ route("projects.show",$project->id) }}">{{ $project->name }}</a>
                            </td>
                            <td>
                                <table class="table table-condensed table-responsive" style="background-color: transparent;">
                                    <tbody>
                                    <tr>
                                    @foreach($task_statuses as $task_status)
                                        <td style=" border-top: none">
                                            <a href="{{ route("projects.show",["id" => $project->id, "task_status_id" => $task_status->id]) }}"
                                               title="{{ $task_status->name }}">
                                                {!! $task_status->icon() !!}
                                                <span class="badge"><?=(int) $project->tasks_count($task_status->id)?></span>
                                            </a>
                                        </td>
                                    @endforeach
                                    </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
            <div class="panel-footer">
                {{-- $projects->links() --}}
            </div>
        </div>
    </div>
    </div>
@endsection