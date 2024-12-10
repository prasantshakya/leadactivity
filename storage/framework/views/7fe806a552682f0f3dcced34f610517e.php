<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Meeting')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Meeting')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Meeting')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <a href="<?php echo e(route('meeting.calendar')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip"
        data-bs-placement="top" title="Calendar View"> <span class="text-white">
            <i class="ti ti-calendar-event text-white"></i></span>
    </a>

    <?php if(\Auth::user()->type == 'company'|| \Auth::user()->type == 'employee'): ?>
        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
            data-url="<?php echo e(route('meeting.create')); ?>" data-bs-whatever="<?php echo e(__('Create New Meeting')); ?>"
            data-bs-placement="top">
            <i class="ti ti-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="col-xl-12">
        <div class=" <?php echo e(isset($_GET['department']) ? 'show' : ''); ?>">
            <div class="card card-body">
                <?php echo e(Form::open(['url' => 'meeting', 'method' => 'get'])); ?>

                <div class="row filter-css">

                    <?php if(\Auth::user()->type == 'company'): ?>
                        <div class="col-md-2">
                            <?php echo e(Form::select('department', $departments, isset($_GET['department']) ? $_GET['department'] : '', ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

                        </div>
                        <div class="col-md-2">
                            <?php echo e(Form::select('designation', $designations, isset($_GET['designation']) ? $_GET['designation'] : '', ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

                        </div>
                    <?php endif; ?>

                    <div class="col-auto">
                        <?php echo e(Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : new \DateTime(), ['class' => 'form-control'])); ?>

                    </div>
                    <div class="col-auto">
                        <?php echo e(Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : new \DateTime(), ['class' => 'form-control'])); ?>

                    </div>
                    <div class="action-btn bg-info ms-2">
                        <button type="submit" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                            data-toggle="tooltip" data-title="<?php echo e(__('Apply')); ?>"><i data-bs-toggle="tooltip"
                                data-bs-original-title="<?php echo e(__('Apply')); ?>" class="ti ti-search text-white"></i></button>
                    </div>
                    <div class="action-btn bg-danger ms-2">
                        <a href="<?php echo e(route('meeting.index')); ?>" data-toggle="tooltip" data-title="<?php echo e(__('Reset')); ?>"
                            class="mx-3 btn btn-sm d-inline-flex align-items-center">
                            <i data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Reset')); ?>"
                                class="ti ti-trash-off text-white">
                            </i>
                        </a>
                    </div>
                </div>
                <?php echo e(Form::close()); ?>

            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <th><?php echo e(__('title')); ?></th>
                            <th><?php echo e(__('Date')); ?></th>
                            <th><?php echo e(__('Time')); ?></th>
                            <th><?php echo e(__('Department')); ?></th>
                            <th><?php echo e(__('Designation')); ?></th>
                            <?php if(\Auth::user()->type == 'company'): ?>
                                <th class="text-right" width="200px"><?php echo e(__('Action')); ?></th>
                            <?php endif; ?>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $meetings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $meeting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($meeting->title); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($meeting->date)); ?></td>
                                    <td><?php echo e(\Auth::user()->timeFormat($meeting->time)); ?></td>
                                    <td><?php echo e(!empty($meeting->departments) ? $meeting->departments->name : 'All'); ?></td>
                                    <td><?php echo e(!empty($meeting->designations) ? $meeting->designations->name : 'All'); ?></td>
                                    <?php if(\Auth::user()->type == 'company'): ?>
                                        <td class="text-right">
                                            

                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-url="<?php echo e(route('meeting.edit', $meeting->id)); ?>"
                                                    data-bs-whatever="<?php echo e(__('Edit Meeting')); ?>" data-bs-placement="top"
                                                    title="Edit"> <span class="text-white"> <i class="ti ti-edit"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="
                                                            <?php echo e(__('Edit')); ?>">
                                                        </i>
                                                    </span>
                                                </a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                <?php echo Form::open(['method' => 'DELETE', 'route' => ['meeting.destroy', $meeting->id]]); ?>

                                                <a href="#!"
                                                    class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm m-2">
                                                    <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                        data-bs-original-title="<?php echo e(__('Delete')); ?>">
                                                    </i>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/meeting/index.blade.php ENDPATH**/ ?>