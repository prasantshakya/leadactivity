@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Booking List</h2>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
<div class="table-responsive">
    <table class="table custom-table" id="leadTable">
              <thead>
            <tr>
                <th>ID</th>
                <th>Lead Name</th>
                <th>Date of Booking</th>
                <th>Project Name</th>
                <th>Developer Name</th>
                <th>Source of Funds</th>
                <th>Unit Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->lead->name ?? 'N/A' }}</td>
                    <td>{{ $booking->date_of_booking }}</td>
                    <td>{{ $booking->project->name ?? 'N/A' }}</td>
                    <td>{{ $booking->developer_name }}</td>
<td>
    @if ($booking->source_of_funds == 1)
        Self Loan Process
    @else
        {{ $booking->source_of_funds }}
    @endif
</td>
                    <td>{{ $booking->unit_number }}</td>
                    
                </tr>
            @empty
                <tr>
                    <td colspan="9">No bookings found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $bookings->links() }}
</div></div>
@endsection
