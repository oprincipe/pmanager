@extends("layouts.app")

@section('content_header')
    <h1>Tasks List</h1>
@endsection


@section("add_script")

    <script>

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
        @include("tasks.search")
    </div>


    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">All tasks
                        <a class="pull-right btn btn-success btn-sm" href="{{ route("projects.index") }}">
                            <i class="fa fa-briefcase"></i> View projects
                        </a>
                    </div>
                </div>
                <td class="panel-body">

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Status</th>
                            <th>Name</th>
                            <th>Quoted hours</th>
                            <th>Real hours</th>
                            <th>Price/hr</th>
                            <th>Quoted Value</th>
                            <th>Real Value</th>
                            <th>Last update</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tasks as $task)
                            <tr>
                                <td class="text-nowrap">

                                    <a href="{{ route('tasks.show', ['task_id' => $task->id]) }}"
                                    ><i class="fa fa-tasks"></i>
                                    </a>

                                    <a href="{{ route('tasks.edit', ['task_id' => $task->id]) }}"
                                    ><i class="fa fa-pencil"></i>
                                    </a>

                                    @if ($task->userCanDelUser(Auth::user()))
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
                                    <label title="{{ $task->status->name }}">{!! $task->status->icon() !!}</label>
                                </td>
                                <td style="white-space: normal">
                                    <b>{{ $task->name }}</b>
                                </td>
                                <td>
                                    {{ $task->hours }}
                                </td>
                                <td>
                                    {{ 1*$task->hours_real }}
                                </td>
                                <td class="text-nowrap">
                                    {{ money($task->getPrice()) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ money($task->getQuotedValue()) }}
                                </td>
                                <td class="text-nowrap">
                                    {{ money($task->getRealValue()) }}
                                </td>
                                <td>
                                    {{ $task->updated_at->format('d/m/Y H:i:s') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td>
                                    @if($task->project->userCanView(Auth::user()))
                                    <em>{{ __("Project") }}: {{ $task->project->name }}</em>
                                    @endif

                                    @if(!$task->isOwner(Auth::id()))
                                        <span class="pull-left"><em>{{ __("Owner") }}: {{ $task->getTaskUser(Auth::user())->owner() }}</em></span>
                                    @endif

                                    <span class="pull-right">{{ __("Completition percentage") }}</span>
                                </td>
                                <td colspan="6">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar"
                                             style="width: {{ $task->getCompletitionPercentage() }}%;"
                                             aria-valuenow="{{ $task->getCompletitionPercentage() }}"
                                             aria-valuemin="0" aria-valuemax="100"
                                        >{{ $task->getCompletitionPercentage() }}%</div>
                                    </div>
                                </td>
                            </tr>

                            @if(!empty($task->workers->count()))
                                @foreach($task->workers as $worker)
                                    <tr>
                                        <td colspan="2"></td>
                                        <td>
                                            <span class="pull-right">{{ $worker }}</span>
                                        </td>
                                        <td colspan="6">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar"
                                                     style="width: {{ $task->getTaskUser($worker)->getCompletitionPercentage() }}%;"
                                                     aria-valuenow="{{ $task->getTaskUser($worker)->getCompletitionPercentage() }}"
                                                     aria-valuemin="0" aria-valuemax="100"
                                                >{{ $task->getTaskUser($worker)->getCompletitionPercentage() }}%</div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif




                        @endforeach
                        </tbody>
                    </table>

            </div>
            <div class="panel-footer">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
    </div>
@endsection