<?php $__env->startSection('content_header'); ?>
<h1>Project List</h1>
<?php $__env->stopSection(); ?>;

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">All projects
                <a class="pull-right btn btn-success btn-sm" href="<?php echo e(route("projects.create")); ?>">Create new project</a>
                </div>
            </div>
            <td class="panel-body">

                <table class="table table-hover">
                    <col width="5%">
                    <col width="10%">
                    <col width="25%">
                    <col width="25%">
                    <col width="10%">
                    <col width="20%">
                    <thead>
                    <tr>
                        <th>Actions</th>
                        <th>Company</th>
                        <th>Project</th>
                        <th>Customers</th>
                        <th>Value</th>
                        <th>Tasks</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a href="<?php echo e(route("projects.show",$project->id)); ?>"><i class="fa fa-folder-open"></i> </a>
                            </td>
                            <td>
                                <a href="<?php echo e(route("companies.show", $project->company_id)); ?>"><?php echo e($project->company->name); ?></a>
                            </td>
                            <td>
                                <a href="<?php echo e(route("projects.show",$project->id)); ?>"><?php echo e($project->name); ?></a>
                            </td>
                            <td>
                                <ul>
                                <?php $__currentLoopData = $project->customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="list-group-item-text"><?php echo e($customer); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </td>
                            <td>
                                <?php echo e(money($project->value)); ?>

                            </td>
                            <td>
                                <table class="table table-condensed table-responsive" style="background-color: transparent;">
                                    <tbody>
                                    <tr>
                                    <?php $__currentLoopData = $task_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td style=" border-top: none">
                                            <a href="<?php echo e(route("projects.show",["id" => $project->id, "task_status_id" => $task_status->id])); ?>"
                                               title="<?php echo e($task_status->name); ?>">
                                                <?php echo $task_status->icon(); ?>

                                                <span class="badge"><?=(int) $project->tasks_count($task_status->id)?></span>
                                            </a>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
            <div class="panel-footer">
                <?php echo e($projects->links()); ?>

            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>