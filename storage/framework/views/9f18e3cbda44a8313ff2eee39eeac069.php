<?php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
?>
<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Employee Detail')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">
            <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id) . ' ' . __('Details')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('employee.index')); ?>"><?php echo e(__('Employee')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e($user->name); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-6">
            <div class="card card-fluid">
                <div class="card-header">
                    <h5><?php echo e($user->name); ?></h5>
                </div>
                <div class="card-footer py-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('ID')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Date of Birth')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->dob) ? \Auth::user()->dateFormat($employee->dob) : '-'); ?>

                                </div>
                            </div>
                        </li>

                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Mobile')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e($employee->mobile); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Emergency Contact')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e($employee->emergency_contact); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Gender')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e($employee->gender); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Address')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e($employee->address); ?>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- <div class="col-sm-6">
                <div class="card card-fluid">
                    <div class="card-header">
                        <h5><?php echo e($user->name); ?></h5>
                    </div>
                    <div class="card-body employee-box">

                        <dl class="row">
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0"><?php echo e(__('ID')); ?></span></dt>
                            <dd class="col-sm-9"><span class="text-sm">  <?php echo e(\Auth::user()->employeeIdFormat($employee->employee_id)); ?></span></dd>
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0"><?php echo e(__('Date of Birth')); ?></span></dt>
                            <dd class="col-sm-9"><span class="text-sm"><?php echo e(\Auth::user()->dateFormat($employee->dob)); ?></span></dd>
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0"><?php echo e(__('Mobile')); ?></span></dt>
                            <dd class="col-sm-9"><span class="text-sm"><?php echo e($employee->mobile); ?></span></dd>
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0"><?php echo e(__('Emergency Contact')); ?></span></dt>
                            <dd class="col-sm-9"><span class="text-sm"><?php echo e($employee->emergency_contact); ?></span></dd>
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0"><?php echo e(__('Gender')); ?> </span></dt>
                            <dd class="col-sm-9"><span class="text-sm"><?php echo e($employee->gender); ?></span></dd>
                            <dt class="col-sm-3"><span class="h6 text-sm mb-0"><?php echo e(__('Address')); ?> </span></dt>
                            <dd class="col-sm-9"><span class="text-sm"><?php echo e($employee->address); ?></span></dd>
                        </dl>
                    </div>
                </div>
            </div> -->
        <div class="col-sm-6">
            <div class="card card-fluid">
                <div class="card-header">
                    <h5><?php echo e('Company Detail'); ?></h5>
                </div>
                <div class="card-footer py-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Department')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->departments) ? $employee->departments->name : ''); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Designation')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->designations) ? $employee->designations->name : ''); ?>

                                </div>
                            </div>
                        </li>

                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Date of Joining')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->joining_date) ? \Auth::user()->dateFormat($employee->joining_date) : '-'); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Date of Exit')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->exit_date) ? \Auth::user()->dateFormat($employee->exit_date) : '-'); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Salary Type')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->salaryType) ? $employee->salaryType->name : ''); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Salary')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(\Auth::user()->priceFormat($employee->salary)); ?>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card card-fluid">
                <div class="card-header">
                    <h5 class="mb-0"><?php echo e(__('Bank Detail')); ?></h5>
                </div>
                <div class="card-footer py-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Account Holder Name')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty(!empty($employee->account_holder_name)) ? $employee->account_holder_name : '-'); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Account Number')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->account_number) ? $employee->account_number : '-'); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Bank Name')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->bank_name) ? $employee->bank_name : '-'); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Bank Identifier Code')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->bank_identifier_code) ? $employee->bank_identifier_code : '-'); ?>

                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <span class="form-control-label"><?php echo e(__('Branch Location')); ?></span>
                                </div>
                                <div class="col-6 text-right">
                                    <?php echo e(!empty($employee->branch_location) ? $employee->branch_location : '-'); ?>

                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/employee/view.blade.php ENDPATH**/ ?>