@extends('layouts.admin')

<style>
  .title-heading,
  .btn-close {
    color: #fff !important;
  }
  .form-label {
    font-weight: bold;
  }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <input type="hidden" class="form-control" id="lead_id" name="lead_id" value="{{ $lead_id }}" required>

                    <div class="form-group col-md-4">
                        <label for="date_of_booking" class="form-label">Date of Booking</label>
                        <input type="date" class="form-control" id="date_of_booking" name="date_of_booking" value="{{ old('date_of_booking') }}" required>
                    </div>

                     <div class="form-group col-md-4">
                        <label for="project_name" class="form-label">Project Name</label>
                       <select name="project_id" id="project_id" class="form-control">
                       <option value="">Select Project</option>
                       @foreach($projects as $project)
                       <option value="{{$project->id}}">{{$project->title}}</option>
                       @endforeach
                       </select>
                       </div>

                    <div class="form-group col-md-4">
                        <label for="developer_name" class="form-label">Developer Name</label>
                        <input type="text" class="form-control" id="developer_name" name="developer_name" value="{{ old('developer_name') }}" required>
                    </div>

                        <div class="form-group col-md-4">
                        <label for="source_of_funds" class="form-label">Source of Funds</label>
                       <select name="source_fund" id="project_id" class="form-control">
                       <option value="">Select</option>
                       <option value="1">Self Funding</option>
                       <option value="1">Self Loan Process</option>
                       </select> 
                       </div>

                    <div class="form-group col-md-4">
                        <label for="unit_number" class="form-label">Unit Number</label>
                        <input type="text" class="form-control" id="unit_number" name="unit_number" value="{{ old('unit_number') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="pan_number" class="form-label">PAN Number</label>
                        <input type="text" class="form-control" id="pan_number" name="pan_number" value="{{ old('pan_number') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="area" class="form-label">Area</label>
                        <input type="number" step="0.01" class="form-control" id="area" name="area" value="{{ old('area') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="measure" class="form-label">Measure</label>
                        <input type="text" class="form-control" id="measure" name="measure" value="{{ old('measure') }}">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="scheme" class="form-label">Scheme</label>
                        <input type="text" class="form-control" id="scheme" name="scheme" value="{{ old('scheme') }}">
                    </div>

                    <!-- Booking Docs (File Upload) -->
                    <div class="form-group col-md-4">
                        <label for="booking_docs" class="form-label">Booking Docs</label>
                        <input type="file" class="form-control" id="booking_docs" name="booking_docs">
                    </div>

                    <!-- KYC Docs (File Upload) -->
                    <div class="form-group col-md-4">
                        <label for="kyc_docs" class="form-label">KYC Docs</label>
                        <input type="file" class="form-control" id="kyc_docs" name="kyc_docs">
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Submit Booking</button>
            </form>
        </div>
    </div>
</div>
@endsection
