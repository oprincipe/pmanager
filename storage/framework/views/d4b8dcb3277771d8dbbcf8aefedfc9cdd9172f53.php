<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e($task->project->name); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">

		<?php
		$form_method = (empty($task->id)) ? route('tasks.store') : route('tasks.update', [$task->id]);
		?>

        <form action="<?php echo e($form_method); ?>" method="post" role="form">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="company_id" id="company_id" value="<?php echo e($task->company_id); ?>" />
            <input type="hidden" name="project_id" id="project_id" value="<?php echo e($task->project_id); ?>" />

            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="well">
                            <?php if(empty($task->id)): ?>
                                Create a new task for <?php echo e($task->project->name); ?>

                            <?php else: ?>
                                Task: <?php echo e($task->name); ?>

                                    <input type="hidden" name="_method" value="put" />
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Task</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group">
                                        <label for="task-name"><i class="fa fa-user"></i> Name <span
                                                    class="required">*</span></label>
                                        <input type="text" class="form-control" name="name" id="task-name"
                                               placeholder="task name"
                                               required spellcheck="false" value="<?php echo e($task->name); ?>"
                                        />
                                    </div>
                                </div>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <label for="task-status-id"><i class="fa fa-info"></i> Status <span
                                                class="required">*</span></label>
                                    <?php if(Auth::user()->role_id == 1): ?>
                                        <div class="form-group">
                                            <select class="form-control" name="status_id" id="task-status-id">
                                                <?php $__currentLoopData = $task_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($task_status->id); ?>"
                                                            <?php if($task_status->id == $task->status_id): ?>
                                                            selected="selected"
                                                            <?php endif; ?>
                                                    ><?php echo e($task_status->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    <?php else: ?>
                                        <input type="hidden" name="status_id" id="task-status-id"
                                               value="<?php echo e((empty($task->id)) ? 1 : $task->status_id); ?>" />
                                        <?php echo e(empty($task->id) ? App\TaskStatus::find(1)->name : $task->status->name); ?>

                                    <?php endif; ?>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Description</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <textarea class="form-control autosize-target text-left"
                                              name="description"
                                              id="task-description"
                                              placeholder="Task description"
                                              rows="5"
                                              spellcheck="false"
                                              style="resize: vertical"
                                    ><?php echo $task->description; ?></textarea>
                                    <script>
                                        CKEDITOR.replace('task-description');
                                    </script>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <br /><br /><br />
                    </div>
                </div>

            </div>

            <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Actions</h3>
                    </div>
                    <div class="panel-body">
                        <ol class="list-unstyled">
                            <?php if(!empty($task->id)): ?>
                                <li><a href="<?php echo e(route('tasks.show', $task->id)); ?>"><i class="fa fa-tasks"></i> View task</a>
                                </li>
                            <?php endif; ?>
                            <li><a href="<?php echo e(URL::to('/companies/'.$task->company_id)); ?>"><i class="fa fa-building"></i>
                                    View
                                    company</a>
                            </li>
                            <li><a href="<?php echo e(URL::to('/projects/'.$task->project_id)); ?>"><i class="fa fa-briefcase"></i>
                                    View
                                    project</a>
                            </li>
                            <li><a href="<?php echo e(URL::to('/companies/')); ?>"><i class="fa fa-list"></i> All companies</a></li>
                        </ol>
                    </div>
                </div>


                <?php echo $__env->make("partials.save-navbar", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Task previsions</h3>
                    </div>
                    <div class="panel-body">

                        <div class="form-group">
                            <label for="task-hours"><i class="fa fa-clock-o"></i> Expected hours <span
                                        class="required">*</span></label>
                            <input type="number" class="form-control" name="hours" id="task-hours"
                                   placeholder="Quote hours to complete"
                                   required
                                   spellcheck="false" value="<?php echo e($task->hours); ?>"
                            />
                        </div>

                        <div class="form-group">
                            <?php if(Auth()->user()->role_id !== \App\Role::SUPER_ADMIN): ?>
                                <label for="task-hours-real"><i class="fa fa-clock-o"></i> Real worked hours <span
                                            class="required">*</span></label>
                                <span class="pull-right"><?php echo e((int) $task->hours_real); ?></span>
                            <?php else: ?>
                                <label for="task-hours-real"><i class="fa fa-clock-o"></i> Real worked hours </label>
                                <input type="number" class="form-control" name="hours_real" id="task-hours-reals"
                                       placeholder="How many hours you real take to complete this task"
                                       spellcheck="false" value="<?php echo e(1*$task->hours_real); ?>"
                                />
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <?php if(Auth()->user()->role_id !== \App\Role::SUPER_ADMIN): ?>
                                <label for="task-price"><i class="fa fa-clock-o"></i> Price per hours <span
                                            class="required">*</span></label>
                                <span class="pull-right"><?php echo e(money($task->getPrice(), "EUR")); ?></span>
                            <?php else: ?>
                                <label for="task-price"><i class="fa fa-euro"></i>/<i class="fa fa-clock-o"></i> Price per hours </label>
                                <input type="text" class="form-control" name="price" id="task-price"
                                       placeholder="Price per hours"
                                       spellcheck="false" value="<?php echo e(money($task->getPrice(), "EUR")); ?>"
                                />
                            <?php endif; ?>
                        </div>


                    </div>
                </div>

            </div>

        </form>
    </div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>