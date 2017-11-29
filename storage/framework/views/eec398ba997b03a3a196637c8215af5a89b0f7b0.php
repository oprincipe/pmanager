<?php $__env->startSection('content'); ?>

    <div class="row">
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">


        <!-- Example row of columns -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php
				$form_method = (empty($task->id)) ? route('tasks.store') : route('tasks.update', [$task->id]);
				?>

                    <div class="well well-sm">
                        <div class="container-fluid">
                            <h3><?php echo e($task->name); ?></h3>
                        </div>
                    </div>


                    <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Task info</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <b><i class="fa fa-briefcase"></i> Project:</b> <?php echo $task->project->name; ?>

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <b><i class="fa fa-info"></i> Status:</b> <?php echo $task->status->icon(); ?> <?php echo e($task->status->name); ?>

                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <label for="task-hours"><i class="fa fa-user"></i> Expected hours:</label>
                                    <?php echo e($task->hours); ?>

                                </div>
                                <?php if(!empty($task->days)): ?>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <label for="task-days"><i class="fa fa-user"></i> Expected days:</label>
                                        <?php echo e($task->days); ?>

                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>


                    <div class="row col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                        <?php echo $__env->make("partials.comment-form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Main informations</h3>
                            </div>
                            <div class="panel-body">

                                <div class="container-fluid">
                                <?php echo $task->description; ?>

                                </div>

                            </div>
                        </div>
                    </div>




            </div>

        </div>
    </div>

    <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="<?php echo e(route('tasks.edit', $task->id)); ?>"><i class="fa fa-edit"></i> Edit task</a></li>
                <li><a href="<?php echo e(URL::to('/companies/'.$task->company_id)); ?>"><i class="fa fa-building"></i> View company</a></li>
                <li><a href="<?php echo e(URL::to('/projects/'.$task->project_id)); ?>"><i class="fa fa-briefcase"></i> View project</a></li>
                <li><a href="<?php echo e(URL::to('/companies/')); ?>"><i class="fa fa-list"></i> All companies</a></li>

                <?php if(Auth::user()->role_id == 1): ?>
                <br />
                <a href="#"
                   onclick="
                           var result = confirm('Are you sure you wish to delete this task?');
                           if(result) {
                           event.preventDefault();
                           $('#delete-task-<?php echo e($task->id); ?>').submit();
                           }"><i class="fa fa-trash"></i> Delete task</a>

                <form id="delete-task-<?php echo e($task->id); ?>" action="<?php echo e(route("tasks.destroy", [$task->id])); ?>"
                      method="post" style="display: none">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="_method" value="delete" />
                </form>
                <?php endif; ?>

            </ol>

            <div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo $__env->make("partials.comments", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

        </div>

    </div>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>