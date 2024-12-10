@extends('layouts.admin')

@push('pre-purpose-css-page')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/dragula.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endpush

@section('page-title')
    {{ __('Lead') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Leads') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('All Leads') }}</li>
@endsection

@section('action-btn')
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#exampleModal"
       data-url="{{ route('lead.file.import') }}" data-bs-whatever="{{ __('Import CSV file') }}">
        <span class="text-white">
            <i class="ti ti-file-import" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Import item CSV file') }}"></i>
        </span>
    </a>

    @if (\Auth::user()->type == 'company')
        <a href="{{ route('lead.create') }}" class="btn btn-sm btn-primary btn-icon m-1" data-bs-whatever="{{ __('Create New Lead') }}"
           data-bs-original-title="{{ __('Create New Lead') }}">
            <i data-bs-toggle="tooltip" title="{{ __('Create') }}" class="ti ti-plus text-white"></i>
        </a>
    @endif
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12">
            @if ($leads->isEmpty())
                <div class="alert alert-warning">No leads found.</div>
            @else
                
                <button id="assignButton" class="btn btn-sm btn-secondary btn-icon m-1" data-bs-toggle="modal" data-bs-target="#assignModal">
                    <i class="ti ti-user text-white"></i> {{ __('Assign to User') }}
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
            @foreach ($leads as $lead)
                <tr>
                    <td><input type="checkbox" class="lead-checkbox" data-id="{{ $lead['id'] }}"></td>
                    <td><a href="{{ route('lead.view', $lead['id']) }}">{{ $lead['name'] }}</a></td>
                    <td>{{ $lead['email'] }}</td>
                    <td><a href="tel:{{ $lead['phone_no'] }}">{{ $lead['phone_no'] }}</a></td>
<td>
    @if ($lead['lead_type'] == 1)
        {{ __('Buy') }}
    @elseif ($lead['lead_type'] == 2)
        {{ __('Rent') }}
    @else
        {{ __('N/A') }}
    @endif
</td>
                    <td>{{ $lead->project->title ?? 'N/A' }}</td>
                    <td>{{ $lead->budget->name ?? 'N/A' }}</td>
                    <td>{{ $lead['requirements'] ?? 'N/A' }}</td>
                    <td>{{ $lead->source->name ?? 'N/A' }}</td>
                    <td> {{$lead->user->name ?? 'N/A' }} </td>
                    <td>{{ $lead['created_at'] }}</td>
                    <td>{{ $lead['updated_at'] }}</td>
                    <td>
                        <a href="{{ route('lead.edit', $lead['id']) }}" class="btn btn-sm btn-warning">
                            <i class="ti ti-pencil"></i>
                        </a>
                        <form action="{{ route('lead.destroy', $lead['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
            @endif
        </div>
    </div>
    
<!-- Modal for assigning selected leads to a user -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">{{ __('Assign Leads to User') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignForm" action="{{ route('lead.assign') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="userSelect">{{ __('Select User') }}</label>
                        <select name="user_id" id="userSelect" class="form-control" required>
                            <option value="" disabled selected>{{ __('Choose a user') }}</option>
                            @foreach($ulist as $user)
                                <option value="{{ $user->user_id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="hidden" name="lead_ids[]" id="leadIdsInput">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Assign') }}</button>
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

@endsection


