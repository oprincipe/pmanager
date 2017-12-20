@extends("layouts.reports")

@section('content')

    <style>
        .cell_small {
            width: 100px;
        }

        .cell_big {
            width: 100%;
            white-space: normal;
        }

        .text-small {
            font-size: 10px;
        }
    </style>

    <h2>{{ $company->name }}</h2>
    {{-- <small><pre>{{ $company->description }}</pre></small> --}}


    <table class="table_header" cellpadding="3" cellspacing="0">
        <tr>
            <th><b>Project info</b></th>
        </tr>
        <tr>
            <td>
                <div class="block-info">
                    <div>{!! nl2br($project->description) !!}</div>
                </div>
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