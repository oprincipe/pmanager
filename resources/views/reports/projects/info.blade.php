@extends("layouts.reports")

@section('content')

    <style>
        .cell_small {
            width: 100px;
        }

        .cell_medium {
            width: 200px;
            white-space: normal;
        }

        .text-small {
            font-size: 10px;
        }
    </style>

    <h2>{{ $company->name }}</h2>
    {{-- <small><pre>{{ $company->description }}</pre></small> --}}


    <table cellspacing="0" cellpadding="2" style="width: 100%">
        <tr class="valign-top">
            <td>
                <table class="table_header" cellpadding="3" cellspacing="0" width="500">
                    <tr class="valign-top">
                        <th><b>{{ $project->name }}</b></th>
                    </tr>
                    <tr class="valign-top">
                        <td>
                            <div class="block-info">
                                <div class="text-small">{!! strip_tags($project->description,"<br>")  !!}</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="cell_medium">
                <table class="table_header" cellpadding="3" cellspacing="0">
                    <tr class="valign-top">
                        <th><b>Tasks resume</b></th>
                    </tr>
                    <tr class="valign-top">
                        <td>
                            @if (isset($tasks_resume) && count($tasks_resume) > 0)

                                <table class="table_header" border="1" cellpadding="1" cellspacing="2">
                                    <thead>
                                    <tr>
                                        <th class="border-grey">Status</th>
                                        <th class="text-right border-grey">Hours</th>
                                    </tr>
                                    </thead>
                                    <tbody>
						            <?php
						            $tot_hours = 0;
						            ?>
                                    @foreach($tasks_resume as $task_resume)
							            <?php
							            $tot_hours += $task_resume->tot_hours;
							            ?>
                                        <tr>
                                            <td class="border-grey">{{ ucfirst($task_resume->name) }}</td>
                                            <td class="text-right border-grey">{{ $task_resume->tot_hours }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th class="border-grey">Totals</th>
                                        <th class="text-right border-grey">{{ $tot_hours }}</th>
                                    </tr>
                                    </tfoot>
                                </table>

                            @else
                                <em>No task resume yet</em>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>



    @foreach($task_statuses as $task_status)
        @if(count($project->tasks($task_status->id)) <= 0)
            @continue
        @endif
        <div class="page_break"></div>
        <div class="page">
            <div class="td_header">
                <h2>{{ ucfirst($task_status->name) }}</h2>
            </div>
            <table class="table_header">
                <tr>
                    <th>Task</th>
                    <th class="text-center">Hours</th>
                    <th class="text-center">Created at</th>
                    <th class="text-center">Update at</th>
                </tr>
                <?php
	            $hours = 0;
	            $days = 0;
                ?>
                @foreach($project->tasks($task_status->id) as $task)
                    <tr>
                        <td>
                            <b>{!! $task->name !!}</b>
                            @if(!empty($task->description))
                                <span class="text-small"><i>{!! \Illuminate\Support\Str::words($task->description, 10, '...') !!}</i></span>
                            @endif
                        </td>
                        <td class="text-center cell_small">
                            <span>
                                {{ $task->hours }}
                                @if(!empty($task->days))
                                    ({{ $task->days }} days)
                                @endif
                                <?php
                                $hours += $task->hours;
                                $days  += $task->days;
                                ?>
                            </span>
                        </td>
                        <td class="text-center cell_small">
                            <span class="text-small">{{ $task->created_at->format('d/m/Y H:i:s') }}</span>
                        </td>
                        <td class="text-center cell_small">
                            <span class="text-small">{{ $task->updated_at->format('d/m/Y H:i:s') }}</span>
                        </td>
                    </tr>
                @endforeach
                <tfoot>
                    <tr>
                        <th>Total time</th>
                        <th class="text-center">
                            {{ $hours }}
                            @if(!empty($days))
                                - Days: {{ $days }}
                            @endif
                        </th>
                        <th class="text-center"></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endforeach

@endsection