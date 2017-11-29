<?php $__env->startSection('content'); ?>

<div class="row">

    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
         <form action="<?php echo e(route('projects.store')); ?>" method="post" role="form">

                    <?php echo e(csrf_field()); ?>


                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Create a new project</h3>
                        </div>
                        <div class="panel-body">
                            <?php if(!is_null($company_id)): ?>
                                <input type="hidden" class="form-control" name="company_id" id="company-id"
                                       value="<?php echo e($company_id); ?>"
                                />
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="company-id">Select the company <span class="required">*</span></label>
                                    <select class="form-control" name="company_id" id="company_id">
                                        <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($company->id); ?>"><?php echo e($company->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="project-name">Name <span class="required">*</span></label>
                                <input type="text" class="form-control" name="name" id="project-name" placeholder="Project name"
                                       required spellcheck="false"
                                />
                            </div>

                            <div class="form-group">
                                <label for="project-description">Description</label>
                                <textarea class="form-control autosize-target text-left"
                                          name="description"
                                          id="project-name"
                                          placeholder="Project description"
                                          rows="5"
                                          spellcheck="false"
                                          style="resize: vertical"
                                ></textarea>
                            </div>
                        </div>
                        <div class="panel-footer">

                            <a href="#">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Save</button>
                            </a>
                        </div>
                    </div>

                </form>
    </div>

    <div class="pull-right col-xs-3 col-sm-3 col-md-3 col-lg-3 blog-sidebar">
        <div class="sidebar-module">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">
                    <ol class="list-unstyled">
                        <li><a href="<?php echo e(route('projects.index')); ?>"><i class="fa fa-briefcase"></i> All projects</a></li>
                    </ol>
                </div>
            </div>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>