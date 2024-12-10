<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Attendance')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Attendance')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Attendance')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
        data-url="<?php echo e(route('attendance.file.import')); ?>" data-bs-whatever="<?php echo e(__('Import attendance CSV file')); ?>">
        <span class="text-white"> <i class="ti ti-file-import " data-bs-toggle="tooltip"
                data-bs-original-title="<?php echo e(__('Import attendance CSV file')); ?>"></i> </span></a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="col-xl-12">
        <div class="row">
            <div class="col-12">
                <div class=" <?php echo e(isset($_GET['date']) ? 'show' : ''); ?>" id="collapseExample">
                    <div class="card card-body">
                        <?php echo e(Form::open(['url' => 'attendance', 'method' => 'get'])); ?>

                        <div class="row filter-css">
                            <div class="col-md-2 my-1">
                                <?php echo e(Form::date('date', isset($_GET['date']) ? $_GET['date'] : '', ['class' => 'form-control'])); ?>

                            </div>
                            <?php if(\Auth::user()->type == 'company'): ?>
                                <div class="col-md-3 my-1">
                                    <?php echo e(Form::select('employee', $employees, isset($_GET['employee']) ? $_GET['employee'] : '', ['class' => 'form-control', 'data-toggle="select"'])); ?>

                                </div>
                            <?php endif; ?>
                            <div class="action-btn bg-info ms-2">
                                <div class="col-auto my-1">
                                    <button type="submit" class="mx-3 btn btn-sm d-flex align-items-center"
                                        data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>"><i
                                            class="ti ti-search text-white"></i></button>
                                </div>
                            </div>
                            <div class="action-btn bg-danger ms-2">
                                <div class="col-auto my-1">
                                    <a href="<?php echo e(route('attendance.index')); ?>" data-bs-toggle="tooltip"
                                        title="<?php echo e(__('Reset')); ?>" class="mx-3 btn btn-sm d-flex align-items-center"><i
                                            class="ti ti-trash-off text-white"></i></a>
                                </div>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                 <?php if(session('status')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo e(session('status')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <?php if(\Auth::user()->type != 'employee'): ?>
                                    <th><?php echo e(__('Employee')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Date')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Clock In')); ?></th>
                                <th><?php echo e(__('Clock Out')); ?></th>
                                <th><?php echo e(__('Late')); ?></th>
                                <th><?php echo e(__('Early Leaving')); ?></th>
                                <th><?php echo e(__('Overtime')); ?></th>
                                <?php if(\Auth::user()->type == 'company'): ?>
                                    <th class="text-right"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if(\Auth::user()->type != 'employee'): ?>
                                        <td><?php echo e(!empty($attendance->user) ? $attendance->user->name : ''); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e(\Auth::user()->dateFormat($attendance->date)); ?></td>
                                    <td><?php echo e($attendance->status); ?></td>
                                    <td><?php echo e($attendance->clock_in != '00:00:00' ? \Auth::user()->timeFormat($attendance->clock_in) : '00:00:00'); ?>

                                    </td>
                                    <td><?php echo e($attendance->clock_out != '00:00:00' ? \Auth::user()->timeFormat($attendance->clock_out) : '00:00:00'); ?>

                                    </td>
                                    <td><?php echo e($attendance->late); ?></td>
                                    <td><?php echo e($attendance->early_leaving); ?></td>
                                    <td><?php echo e($attendance->overtime); ?></td>
                                    <?php if(\Auth::user()->type == 'company'): ?>
                                        <td class="text-right">
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-url="<?php echo e(route('attendance.edit', $attendance->id)); ?>"
                                                    data-bs-whatever="<?php echo e(__('Edit Attendance')); ?>" title="Edit Attendance">
                                                    <span class="text-white"> <i class="ti ti-edit" data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Edit Attendance')); ?>"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['attendance.destroy', $attendance->id]]); ?>

                                                <a href="#!"
                                                    class="mx-3 btn btn-sm d-flex align-items-center show_confirm">
                                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                </a>
                                                <?php echo Form::close(); ?>

                                            </div>


                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/attendance/index.blade.php ENDPATH**/ ?>