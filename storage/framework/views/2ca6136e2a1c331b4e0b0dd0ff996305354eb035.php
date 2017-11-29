<?php $__env->startSection('content'); ?>
    <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">Companies
                    <?php if(Auth::user()->role_id == 1): ?>
                    <a class="pull-right btn btn-success btn-sm" href="<?php echo e(URL::to('/companies/create')); ?>">Create new company</a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="panel-body">

                <ul class="list-group">
                    <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <li class="list-group-item">
                            <a href="<?php echo e(URL::to("/companies/".$company->id)); ?>">
                            <?php echo e($company->name); ?>

                            </a>
                        </li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

            </div>
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>