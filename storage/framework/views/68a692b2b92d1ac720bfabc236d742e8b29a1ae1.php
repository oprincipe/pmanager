<?php $__env->startComponent('mail::message'); ?>

<h5><?php echo e($task->project->company->name); ?> - <?php echo e($task->project->name); ?></h5>
#<?php echo e($task->name); ?>


#<?php echo e($task_title); ?>


<?php $__env->startComponent('mail::table'); ?>
    | Task       | Value        |
    | ---------- |-------------:|
    | Name   | <?php echo e($task->name); ?>     |
    | Project   | <?php echo e($task->project->name); ?> |
    | Status   | <?php echo e($task->status->name); ?> |
    | Hours   | <?php echo e($task->hours); ?> |
    | Created at   | <?php echo e($task->created_at); ?> |
    | Updated at   | <?php echo e($task->updated_at); ?> |
<?php echo $__env->renderComponent(); ?>

<?php $__env->startComponent('mail::panel'); ?>
<?php echo str_limit(strip_tags($task->description), $limit = 150, $end = '...'); ?>

<?php echo $__env->renderComponent(); ?>


<?php $__env->startComponent('mail::button', ['url' => $view_url]); ?>
View task
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
