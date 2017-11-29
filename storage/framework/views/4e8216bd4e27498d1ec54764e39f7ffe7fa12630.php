<?php $__env->startSection('content'); ?>

    <div class="row">
    <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">


        <!-- Example row of columns -->
        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php
                $form_method = (empty($company->id)) ? route('companies.store') : route('companies.update', [$company->id]);
                ?>
                <form action="<?php echo e($form_method); ?>" method="post" role="form">

                    <?php echo e(csrf_field()); ?>



                    <legend>
                        <?php if(empty($company->id)): ?>
                            Create a new company
                        <?php else: ?>
                            Company <?php echo e($company->name); ?>

                            <input type="hidden" name="_method" value="put" />
                        <?php endif; ?>
                    </legend>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Owner</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <?php if(Auth::user()->role_id == 1): ?>
                                        <select class="form-control" name="user_id" id="user_id">
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($owner->id); ?>"
                                                    <?php if($owner->id == $company->user_id): ?>
                                                        selected="selected"
                                                    <?php endif; ?>
                                                    ><?php echo e($owner->fullName()); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    <?php else: ?>
                                        <?php echo e($company->user->fullName()); ?>

                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Main informations</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="company-name"><i class="fa fa-user"></i> Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="name" id="company-name" placeholder="Company name"
                                           required spellcheck="false" value="<?php echo e($company->name); ?>"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="company-contactName"><i class="fa fa-user"></i> Contact name <span class="required">*</span></label>
                                    <input type="text" class="form-control" name="contactName" id="company-contactName" placeholder="Company contactName"
                                           required spellcheck="false" value="<?php echo e($company->contactName); ?>"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="company-description"><i class="fa fa-list"></i> Description</label>
                                    <textarea class="form-control autosize-target text-left"
                                              name="description"
                                              id="company-name"
                                              placeholder="Company description"
                                              rows="5"
                                              spellcheck="false"
                                              style="resize: vertical"
                                    ><?php echo $company->description; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="company-website"><i class="fa fa-external-link"></i> Website </label>
                                    <input type="text" class="form-control" name="website" id="company-contactName"
                                           placeholder="Company website"
                                           spellcheck="false" value="<?php echo e($company->website); ?>"
                                    />
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Account information</h3>
                                <span class="pull-right clickable" style="margin-top: -18px"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="company-vatCode"><i class="fa fa-info"></i> Vat Code</label>
                                    <input type="text" class="form-control" name="vatCode" id="company-vatCode"
                                           placeholder="Company vatCode"
                                           spellcheck="false" value="<?php echo e($company->vatCode); ?>"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="company-cfCode"><i class="fa fa-credit-card"></i> Cod. fisc.</label>
                                    <input type="text" class="form-control" name="cfCode" id="company-cfCode"
                                           placeholder="Company cfCode"
                                           spellcheck="false" value="<?php echo e($company->cfCode); ?>"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Address</h3>
                                <span class="pull-right clickable" style="margin-top: -18px"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="company-address"><i class="fa fa-street-view"></i> address</label>
                                    <input type="text" class="form-control" name="address" id="company-address"
                                           placeholder="Company address"
                                           spellcheck="false" value="<?php echo e($company->address); ?>"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="company-city"><i class="fa fa-building"></i> City</label>
                                    <input type="text" class="form-control" name="city" id="company-city"
                                           placeholder="Company city"
                                           spellcheck="false" value="<?php echo e($company->city); ?>"
                                    />
                                </div>


                                <div class="row form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company-cap"><i class="fa fa-building"></i> Cap</label>
                                        <input type="text" class="form-control" name="cap" id="company-cap"
                                               placeholder="Company cap"
                                               spellcheck="false" value="<?php echo e($company->cap); ?>"
                                        />
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="company-prov"><i class="fa fa-building"></i> Prov.</label>
                                        <input type="text" class="form-control" name="prov" id="company-prov"
                                               placeholder="Company prov"
                                               spellcheck="false" value="<?php echo e($company->prov); ?>"
                                        />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="company-country"><i class="fa fa-building"></i> Country</label>
                                    <input type="text" class="form-control" name="country" id="company-country"
                                           placeholder="Company country"
                                           spellcheck="false" value="<?php echo e($company->country); ?>"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Phone/Fax</h3>
                                <span class="pull-right clickable" style="margin-top: -18px"><i class="glyphicon glyphicon-chevron-up"></i></span>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="company-tel"><i class="fa fa-phone"></i> Tel.</label>
                                    <input type="text" class="form-control" name="tel" id="company-tel" placeholder="Company tel"
                                           spellcheck="false" value="<?php echo e($company->tel); ?>"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="company-fax"><i class="fa fa-fax"></i> Fax</label>
                                    <input type="text" class="form-control" name="fax" id="company-fax" placeholder="Company fax"
                                           spellcheck="false" value="<?php echo e($company->fax); ?>"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Virtual contact</h3>
                            <span class="pull-right clickable" style="margin-top: -18px"><i class="glyphicon glyphicon-chevron-up"></i></span>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="company-email"><i class="fa fa-envelope"></i> Email</label>
                                <input type="text" class="form-control" name="email" id="company-email" placeholder="Company email"
                                       spellcheck="false" value="<?php echo e($company->email); ?>"
                                />
                            </div>

                            <div class="form-group">
                                <label for="company-pec"><i class="fa fa-envelope-square"></i> Pec</label>
                                <input type="text" class="form-control" name="pec" id="company-pec" placeholder="Company pec"
                                       spellcheck="false" value="<?php echo e($company->pec); ?>"
                                />
                            </div>

                            <div class="form-group">
                                <label for="company-skype"><i class="fa fa-skype"></i> Skype</label>
                                <input type="text" class="form-control" name="skype" id="company-skype" placeholder="Company skype"
                                       spellcheck="false" value="<?php echo e($company->skype); ?>"
                                />
                            </div>
                        </div>
                    </div>
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

    <div class="pull-right col-xs-12 col-sm-3 col-md-3 col-lg-3 blog-sidebar">

        <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
                <li><a href="<?php echo e(URL::to('/companies/'.$company->id)); ?>"><i class="fa fa-info"></i> View company</a></li>
                <li><a href="<?php echo e(URL::to('/companies/')); ?>"><i class="fa fa-list"></i> All companies</a></li>
            </ol>
        </div>

    </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('add_script'); ?>
    <script>
        $(document).on('click', '.panel-heading span.clickable', function(e){
            var $this = $(this);
            if(!$this.hasClass('panel-collapsed')) {
                $this.closest('.panel').find('.panel-body').slideUp();
                $this.addClass('panel-collapsed');
                $this.find('i').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
            } else {
                $this.closest('.panel').find('.panel-body').slideDown();
                $this.removeClass('panel-collapsed');
                $this.find('i').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
            }
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layouts.app", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>