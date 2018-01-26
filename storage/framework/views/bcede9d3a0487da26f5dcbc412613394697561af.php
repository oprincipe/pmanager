<?php $__env->startComponent('mail::message'); ?>

<h5><?php echo e($comment->commentable->name); ?></h5>

<?php $__env->startComponent('mail::panel'); ?>
<?php echo strip_tags($comment->body); ?>

<?php if(!empty($comment->url)): ?>
<?php echo e(url(strip_tags($comment->url))); ?>

<?php endif; ?>
<?php echo $__env->renderComponent(); ?>


<?php $__env->startComponent('mail::button', ['url' => $view_url]); ?>
View comment
<?php echo $__env->renderComponent(); ?>

Thanks,<br>
<?php echo e(config('app.name')); ?>


<?php echo $__env->renderComponent(); ?>
