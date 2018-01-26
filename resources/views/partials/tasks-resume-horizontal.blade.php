<div class="row">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Project resume</h3>
            </div>
            <div class="panel-body">
                @if (isset($tasks_resume) && count($tasks_resume) > 0)

                    <table style="display: none" class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr>
                            <?php
	                        $tot_hours = array("hours" => 0,
                                               "hours_real" => 0,
                                               "value" => 0);
							?>
                            @foreach($tasks_resume as $task_resume)
                                <th class="text-center">{{ ucfirst($task_resume->name) }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @foreach($tasks_resume as $task_resume)
								<?php
		                        $tot_hours["hours"] += $task_resume->tot_hours;
		                        $tot_hours["hours_real"] += $task_resume->tot_hours_real;
		                        $tot_hours["value"] += $task_resume->tot_values;
		                        ?>
                                <td class="text-center">{{ $task_resume->tot_hours }}</td>
                            @endforeach
                        </tbody>
                        </tr>
                        <tfoot>
                        <tr>
                            @foreach($tot_hours as $tot_key => $tot_hour)
                                @if($tot_key == "hours") @continue @endif
                                @if($tot_key == "hours_real") @continue @endif
                                @if($tot_key == "value") @continue @endif

		                        <th class="text-center">{{ $tot_hour }}</th>
                            @endforeach
                        </tr>
                        </tfoot>
                    </table>

                    <div class="row">

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-green"><i class="ion ion-calculator"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Current value</span>
                                    <span class="info-box-number"><b><?=money($project->value)?></b></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-aqua"><i class="ion ion-calculator"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Task values</span>
                                    <span class="info-box-number"><?=money(number_format($tot_hours["value"],2))?></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-gray"><i class="ion ion-ios-timer"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Quoted time</span>
                                    <span class="info-box-number"><?=$tot_hours["hours"]?><span class="small">h</span></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box">
                                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-time"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Worked time</span>
                                    <span class="info-box-number"><?=$tot_hours["hours_real"]?><span class="small">h</span></span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                    </div>
                @else
                    <em>No task resume yet</em>
                @endif
            </div>
        </div>
    </div>
</div>
