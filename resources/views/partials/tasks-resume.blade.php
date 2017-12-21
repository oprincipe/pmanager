<div class="row">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Tasks resume</h3>
            </div>
            <div class="panel-body">
                @if (isset($tasks_resume) && count($tasks_resume) > 0)

                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                            <tr>
                                <th>Status</th>
                                <th class="text-right">Hours</th>
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
                                <td>{{ $task_resume->name }}</td>
                                <td class="text-right">{{ $task_resume->tot_hours }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th>Totals</th>
                                <th class="text-right">{{ $tot_hours }}</th>
                            </tr>
                            </tfoot>
                        </table>

                @else
                    <em>No task resume yet</em>
                @endif
            </div>
        </div>
    </div>
</div>
