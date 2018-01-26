<?php $__env->startSection('content'); ?>

    <div class="row">

        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">

            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <!-- Jumbotron -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?php echo e($company->name); ?></h3>
                    </div>
                    <div class="panel-body">
                        <p class="lead"><?php echo e($company->address); ?> <?php echo e($company->city); ?> <?php echo e($company->cap); ?> <?php echo e($company->prov); ?> <?php echo e($company->country); ?></p>
                        <p class="lead">
                        <ul class="list-unstyled">
                            <?php if(!empty($company->website)): ?>
                                <li><a href="<?php echo e(URL::to($company->website)); ?>" target="_blank"><i
                                                class="fa fa-external-link"></i> <?php echo e($company->website); ?></a></li>
                            <?php endif; ?>
                            <?php if(!empty($company->contactName)): ?>
                                <li><i class="fa fa-user"></i> <?php echo e($company->contactName); ?></li><?php endif; ?>
                            <?php if(!empty($company->tel)): ?>
                                <li><a href="tel:+39<?php echo e($company->tel); ?>"><i class="fa fa-phone"></i> <?php echo e($company->tel); ?>

                                    </a></li><?php endif; ?>
                            <?php if(!empty($company->email)): ?>
                                <li><a href="mailto:<?php echo e($company->email); ?>"><i
                                                class="fa fa-envelope"></i> <?php echo e($company->email); ?></a></li><?php endif; ?>
                            <?php if(!empty($company->pec)): ?>
                                <li><a href="mailto:<?php echo e($company->pec); ?>"><i
                                                class="fa fa-envelope-square"></i> <?php echo e($company->pec); ?></a></li><?php endif; ?>
                            <?php if(!empty($company->skype)): ?>
                                <li><a href="skype:<?php echo e($company->skype); ?>?chat"><i
                                                class="fa fa-skype"></i> <?php echo e($company->skype); ?></a></li><?php endif; ?>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
                    <?php echo $__env->make("partials.comment-form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>


            <?php if(!empty($company->description)): ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="max-height: 300px; overflow: auto;">
                        <pre><?php echo e($company->description); ?></pre>
                    </div>
                </div>
                <br>
            <?php endif; ?>


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $__env->make("partials.file-form", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $__env->make("partials.files", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>


            <?php if(!empty($company->projects)): ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Projects
                                    <span class="pull-right">
                                <a style="color: white" href="<?php echo e(route('projects.create')."/".$company->id); ?>">
                                    <i class="glyphicon glyphicon-plus"></i>
                                </a>
                            </span>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Actions</th>
                                            <th>Name</th>
                                            <th>Tasks</th>
                                            <th>Last update</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $company->projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="text-nowrap">

                                                    <a href="<?php echo e(route('projects.show', ['project_id' => $project->id])); ?>"
                                                    ><i class="fa fa-briefcase"></i>
                                                    </a>

                                                    <a href="<?php echo e(route('projects.edit', ['project_id' => $project->id])); ?>"
                                                    ><i class="fa fa-pencil"></i>
                                                    </a>

                                                    <a href="<?php echo e(URL::to('/reports/project/'.$project->id)); ?>" target="_blank"
                                                    ><i class="fa fa-print"></i></a>

                                                    <?php if(Auth()->user()->role_id == 1): ?>
                                                        <span style="padding-left: 10px"></span>
                                                        <a href="#"
                                                           onclick="
                                                                   var result = confirm('Are you sure you wish to delete this project?');
                                                                   if(result) {
                                                                   event.preventDefault();
                                                                   $('#delete-project-<?php echo e($project->id); ?>').submit();
                                                                   }"><i class="fa fa-trash"></i></a>

                                                        <form id="delete-project-<?php echo e($project->id); ?>"
                                                              action="<?php echo e(route("projects.destroy", [$project->id])); ?>"
                                                              method="post" style="display: none">
                                                            <?php echo e(csrf_field()); ?>

                                                            <input type="hidden" name="_method" value="delete" />
                                                        </form>
                                                    <?php endif; ?>

                                                </td>
                                                <td>
                                                    <b><?php echo $project->name; ?></b>
                                                    <?php if(!empty($project->description)): ?>
                                                        <p>
                                                            <i><?php echo \Illuminate\Support\Str::words($project->description, 10, '...'); ?></i>
                                                        </p>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-nowrap col-xs-3">
                                                    <ul class="list-group">
                                                        <?php $__currentLoopData = $task_statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task_status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($task_status->id == App\TaskStatus::STATUS_CLOSED): ?>
                                                                <?php continue; ?>;
                                                            <?php endif; ?>

															<?php
															$tasks_count = $project->tasks_count($task_status->id);
															?>

                                                            <?php if($tasks_count > 0): ?>
                                                                <li class="list-group-item">
                                                                    <span class="badge"><?php echo e((int) $tasks_count); ?></span>
                                                                    <?php echo $task_status->icon()." ".$task_status->name; ?>

                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </td>
                                                <td>
                                                    <?php echo e($project->updated_at->format('d/m/Y H:i:s')); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Actions</h3>
                </div>
                <div class="panel-body">
                    <ol class="list-unstyled">
                        <li><a href="<?php echo e(URL::to('/companies')); ?>"><i class="fa fa-list"></i> Back to list</a></li>
                        <li><a href="<?php echo e(URL::to('/companies/'.$company->id.'/edit')); ?>"><i
                                        class="fa fa-pencil-square-o"></i> Edit</a></li>
                        <li>
                            <a href="<?php echo e(URL::to('/projects/create/'.$company->id)); ?>"
                            ><i class="fa fa-plus"></i> Add project</a>
                        </li>

                        <li>
                            <a href="<?php echo e(URL::to('/reports/company/'.$company->id)); ?>" target="_blank"
                            ><i class="fa fa-print"></i> Print</a>
                        </li>


                        <br />
                        <li>
                            <a href="#"
                               onclick="
                       var result = confirm('Are you sure you wish to delete this Company?');
                       if(result) {
                           event.preventDefault();
                           $('#delete-form').submit();
                       }"><i class="fa fa-trash"></i> Delete</a>

                            <form id="delete-form" action="<?php echo e(route("companies.destroy", [$company->id])); ?>"
                                  method="post" style="display: none">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="_method" value="delete" />
                            </form>

                        </li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <?php echo $__env->make("partials.comments", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>