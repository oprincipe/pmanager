<?php $__env->startSection('content'); ?>
    <div class="row">

    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 pull-left">

        <!-- Jumbotron -->
        <div class="well well-lg">
            <h1><?php echo e($project->name); ?></h1>
            <!--<p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>-->
        </div>

        <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6">

            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Project info</h3>
                </div>
                <div class="panel-body" style="height: 240px; overflow: auto">
                    <p class="small"><?php echo nl2br($project->description); ?></p>
                </div>
            </div>

        </div>


        <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
            <?php echo $__env->make("partials.comment-form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Tasks
                            <span class="pull-right">
                                <a style="color: white" href="<?php echo e(route('tasks.create')."/".$project->id); ?>">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </a>
                            </span>
                        </h3>
                        <span class="pull-right">
                            <!-- Tabs -->
                            <ul class="nav panel-tabs">
                                <?php $__currentLoopData = $task_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="<?php if($task_status->id == App\TaskStatus::STATUS_STAND_BY): ?> <?php echo e("active"); ?> <?php endif; ?>">
                                        <a href="#tab<?php echo e($task_status->id); ?>" data-toggle="tab">
                                            <?php echo $task_status->icon(); ?>  <?php echo e($task_status->name); ?>

                                            <span class="badge"><?=(int) $project->tasks_count($task_status->id)?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">

                            <?php $__currentLoopData = $task_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-pane <?php if($task_status->id == App\TaskStatus::STATUS_STAND_BY): ?> <?php echo e("active"); ?> <?php endif; ?>" id="tab<?php echo e($task_status->id); ?>">

                                    <div class="table table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Status</th>
                                                <th>Name</th>
                                                <th>Hours</th>
                                                <th>Creation</th>
                                                <th>Last update</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $__currentLoopData = $project->tasks($task_status->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <label title="<?php echo e($task->status->name); ?>"><?php echo $task->status->icon(); ?></label>
                                                    </td>
                                                    <td class="text-nowrap">

                                                        <a href="<?php echo e(route('tasks.show', ['task_id' => $task->id])); ?>"
                                                        ><i class="fa fa-tasks"></i>
                                                        </a>

                                                        <a href="<?php echo e(route('tasks.edit', ['task_id' => $task->id])); ?>"
                                                        ><i class="fa fa-pencil"></i>
                                                        </a>

                                                        <?php if(Auth::user()->role_id == 1): ?>
                                                        <a href="#"
                                                           onclick="
                                                                   var result = confirm('Are you sure you wish to delete this task?');
                                                                   if(result) {
                                                                   event.preventDefault();
                                                                   $('#delete-task-<?php echo e($task->id); ?>').submit();
                                                                   }"><i class="fa fa-trash"></i></a>

                                                        <form id="delete-task-<?php echo e($task->id); ?>" action="<?php echo e(route("tasks.destroy", [$task->id])); ?>"
                                                              method="post" style="display: none">
                                                            <?php echo e(csrf_field()); ?>

                                                            <input type="hidden" name="_method" value="delete" />
                                                        </form>
                                                        <?php endif; ?>
                                                        
                                                    </td>
                                                    <td>
                                                        <b><?php echo $task->name; ?></b>
                                                        <?php if(!empty($task->description)): ?>
                                                            <p><i><?php echo \Illuminate\Support\Str::words($task->description, 10, '...'); ?></i></p>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo e($task->hours); ?>

                                                        <?php if(!empty($task->days)): ?>
                                                            (<?php echo e($task->days); ?> days)
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo e($task->created_at->format('d/m/Y H:i:s')); ?>

                                                    </td>
                                                    <td>
                                                        <?php echo e($task->updated_at->format('d/m/Y H:i:s')); ?>

                                                    </td>
                                                </tr>
                                            </tbody>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </table>
                                    </div>

                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div>-->
        <div class="sidebar-module">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">
                    <ol class="list-unstyled">
                        <li><a href="<?php echo e(URL::to('/projects/'.$project->id.'/edit')); ?>"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li><a href="<?php echo e(URL::to('/projects/create')); ?>"><i class="fa fa-plus"></i> Add project</a></li>
                        <li><a href="<?php echo e(URL::to('/companies/'.$project->company_id)); ?>"><i class="fa fa-list"></i> Projects list</a></li>

                        <br />
                        <li><a href="<?php echo e(route('tasks.create')."/".$project->id); ?>"><i class="fa fa-tasks"></i> New task</a></li>

                        <br />

                        <?php if(Auth::user()->role_id == 1): ?>
                            <li>
                                <a href="#"
                                   onclick="
                       var result = confirm('Are you sure you wish to delete this Project?');
                       if(result) {
                           event.preventDefault();
                           $('#delete-form').submit();
                       }"><i class="fa fa-trash"></i> Delete</a>

                                <form id="delete-form" action="<?php echo e(route("projects.destroy", [$project->id])); ?>"
                                      method="post" style="display: none">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="_method" value="delete" />
                                </form>

                            </li>
                        <?php endif; ?>
                    </ol>
                </div>
            </div>

            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo $__env->make("partials.comments", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

        </div>

        <!--
        <div class="sidebar-module">
            <h4>Members</h4>
            <ol class="list-unstyled">
                    <li><a href="#">member 1</a></li>

            </ol>
        </div>
        -->

    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>