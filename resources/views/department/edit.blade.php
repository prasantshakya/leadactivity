{{ Form::model($department, array('route' => array('department.update', $department->id), 'method' => 'PUT')) }}
<div class="form-group">
    {{ Form::label('name', __('Name'),['class' => 'col-form-label']) }}
    {{ Form::text('name', null, array('class' => 'form-control','required'=>'required','Place Holder'=>__('Department'))) }}
</div>


<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{Form::submit(__('Update'),array('class'=>'btn  btn-primary'))}}
</div>
</div>

{{ Form::close() }}
