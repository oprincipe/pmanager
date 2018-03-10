
        <div class="table table-responsive"
        >
            <table class="table table-striped "

            >
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>#</th>
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
                @foreach($project->tasks($task_status->id) as $task)
                    <tr draggable="true" class="tag_row"
                        id="task_id_{{ $task->id }}"
                        data-content="task_status_{{ $task_status->id }}"
                    >
                        <td>
                            <i class="fa fa-clipboard" title="Drag task to another state"></i>
                        </td>
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
                            <b>{!! $task->name !!}</b>
                            {{--
                            @if(!empty($task->description))
                                <p><i>{!! \Illuminate\Support\Str::words($task->description, 10, '...') !!}</i></p>
                            @endif
                            --}}
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
                </tbody>
                @endforeach
            </table>
            <div class="box-body droppable" style="height: 40pt; border: 1px dotted black"
                 id="task_status_table_{{ $task_status->id }}">
                Drop task here to assign the status "{{ $task_status->name }}"
            </div>
        </div>
