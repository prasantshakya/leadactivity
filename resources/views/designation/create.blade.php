{{ Form::open(array('url' => 'designation')) }}
<div class="form-group">
    {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}
    {{ Form::text('name', '', array('class' => 'form-control', 'required' => 'required')) }}
</div>
<div class="form-group">
    {{ Form::label('department', __('Department'), ['class' => 'col-form-label']) }}
    {{ Form::select('department', $department, null, array('class' => 'form-control multi-select', 'required' => 'required')) }}
</div>

<div class="col-12">
    <div class="form-group">
        {{ Form::label('level', __('Level'), ['class' => 'col-form-label']) }}
        {{ Form::select('level', ['1' => __('Level 1'), '2' => __('Level 2'), '3' => __('Level 3')], null, array('class' => 'form-control', 'required' => 'required')) }}
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Create'), array('class' => 'btn btn-primary')) }}
</div>

{{ Form::close() }}

<script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>

<script>
    if ($(".multi-select").length > 0) {
        $(".multi-select").each(function(index, element) {
            var id = $(element).attr('id');
            var multipleCancelButton = new Choices(
                '#' + id, {
                    removeItemButton: true,
                }
            );
        });
    }
</script>
