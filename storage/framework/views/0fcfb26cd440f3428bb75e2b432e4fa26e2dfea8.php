<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">All projects
                <a class="pull-right btn btn-success btn-sm" href="<?php echo e(route("projects.create")); ?>">Create new project</a>
                </div>
            </div>
            <div class="panel-body">

                <ul class="list-group">
                    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="list-group-item">
                            <a href="<?php echo e(URL::to("/projects/".$project->id)); ?>">
                            <?php echo e($project->name); ?>

                            </a>
                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

            </div>
            <div class="panel-footer">
                <?php echo e($projects->links()); ?>

            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>