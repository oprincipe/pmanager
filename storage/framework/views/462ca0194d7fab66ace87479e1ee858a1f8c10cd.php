<?php $__env->startSection('content_header'); ?>
    <h1><?php echo e($project->name); ?></h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <?php echo $__env->make("partials.tasks-resume-horizontal", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 pull-left">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $__env->make("partials.tasks-project-list-blocks", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                            <li><a href="<?php echo e(URL::to('/projects/'.$project->id.'/edit')); ?>"><i
                                            class="fa fa-pencil-square-o"></i> Edit</a></li>
                            <li><a href="<?php echo e(URL::to('/projects/create')); ?>"><i class="fa fa-plus"></i> Add project</a>
                            </li>
                            <li><a href="<?php echo e(URL::to('/companies/'.$project->company_id)); ?>"><i class="fa fa-list"></i>
                                    Projects list</a></li>
                            <li>
                                <a href="<?php echo e(URL::to('/reports/project/'.$project->id)); ?>" target="_blank"
                                ><i class="fa fa-print"></i> Print</a>
                            </li>

                            <br />
                            <li><a href="<?php echo e(route('tasks.create')."/".$project->id); ?>"><i class="fa fa-tasks"></i> New
                                                                                                                   task</a>
                            </li>

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

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Project info</h3>
                            </div>
                            <div class="panel-body" style="height: 240px; overflow: auto">
                                <p class="small"><?php echo nl2br($project->description); ?></p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php echo $__env->make("partials.file-form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php echo $__env->make("partials.files-mini-box", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php echo $__env->make("projects.customers.add", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php echo $__env->make("partials.comment-form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <?php echo $__env->make("partials.comments", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>
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