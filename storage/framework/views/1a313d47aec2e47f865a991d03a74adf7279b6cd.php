<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('navbar_elements'); ?>
    <?php if(Auth()->user()): ?>
    <li>
        <a href=""><i class="fa fa-user"></i> <?php echo e(Auth()->user()->fullName()); ?></a>
    </li>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content_header'); ?>
    <h1>Dashboard</h1>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('css'); ?>
    <link href="<?php echo e(asset('css/common.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar-fixed-side.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="<?php echo e(asset('unisharp/laravel-ckeditor/ckeditor.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <p>Welcome to this beautiful admin panel.</p>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('add_script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>