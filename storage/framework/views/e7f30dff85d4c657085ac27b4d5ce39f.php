
<?php echo e(Form::open(array('route' => array('attendance.import'),'method'=>'post', 'enctype' => "multipart/form-data"))); ?>

<div class="col-md-12 mb-2">
    <div class="d-flex align-items-center justify-content-between">
        <?php echo e(Form::label('file',__('Download sample Attendance CSV file'),['class'=>'form-control-label w-auto m-0'])); ?>

        <div>
            <a href="<?php echo e(asset(Storage::url('uploads/sample')).'/sample-attendance.csv'); ?>" class="btn btn-sm btn-primary">
                <i class="ti ti-download"></i> <?php echo e(__('Download')); ?>

            </a>
        </div>
    </div>
</div>
    <div class="col-md-12">
        <?php echo e(Form::label('file',__('Select CSV File:-'),['class'=>'form-control-label'])); ?>

        <div class="choose-file form-group col-12">
            <label for="file" class="form-control-label">
                <div><?php echo e(__('Choose file here')); ?>

                <input type="file" class="form-control" name="file" id="file" data-filename="upload_file" required>
            </div>
            </label>
            <p class="upload_file"></p>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
        <?php echo e(Form::submit(__('Upload'),array('class'=>'btn  btn-primary'))); ?>

    </div>
</div>
<?php echo e(Form::close()); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/attendance/import.blade.php ENDPATH**/ ?>