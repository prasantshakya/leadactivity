@extends('layouts.admin')
@push('pre-purpose-css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}">
@endpush
@section('page-title')
    {{ __('Lead') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Lead') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Lead') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
        <form action="{{ route('lead.addlead') }}" method="POST">
            @csrf
    <div class="row">
      <!-- Requirement Type -->
        <div class="form-group col-md-4">
            <label for="requirement_type" class="col-form-label">Requirement Type</label>
            <select name="requirement_type" id="requirement_type" class="form-control">
                <option value="">Select Requirement Type</option>
                <option value="1">Buy</option>
                <option value="2">Rent</option>
            </select>
        </div>
 <!-- Name -->
        <div class="form-group col-md-4">
            <label for="name" class="col-form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required="required">
        </div>

        <!-- Email -->
        <div class="form-group col-md-4">
            <label for="email" class="col-form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" required="required">
        </div>

        <!-- Phone No -->
        <div class="form-group col-md-4">
            <label for="phone_no" class="col-form-label">Mobile</label>
            <input type="text" name="phone_no" id="phone_no" class="form-control" required="required">
        </div>


      

        <!-- Alternative No -->
        <div class="form-group col-md-4">
            <label for="alternative_no" class="col-form-label">Alternative No</label>
            <input type="text" name="alternative_no" id="alternative_no" class="form-control">
        </div>

        <!-- Unit No -->
        <div class="form-group col-md-4">
            <label for="unit_no" class="col-form-label">Unit No</label>
            <input type="text" name="unit_no" id="unit_no" class="form-control">
        </div>

        <!-- Project -->
        <div class="form-group col-md-4">
            <label for="project" class="col-form-label">Project</label>
            <select name="project_id" id="project_id" class="form-control">
              <option value="">Select Project</option>
                @foreach($projects as $project)
                <option value="{{$project->id}}">{{$project->title}}</option>
                @endforeach
            </select>
        </div>

        <!-- Property Stage -->
        <div class="form-group col-md-4">
            <label for="property_stage" class="col-form-label">Property Stage</label>
             <select name="property_stage" id="property_stage" class="form-control">
                <option value="">Select Property Stage</option>
                <option value="1">Ready To Move</option>
                <option value="2">Under Construction</option>
                <option value="3">Pre Launch</option>
            </select>
        </div>

       <!-- Property Type -->
<div class="form-group col-md-4">
    <label for="property_type" class="col-form-label">Property Type</label>
    <select name="property_type" id="property_type" class="form-control">
        <option value="">Select Property Type</option>
        <option value="residential">Residential</option>
        <option value="commercial">Commercial</option>
        <option value="industrial">Industrial</option>
    </select>
</div>

<!-- Property Sub Type -->
<div class="form-group col-md-4">
    <label for="property_sub_type" class="col-form-label">Property Sub Type</label>
    <select name="property_sub_type" id="property_sub_type" class="form-control">
        <option value="">Select Property Sub Type</option>
    </select>
</div>

        <!-- Budget -->
        <div class="form-group col-md-4">
            <label for="budget" class="col-form-label">Budget</label>
            <select name="budget" id="budget" class="form-control">
                <option value="">Select Budget</option>
                @foreach($budget as $data)
                <option value="{{$data->name}}">{{$data->name}}</option>
                @endforeach
            </select>
        </div>

        <!-- Location -->
        <div class="form-group col-md-4">
            <label for="location" class="col-form-label">Location</label>
            <select name="location" id="location" class="form-control">
                <option value="">Select Location</option>
                <option value="1">Delhi</option>
                <option value="2">Noida</option>
                <option value="3">Gurgaon</option>
                <option value="4">Faridabad</option>
                <option value="5">Ghaziabad</option>

            </select>
        </div>


        <!-- Lead Type -->
        <div class="form-group col-md-4">
            <label for="lead_type" class="col-form-label">Lead Type</label>
              <select name="lead_type" id="lead_type" class="form-control">
                <option value="">Select Lead Type</option>
                <option value="1">Data</option>
                <option value="2">Lead</option>
            </select>
        </div>
        
          <div class="form-group col-md-4">
            <label for="project" class="col-form-label">Customer Type</label>
            <select name="customer_type" id="customer_type" class="form-control">
              <option value="">Select Customer Type</option>
                <option value="1">Investor</option>
                <option value="2">End User</option>

            </select>
        </div>
        <!-- Lead Source -->
        <div class="form-group col-md-4">
            <label for="lead_source" class="col-form-label">Lead Source</label>
            <select name="lead_source" id="lead_source" class="form-control">
                <option value="">Select Lead Source</option>
              @foreach($source as $data)
                <option value="{{$data->id}}">{{$data->name}}</option>
                @endforeach
            </select>
        </div>
 <!-- Campaign -->
        <div class="form-group col-md-4">
            <label for="campaign" class="col-form-label">Campaign</label>
            <input type="text" name="campaign" id="campaign" class="form-control">
        </div>
</div>

    <!-- Submit Button -->
    <div class="modal-footer pr-0">
        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Create</button>
    </div>
</form>

<!-- Choices.js plugin script for multi-select -->
<script src="path/to/choices.min.js"></script>
<script>
    if (document.querySelectorAll(".multi-select").length > 0) {
        document.querySelectorAll(".multi-select").forEach(function(element) {
            new Choices(element, {
                removeItemButton: true,
            });
        });
    }
</script>


<!-- jQuery Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#property_type').on('change', function() {
            var propertyType = $(this).val();
            var subTypeOptions = {
                'residential': [
                    { value: 'apartment', text: 'Apartment' },
                    { value: 'flats', text: 'Flats' },
                    { value: 'villa', text: 'Villa' }
                ],
                'commercial': [
                    { value: 'shop', text: 'Shop' },
                    { value: 'office', text: 'Office' },
                    { value: 'food_court', text: 'Food Court' }
                ],
                'industrial': [] // Add subtypes if needed for industrial
            };

            // Clear current sub type options
            $('#property_sub_type').empty();
            $('#property_sub_type').append('<option value="">Select Property Sub Type</option>');

            // Populate sub type options based on the selected property type
            if (subTypeOptions[propertyType]) {
                subTypeOptions[propertyType].forEach(function(subType) {
                    $('#property_sub_type').append(
                        $('<option></option>').val(subType.value).text(subType.text)
                    );
                });
            }
        });
    });
</script>

        </div>
    </div>
@endsection

