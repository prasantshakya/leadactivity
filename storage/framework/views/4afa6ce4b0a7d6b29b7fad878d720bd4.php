<?php $__env->startPush('pre-purpose-css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/plugins/dragula.min.css')); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Lead')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Leads')); ?></a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('All Leads')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-btn'); ?>
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
       data-url="<?php echo e(route('lead.file.import')); ?>" data-bs-whatever="<?php echo e(__('Import CSV file')); ?>">
        <span class="text-white">
            <i class="ti ti-file-import" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('Import item CSV file')); ?>"></i>
        </span>
    </a>
<?php if(\Auth::user()->type == 'company'): ?>
        <a href="<?php echo e(route('lead.create')); ?>" class="btn btn-sm btn-primary btn-icon m-1" data-bs-whatever="<?php echo e(__('Create New Lead')); ?>"
           data-bs-original-title="<?php echo e(__('Create New Lead')); ?>">
            <i data-bs-toggle="tooltip" title="<?php echo e(__('Create')); ?>" class="ti ti-plus text-white"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <?php if($leads->isEmpty()): ?>
                <div class="alert alert-warning">No leads found.</div>
            <?php else: ?>
                
                <button id="assignButton" class="btn btn-sm btn-secondary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#assignModal">
                    <i class="ti ti-user text-white"></i> <?php echo e(__('Assign to User')); ?>

                </button>
<div class="table-responsive">
    <table class="table custom-table" id="leadTable">
        <thead>
            <tr>
                <th><input type="checkbox" id="selectAll"></th> <!-- Master Checkbox for Select All -->
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Lead Type</th>
                <th>Project</th>
                <th>Budget</th>
                <th>Requirements</th>
                <th>Sources</th>
                <th>Lead Owner</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $leads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lead): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><input type="checkbox" class="lead-checkbox" data-id="<?php echo e($lead['id']); ?>"></td>
                    <td><a href="<?php echo e(route('lead.view', $lead['id'])); ?>"><?php echo e($lead['name']); ?></a></td>
                    <td><?php echo e($lead['email']); ?></td>
                    <td><a href="tel:<?php echo e($lead['phone_no']); ?>"><?php echo e($lead['phone_no']); ?></a></td>
<td>
    <?php if($lead['lead_type'] == 1): ?>
        <?php echo e(__('Buy')); ?>

    <?php elseif($lead['lead_type'] == 2): ?>
        <?php echo e(__('Rent')); ?>

    <?php else: ?>
        <?php echo e(__('N/A')); ?>

    <?php endif; ?>
</td>
                    <td><?php echo e($lead->project->title ?? 'N/A'); ?></td>
                    <td><?php echo e($lead->budget->name ?? 'N/A'); ?></td>
                    <td><?php echo e($lead['requirements'] ?? 'N/A'); ?></td>
                    <td><?php echo e($lead->source->name ?? 'N/A'); ?></td>
                    <td> <?php echo e($lead->user->name ?? 'N/A'); ?> </td>
                    <td><?php echo e($lead['created_at']); ?></td>
                    <td><?php echo e($lead['updated_at']); ?></td>
                    <td>
                        <a href="<?php echo e(route('lead.edit', $lead['id'])); ?>" class="btn btn-sm btn-warning">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <form action="<?php echo e(route('lead.destroy', $lead['id'])); ?>" method="POST" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
            <?php endif; ?>
        </div>
    </div>
    
<!-- Modal for assigning selected leads to a user -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel"><?php echo e(__('Assign Leads to User')); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignForm" action="<?php echo e(route('lead.assign')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="userSelect"><?php echo e(__('Select User')); ?></label>
                        <select name="user_id" id="userSelect" class="form-control" required>
                            <option value="" disabled selected><?php echo e(__('Choose a user')); ?></option>
                            <?php $__currentLoopData = $ulist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($user->user_id); ?>"><?php echo e($user->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <input type="hidden" name="lead_ids[]" id="leadIdsInput">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo e(__('Assign')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Capture checkboxes and assign button
    const selectAllCheckbox = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[type="checkbox"][data-id]');
    const assignButton = document.getElementById('assignButton');
    const leadIdsInput = document.getElementById('leadIdsInput');
    
    // Array to store selected lead IDs
    let selectedLeadIds = [];

    // Toggle all checkboxes when 'Select All' checkbox is clicked
    selectAllCheckbox.addEventListener('change', function () {
        selectedLeadIds = []; // Clear the array on each change

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked; // Set each checkbox to match 'Select All'
            if (checkbox.checked) {
                selectedLeadIds.push(checkbox.getAttribute('data-id'));
            }
        });
    });

    // Update the selectedLeadIds array when individual checkboxes are clicked
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function () {
            const leadId = checkbox.getAttribute('data-id');
            if (checkbox.checked) {
                selectedLeadIds.push(leadId);
            } else {
                selectedLeadIds = selectedLeadIds.filter(id => id !== leadId);
            }

            // Uncheck 'Select All' if not all checkboxes are selected
            selectAllCheckbox.checked = selectedLeadIds.length === checkboxes.length;
        });
    });

    // Open the modal and set the selected lead IDs in the hidden input field
    assignButton.addEventListener('click', function () {
        if (selectedLeadIds.length > 0) {
            leadIdsInput.value = selectedLeadIds.join(','); // Join IDs as comma-separated string
        } else {
            alert('Please select at least one lead to assign.');
        }
    });
});
</script>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/lead/list.blade.php ENDPATH**/ ?>