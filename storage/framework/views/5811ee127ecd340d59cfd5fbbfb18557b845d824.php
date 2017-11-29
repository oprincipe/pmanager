<div class="row">
    <div class="container-fluid">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Comments</h3>
            </div>
            <div class="panel-body">
                <?php if(isset($comments) && count($comments) > 0): ?>
                    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <strong><?php echo e($comment->user->fullName()); ?></strong>
                                <span class="pull-right">

                                    <a href="#"
                                       onclick="
                                       var result = confirm('Are you sure you wish to delete this comment?');
                                       if(result) {
                                           event.preventDefault();
                                           $('#delete-comment-<?php echo e($comment->id); ?>').submit();
                                       }"><i class="fa fa-trash"></i></a>

                                    <form id="delete-comment-<?php echo e($comment->id); ?>" action="<?php echo e(route("comments.destroy", [$comment->id])); ?>"
                                          method="post" style="display: none">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="_method" value="delete" />
                                    </form>

                                </span>
                            </div>
                            <div class="panel-body">
                                <span class="text-muted"><?php echo e($comment->created_at->format('d/m/Y H:i:s')); ?></span>
                                <p class="text-danger"><?php echo e($comment->url); ?></p>
                                <?php echo e($comment->body); ?>

                            </div><!-- /panel-body -->
                        </div><!-- /panel panel-default -->

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <em>No comments yet</em>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
