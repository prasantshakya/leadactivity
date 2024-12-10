<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).on('change', '#employee_id', function() {

            var employee_id = $(this).val();

            $.ajax({
                url: '<?php echo e(route('leave.jsoncount')); ?>',
                type: 'POST',
                data: {
                    "employee_id": employee_id,
                    // "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {

                    $('#leave_type').empty();
                    $('#leave_type').append('<option value=""><?php echo e(__('Select Leave Type')); ?></option>');

                    $.each(data, function(key, value) {

                        if (value.total_leave >= value.days) {
                            $('#leave_type').append('<option value="' + value.id +
                                '" disabled>' + value.title + '&nbsp(' + value.total_leave +
                                '/' + value.days + ')</option>');
                        } else {
                            $('#leave_type').append('<option value="' + value.id + '">' + value
                                .title + '&nbsp(' + value.total_leave + '/' + value.days +
                                ')</option>');
                        }
                    });

                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Leave')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Leave')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Leave')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
    <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
        <a href="<?php echo e(route('leave.calendar')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="tooltip"
            title="Calendar View">
            <i class="ti ti-calendar text-white"></i>
        </a>

        <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
            data-url="<?php echo e(route('leave.create')); ?>" data-bs-whatever="<?php echo e(__('Create New Leave')); ?>" data-size="lg">
            <i class="ti ti-plus text-white" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Create')); ?>"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="">
        <div class="col-xl-12">
            <div class=" <?php echo e(isset($_GET['employee']) ? 'show' : ''); ?>">
                <div class="card card-body">
                    <?php echo e(Form::open(['url' => 'leave', 'method' => 'get'])); ?>

                    <div class="row filter-css">
                        <?php if(\Auth::user()->type == 'company'): ?>
                            <div class="col-md-3">
                                <?php echo e(Form::select('employee', $employees, isset($_GET['employee']) ? $_GET['employee'] : '', ['class' => 'form-control', 'data-toggle' => 'select'])); ?>

                            </div>
                        <?php endif; ?>
                        <div class="col-auto">
                            <?php echo e(Form::date('start_date', isset($_GET['start_date']) ? $_GET['start_date'] : new \DateTime(), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="col-auto">
                            <?php echo e(Form::date('end_date', isset($_GET['end_date']) ? $_GET['end_date'] : new \DateTime(), ['class' => 'form-control'])); ?>

                        </div>
                        <div class="action-btn bg-info ms-2">
                            <div class="col-auto my-1">
                                <button type="submit" class="mx-3 btn btn-sm d-flex align-items-center"
                                    data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>">
                                    <i class="ti ti-search text-white"></i>
                                </button>
                            </div>
                        </div>
                        <!-- <div class="col-auto"><button type="submit" class="btn btn-sm btn-primary btn-icon-only" data-toggle="tooltip" data-title="<?php echo e(__('Apply')); ?>"><i class="ti ti-search"></i></button></div> -->
                        <div class="action-btn bg-danger ms-2">
                            <div class="col-auto my-1">
                                <a href="<?php echo e(route('leave.index')); ?>" data-bs-toggle="tooltip" title="<?php echo e(__('Reset')); ?>"
                                    class="mx-3 btn btn-sm d-flex align-items-center">
                                    <i class="ti ti-trash-off text-white"></i>
                                </a>
                            </div>
                        </div>
                        <!-- <div class="col-auto"><a href="<?php echo e(route('leave.index')); ?>" data-toggle="tooltip" data-title="<?php echo e(__('Reset')); ?>" class="btn btn-sm btn-danger btn-icon-only"><i class="ti ti-trash"></i></a></div> -->
                    </div>
                    <?php echo e(Form::close()); ?>

                </div>
            </div>
        </div>
    </div>


    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <!-- <h5></h5> -->
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <?php if(\Auth::user()->type != 'employee'): ?>
                                    <th><?php echo e(__('Employee')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Leave Type')); ?></th>
                                <th><?php echo e(__('Applied On')); ?></th>
                                <th><?php echo e(__('Start Date')); ?></th>
                                <th><?php echo e(__('End Date')); ?></th>
                                <th><?php echo e(__('Total Days')); ?></th>
                                <th><?php echo e(__('Leave Reason')); ?></th>
                                <th><?php echo e(__('status')); ?></th>
                                <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                                    <th class="text-right" width="200px"><?php echo e(__('Action')); ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php if(\Auth::user()->type != 'employee'): ?>
                                        <td><?php echo e(!empty($leave->user) ? $leave->user->name : ''); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e(!empty($leave->leaveType) ? $leave->leaveType->title : ''); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($leave->applied_on)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($leave->start_date)); ?></td>
                                    <td><?php echo e(\Auth::user()->dateFormat($leave->end_date)); ?></td>
                                    <?php
                                        $startDate = new \DateTime($leave->start_date);
                                        $endDate = new \DateTime($leave->end_date);
                                        $total_leave_day = !empty($startDate->diff($endDate)) ? $startDate->diff($endDate)->days : 0;
                                        $total_leave_days = $total_leave_day + 1;
                                    ?>
                                    <td><?php echo e($total_leave_days); ?></td>
                                    <td><?php echo e($leave->leave_reason); ?></td>
                                    <td>
                                        <?php if($leave->status == 'Pending'): ?>
                                            <div class="badge fix_badge bg-warning p-2 px-3 rounded">
                                                <?php echo e($leave->status); ?>

                                            </div>
                                        <?php elseif($leave->status == 'Approve'): ?>
                                            <div class="badge fix_badge bg-success p-2 px-3 rounded">
                                                <?php echo e($leave->status); ?>

                                            </div>
                                        <?php else: ?>
                                            <div class="badge fix_badge bg-danger p-2 px-3 rounded">
                                                <?php echo e($leave->status); ?>

                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                                        <div class="row ">
                                            <td class="">
                                                <?php if(\Auth::user()->type == 'company'): ?>
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            data-url="<?php echo e(route('leave.action', $leave->id)); ?>"
                                                            data-bs-whatever="<?php echo e(__('View Leave')); ?>">
                                                            <span class="text-white">
                                                                <i class="ti ti-eye" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('View')); ?>"></i>
                                                            </span>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee'): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                            data-url="<?php echo e(route('leave.edit', $leave->id)); ?>"
                                                            data-bs-whatever="<?php echo e(__('Edit Leave')); ?>" data-size="lg"> <span
                                                                class="text-white"> <i class="ti ti-edit"
                                                                    data-bs-toggle="tooltip"
                                                                    data-bs-original-title="<?php echo e(__('Edit')); ?>"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <?php echo Form::open(['method' => 'DELETE', 'route' => ['leave.destroy', $leave->id]]); ?>

                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm  align-items-center show_confirm ">
                                                            <i class="ti ti-trash text-white" data-bs-toggle="tooltip"
                                                                data-bs-original-title="<?php echo e(__('Delete')); ?>"></i>
                                                        </a>
                                                        <?php echo Form::close(); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </div>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/leave/index.blade.php ENDPATH**/ ?>