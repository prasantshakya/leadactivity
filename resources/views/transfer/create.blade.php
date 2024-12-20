{{Form::open(array('url'=>'transfer','method'=>'post'))}}
<div class="card-body p-0">
    @php 
    $plansettings = App\Models\Utility::plansettings();
@endphp
<div class="row">
   @if (isset($plansettings['enable_chatgpt']) && $plansettings['enable_chatgpt'] == 'on')
     <div class="text-end">
             <a href="#" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('generate',['transfer']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate') }}" float-end>
            <span class="btn btn-primary btn-sm"> <i class="fas fa-robot">  {{ __('Generate With AI') }}</span></i>
        </a>
     </div>
     
        @endif

        <div class="form-group col-lg-6 col-md-6">
            {{ Form::label('employee_id', __('Employee'),['class' => 'col-form-label']) }}
            {{ Form::select('employee_id', $employees,null, array('class' => 'form-control multi-select','required'=>'required')) }}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('department_id',__('Department'),['class' => 'col-form-label'])}}
            {{Form::select('department_id',$departments,null,array('class'=>'form-control multi-select'))}}
        </div>
        <div class="form-group col-lg-6 col-md-6">
            {{Form::label('transfer_date',__('Transfer Date'),['class' => 'col-form-label'])}}
            {{Form::date('transfer_date',new \DateTime(),array('class'=>'form-control'))}}
        </div>
        <div class="form-group col-lg-12">
            {{Form::label('description',__('Description'),['class' => 'col-form-label'])}}
            {{Form::textarea('description',null,array('class'=>'form-control','rows'=>3,'placeholder'=>__('Enter Description')))}}
        </div>
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{Form::submit(__('Create'),array('class'=>'btn  btn-primary'))}}
</div>
{{Form::close()}}


<script src="{{asset('assets/js/plugins/choices.min.js')}}"></script>

<script>
    if ($(".multi-select").length > 0) {
              $( $(".multi-select") ).each(function( index,element ) {
                  var id = $(element).attr('id');
                     var multipleCancelButton = new Choices(
                          '#'+id, {
                              removeItemButton: true,
                          }
                      );
              });
         }
</script>