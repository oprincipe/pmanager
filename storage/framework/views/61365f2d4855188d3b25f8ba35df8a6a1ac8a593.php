<?php $__env->startSection('content'); ?>



    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">


        <!-- Example row of columns -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <form action="<?php echo e(route('projects.update', [$project->id])); ?>" method="post" role="form">

                    <?php echo e(csrf_field()); ?>


                    <input type="hidden" name="_method" value="put" />

                    <div class="well">
                        <h3>Project: <?php echo e($project->name); ?></h3>
                        <div class="row container-fluid">
                            Created at: <?php echo e($project->created_at->format('d/m/Y h:i:s')); ?>

                            <br />
                            Updated at: <?php echo e($project->updated_at->format('d/m/Y h:i:s')); ?>

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-name">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" id="project-name" placeholder="Project name"
                                required spellcheck="false" value="<?php echo e($project->name); ?>"
                                />
                    </div>

                    <div class="form-group">
                        <label for="project-description">Description</label>
                        <textarea class="form-control autosize-target text-left"
                                  name="description"
                                  id="project-description"
                                  placeholder="Project description"
                                  rows="5"
                                  spellcheck="false"
                                  style="resize: vertical"
                        ><?php echo e($project->description); ?></textarea>
                        <script>
                            CKEDITOR.replace('project-description');
                        </script>
                    </div>

                    <nav class="navbar navbar-default navbar-fixed-bottom">
                        <div class="container">
                            <ul class="nav navbar-nav">
                                <li>
                                    <a href="#">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </nav>

                </form>
            </div>

        </div>
    </div>

    <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
        </div>-->
        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="<?php echo e(URL::to('/projects/'.$project->id)); ?>"><i class="fa fa-briefcase"></i> View project</a></li>
                <li><a href="<?php echo e(URL::to('/companies/'.$project->company->id)); ?>"><i class="fa fa-building"></i> View company</a></li>
                <li><a href="<?php echo e(URL::to('/companies/')); ?>"><i class="fa fa-building-o"></i> All companies</a></li>
            </ol>
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>