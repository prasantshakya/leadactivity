@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Budgets') }}
@endsection

@section('title')
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Budget') }}</h5>
</div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Budget') }}</li>
@endsection

@section('action-btn')
    <!-- Button to trigger Create modal -->
    <a href="#" class="btn btn-sm btn-primary btn-icon m-1" 
        data-bs-toggle="modal" data-bs-target="#createBudgetModal" 
        data-bs-original-title="{{ __('Create') }}">
        <span class="text-white">
            <i class="ti ti-plus text-white"></i>
        </span>
    </a>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Budgets') }}</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($budgets as $budget)
                                <tr>
                                    <td>{{ $budget->id }}</td>
                                    <td>{{ $budget->name }}</td>
                                    <td>{{ $budget->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                 

                                        <form action="{{ route('budget.delete', $budget->id) }}" method="POST" 
                                            style="display:inline-block;" 
                                            onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                data-bs-toggle="tooltip" 
                                                data-bs-original-title="{{ __('Delete') }}">
                                                {{ __('Delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Creating Budget -->
    <div class="modal fade" id="createBudgetModal" tabindex="-1" aria-labelledby="createBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBudgetModalLabel">{{ __('Create New Budget') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('budget.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="budget-name" class="form-label">{{ __('Budget Name') }}</label>
                            <input type="text" name="name" id="budget-name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Budget -->
    <div class="modal fade" id="editBudgetModal" tabindex="-1" aria-labelledby="editBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBudgetModalLabel">{{ __('Edit Budget') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editBudgetForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit-budget-name" class="form-label">{{ __('Budget Name') }}</label>
                            <input type="text" name="name" id="edit-budget-name" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
   document.addEventListener('DOMContentLoaded', function () {
    const editBudgetBtns = document.querySelectorAll('.editBudgetBtn');
    
    editBudgetBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const budgetId = this.getAttribute('data-id');
            const budgetName = this.getAttribute('data-name');
            
            // Debug: Ensure the correct values are being captured
            console.log('Budget ID:', budgetId);
            console.log('Budget Name:', budgetName);

            // Set the action URL for the form dynamically
            const editForm = document.getElementById('editBudgetForm');
            editForm.action = `/budgets/${budgetId}`; // Adjust this URL as needed for your routes

            // Set the budget name in the input field
            const nameInput = document.getElementById('edit-budget-name');
            nameInput.value = budgetName; // Set the name value to the form input
        });
    });
});

</script>
@endsection
