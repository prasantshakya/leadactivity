@extends('layouts.admin')
@push('pre-purpose-css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}">
@endpush
@section('page-title')
    {{ __('Edit Lead') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Edit Lead') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Edit Lead') }}</li>
@endsection
@section('action-btn')
@endsection
@section('content')
<div class="row">
    <div class="col-sm-12">
        <form action="{{ route('lead.update', $lead->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">

                <!-- Name -->
                <div class="form-group col-md-4">
                    <label for="name" class="col-form-label">Name</label>
                    <input type="text" name="name" value="{{ old('name', $lead->name) }}" id="name" class="form-control" required>
                </div>

                <!-- Email -->
                <div class="form-group col-md-4">
                    <label for="email" class="col-form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email', $lead->email) }}" id="email" class="form-control" required>
                </div>

                <!-- Phone No -->
                <div class="form-group col-md-4">
                    <label for="phone_no" class="col-form-label">Mobile</label>
                    <input type="text" name="phone_no" value="{{ old('phone_no', $lead->phone_no) }}" id="phone_no" class="form-control" required>
                </div>

                <!-- Requirement Type -->
                <div class="form-group col-md-4">
                    <label for="requirement_type" class="col-form-label">Requirement Type</label>
                    <select name="requirement_type" id="requirement_type" class="form-control">
                        <option value="">Select Requirement Type</option>
                        <option value="buy" {{ old('requirement_type', $lead->requirement_type) == 'buy' ? 'selected' : '' }}>Buy</option>
                        <option value="rent" {{ old('requirement_type', $lead->requirement_type) == 'rent' ? 'selected' : '' }}>Rent</option>
                    </select>
                </div>

               

                <!-- Alternative No -->
                <div class="form-group col-md-4">
                    <label for="alternative_no" class="col-form-label">Alternative No</label>
                    <input type="text" name="alternative_no" value="{{ old('alternative_no', $lead->alternative_no) }}" id="alternative_no" class="form-control">
                </div>

                <!-- Unit No -->
                <div class="form-group col-md-4">
                    <label for="unit_no" class="col-form-label">Unit No</label>
                    <input type="text" name="unit_no" value="{{ old('unit_no', $lead->unit_no) }}" id="unit_no" class="form-control">
                </div>

                <!-- Project -->
                <div class="form-group col-md-4">
                    <label for="project" class="col-form-label">Project</label>
                    <select name="project_id" id="project_id" class="form-control">
                        <option value="">Select Project</option>
                        @foreach($projects as $project)
                            <option value="{{ $project->id }}" {{ old('project_id', $lead->project_id) == $project->id ? 'selected' : '' }}>
                                {{ $project->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Property Stage -->
                <div class="form-group col-md-4">
                    <label for="property_stage" class="col-form-label">Property Stage</label>
                    <select name="property_stage" id="property_stage" class="form-control">
                        <option value="">Select Property Stage</option>
                        <option value="1" {{ old('property_stage', $lead->property_stage) == '1' ? 'selected' : '' }}>Ready To Move</option>
                        <option value="2" {{ old('property_stage', $lead->property_stage) == '2' ? 'selected' : '' }}>Under Construction</option>
                        <option value="3" {{ old('property_stage', $lead->property_stage) == '3' ? 'selected' : '' }}>Pre Launch</option>
                    </select>
                </div>

                <!-- Property Type -->
                <div class="form-group col-md-4">
                    <label for="property_type" class="col-form-label">Property Type</label>
                    <select name="property_type" id="property_type" class="form-control">
                        <option value="">Select Property Type</option>
                        <option value="residential" {{ old('property_type', $lead->property_type) == 'residential' ? 'selected' : '' }}>Residential</option>
                        <option value="commercial" {{ old('property_type', $lead->property_type) == 'commercial' ? 'selected' : '' }}>Commercial</option>
                        <option value="industrial" {{ old('property_type', $lead->property_type) == 'industrial' ? 'selected' : '' }}>Industrial</option>
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
                    <select name="budget_id" id="budget" class="form-control">
                        <option value="">Select Budget</option>
                        @foreach($budget as $data)
                            <option value="{{ $data->name }}" {{ old('budget', $lead->budget) == $data->name ? 'selected' : '' }}>
                                {{ $data->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                

                <!-- Location -->
                <div class="form-group col-md-4">
                    <label for="location" class="col-form-label">Location</label>
                    <select name="location" id="location" class="form-control">
                        <option value="">Select Location</option>
                        <option value="1" {{ old('location', $lead->location) == '1' ? 'selected' : '' }}>Delhi</option>
                        <option value="2" {{ old('location', $lead->location) == '2' ? 'selected' : '' }}>Noida</option>
                        <option value="3" {{ old('location', $lead->location) == '3' ? 'selected' : '' }}>Gurgaon</option>
                        <option value="4" {{ old('location', $lead->location) == '4' ? 'selected' : '' }}>Faridabad</option>
                        <option value="5" {{ old('location', $lead->location) == '5' ? 'selected' : '' }}>Ghaziabad</option>
                    </select>
                </div>

                <!-- Lead Type -->
                <div class="form-group col-md-4">
                    <label for="lead_type" class="col-form-label">Lead Type</label>
                    <select name="lead_type" id="lead_type" class="form-control">
                        <option value="">Select Lead Type</option>
                        <option value="1" {{ old('lead_type', $lead->lead_type) == '1' ? 'selected' : '' }}>Data</option>
                        <option value="2" {{ old('lead_type', $lead->lead_type) == '2' ? 'selected' : '' }}>Lead</option>
                    </select>
                </div>

           <div class="form-group col-md-4">
            <label for="project" class="col-form-label">Customer Type</label>
            <select name="customer_type" id="customer_type" class="form-control">
              <option value="">Select Customer Type</option>
                <option value="1" {{ old('customer_type', $lead->customer_type) == '1' ? 'selected' : '' }}>Investor</option>
                <option value="2" {{ old('customer_type', $lead->customer_type) == '2' ? 'selected' : '' }}>End User</option>

             </select>
             </div>
                <!-- Lead Source -->
                <div class="form-group col-md-4">
                    <label for="lead_source" class="col-form-label">Lead Source</label>
                    <select name="lead_source" id="lead_source" class="form-control">
                        <option value="">Select Lead Source</option>
                        <option value="google" {{ old('lead_source', $lead->lead_source) == 'google' ? 'selected' : '' }}>Google</option>
                        <option value="fb" {{ old('lead_source', $lead->lead_source) == 'fb' ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('lead_source', $lead->lead_source) == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="website" {{ old('lead_source', $lead->lead_source) == 'website' ? 'selected' : '' }}>Website</option>
                        <option value="91acre" {{ old('lead_source', $lead->lead_source) == '91acre' ? 'selected' : '' }}>91 Acre</option>
                        <option value="magicbrick" {{ old('lead_source', $lead->lead_source) == 'magicbrick' ? 'selected' : '' }}>Magic Brick</option>
                        <option value="internal" {{ old('lead_source', $lead->lead_source) == 'internal' ? 'selected' : '' }}>Internal</option>
                    </select>
                </div>



            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
            </div>
        </form>
    </div>
</div>
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

@endsection
