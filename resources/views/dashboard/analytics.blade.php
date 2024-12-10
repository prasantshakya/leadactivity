@extends('layouts.admin')

@push('script-page')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp

@section('page-title')
    {{ __('Dashboard') }}
@endsection
@section('title')
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('My Dashboard') }}</h5>
</div>
@endsection
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container">
    <div class="row">
        <!-- Analytics Header -->
        <div class="analytics-header">
            <h1>Leads Analytics</h1>
        </div>
        <!-- Summary Cards -->
   <div class="col-lg-3 col-md-6 dashboard-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-warning">
                                        <i class="ti ti-click"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="m-0">Total Leads</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end">
                                <h4 class="m-0">{{ $data['totalLeadCount'] }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Summary Cards -->
<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-danger">
                            <i class="ti ti-list"></i> <!-- List icon for Total Leads -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Total Leads</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.allleads')}}">{{ $data['totalLeadCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-primary">
                            <i class="ti ti-plus"></i> <!-- Plus icon for Fresh Leads -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Fresh</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.freshleads')}}">{{ $data['pendingCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-secondary">
                            <i class="ti ti-phone"></i> <!-- Phone icon for Call Back -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Call Back</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.callback')}}">{{ $data['CallbackCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-warning">
                            <i class="ti ti-heart"></i> <!-- Heart icon for Interested Leads -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Interested</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.interested')}}">{{ $data['interestedCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-info">
                            <i class="ti ti-thumb-down"></i> <!-- Thumbs Down icon for Not Interested -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Not Interested</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.notinterested')}}">{{ $data['NotinterestedCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-light">
                            <i class="ti ti-building"></i> <!-- Location Pin icon for Site Visit -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Site Visit</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.sitevisit')}}">{{ $data['SitevisitCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6 dashboard-card">
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mb-3 mb-sm-0">
                    <div class="d-flex align-items-center">
                        <div class="theme-avtar bg-success">
                            <i class="ti ti-check"></i> <!-- Check icon for Closed Won -->
                        </div>
                        <div class="ms-3">
                            <h6 class="m-0">Closed Won</h6>
                        </div>
                    </div>
                </div>
                <div class="col-auto text-end">
                    <h4 class="m-0"><a href="{{route('dashboard.wonleads')}}">{{ $data['WonCount'] }}</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- Feedback Summary and Bar Chart -->
        <div class="row">
            <!-- Feedback Summary Table -->
            <div class="col-md-7 table-container">
           <div class="card mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Status-Wise Lead Distribution</h5>
            <!-- Download Button -->
            <button class="btn btn-success" id="download-table">
                <i class="ti ti-download"></i> Export
            </button>
        </div>
        <br>
        <div class="table-responsive feedback-table">
            <table class="table table-bordered" id="lead-distribution-table">
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>Total</th>
                        <th>Fresh</th>
                        <th>Call Back</th>
                        <th>Interested</th>
                        <th>Won</th>
                        <th>Not Interested</th>
                        <th>Site Visit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['usersdata'] as $user)
                        <tr>
                            <td>{{ $user->userName }}</td>
                            <td>{{ $user->totalLeadCount }}</td>
                            <td><a href="{{ route('dashboard.userleads', ['id' => $user->user_id, 'status' => '0']) }}">{{ $user->pendingCount }}</a></td>
                            <td><a href="{{ route('dashboard.userleads', ['id' => $user->user_id, 'status' => '3']) }}">{{ $user->callbackCount }}</a></td>
                            <td><a href="{{ route('dashboard.userleads', ['id' => $user->user_id, 'status' => '1']) }}">{{ $user->interestedCount }}</a></td>
                            <td><a href="{{ route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '1']) }}">{{ $user->wonCount }}</a></td>
                            <td><a href="{{ route('dashboard.userleads', ['id' => $user->user_id, 'status' => '2']) }}">{{ $user->notInterestedCount }}</a></td>
                            <td><a href="{{ route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus_id' => '7']) }}">{{ $user->siteVisitCount }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

                
            </div>

            <!-- Bar Chart -->
            <div class="col-md-5 chart-container">
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="card-title">Lead Status Distribution</h5>
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Feedback Summary Table -->
            <div class="col-md-7 table-container">
                
<div class="card mb-5">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Call Back Lead Distribution</h5>
            <button class="btn btn-success" id="download-call-table">
                <i class="ti ti-download"></i> Export
            </button>
        </div>
        <br>
        <div class="table-responsive feedback-table">
            <table class="table table-bordered" id="call-distribution-table">
                <thead>
                    <tr>
                        <th>Team</th>
                        <th>Total</th>
                        <th>Not Picked</th>
                        <th>On Request</th>
                        <th>Not Reachable</th>
                        <th>Switch Off</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['userscallbackdata'] as $index => $user)
                        <tr>
                            <td>{{ $user->userName }}</td>
                            <td>{{ $user->totalLeadCount }}</td>
                            <td><a href="{{ route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '8']) }}">{{ $user->notPicked }}</a></td>
                            <td><a href="{{ route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '10']) }}">{{ $user->onRequest }}</a></td>
                            <td><a href="{{ route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '9']) }}">{{ $user->notReachable }}</a></td>
                            <td><a href="{{ route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '11']) }}">{{ $user->switchOff }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
            </div>

            <!-- Bar Chart -->
                <div class="col-md-5 chart-container">
                <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-title">Call Back Lead Distribution</h5>
                    <canvas id="leadStatusChart" width="400" height="400"></canvas>     
                </div>
                </div>
                </div>
                </div>

        <div class="row">
            <!-- Bar Chart Section -->
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-title">Budget-Wise Lead Distribution</h5>
                    <canvas id="budgetChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        
         <div class="row">
            <!-- Bar Chart Section -->
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-title">Budget-Wise Lead Distribution</h5>
        
<table class="table">
    <thead>
        <tr>
            <th>User Name</th>
            @foreach ($data['pivotData'] as $userName => $budgetData)
                @foreach ($budgetData as $budget => $leadCount)
                    <th>{{ $budget }}</th>
                @endforeach
                @break <!-- Ensure budget column headers are only printed once -->
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($data['pivotData'] as $userName => $budgetData)
            <tr>
                <td>{{ $userName }}</td>
                @foreach ($data['pivotData'][$userName] as $budget => $leadCount)
                    <td>{{ $leadCount > 0 ? $leadCount . '' : '0' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>



                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Prepare Budget-Wise Data for Chart.js
    const budgetNames = @json($data['budgetWiseData']->pluck('budgetName'));
    const budgetCounts = @json($data['budgetWiseData']->pluck('totalLeads'));

    // Render Budget-Wise Bar Chart
    const ctxBudget = document.getElementById('budgetChart').getContext('2d');
    new Chart(ctxBudget, {
        type: 'bar',
        data: {
            labels: budgetNames,
            datasets: [{
                label: 'Leads',
                data: budgetCounts,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { title: { display: true, text: 'Budget Name' }},
                y: { beginAtZero: true, title: { display: true, text: 'Number of Leads' }}
            }
        }
    });
</script>

<script>
    // Data passed from the controller
    const leadStatusCounts = {
        pending: @json($data['pendingCount']),
        interested: @json($data['interestedCount']),
        notInterested: @json($data['NotinterestedCount']),
        callback: @json($data['CallbackCount']),
        won: @json($data['WonCount']),
        siteVisit: @json($data['SitevisitCount'])
    };

    // Status names and corresponding IDs
    const statusMap = {
        pending: 0,
        interested: 1,
        "not interested": 2,
        callback: 3,
        won: 1, // Assuming 'won' maps to status_id = 1
        "site visit": 7 // Assuming 'site visit' maps to status_id = 7
    };

    // Substatus IDs for "won" and "site visit"
    const substatusMap = {
        won: 1, // Example substatus_id for 'won'
        "site visit": 7 // Example substatus_id for 'site visit'
    };

    // Data for the Lead Status chart
    const statusNames = Object.keys(statusMap);
    const statusCounts = [
        leadStatusCounts.pending,
        leadStatusCounts.interested,
        leadStatusCounts.notInterested,
        leadStatusCounts.callback,
        leadStatusCounts.won,
        leadStatusCounts.siteVisit
    ];

    // The user ID (example: replace with actual user ID dynamically from the backend)
    const userId = @json(auth()->id());

    // Render the Lead Status Bar Chart using Chart.js
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctxStatus, {
        type: 'bar',
        data: {
            labels: Object.keys(statusMap), // Display status names on the chart
            datasets: [{
                label: 'Lead Counts',
                data: statusCounts,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { title: { display: true, text: 'Lead Status' }},
                y: { beginAtZero: true, title: { display: true, text: 'Number of Leads' }}
            },
            onClick: (e, elements) => {
                // Check if a bar was clicked
                if (elements.length > 0) {
                    const clickedIndex = elements[0].index;
                    const clickedStatus = statusNames[clickedIndex];
                    const lowerCaseStatus = clickedStatus.toLowerCase();

                    // Determine the URL based on the clicked status
                    if (substatusMap[lowerCaseStatus]) {
                        // Navigate to substatus URL
                        const substatusId = substatusMap[lowerCaseStatus];
                        const url = `/leads/substatusgraphleads/${substatusId}`;
                        window.location.href = url;
                    } else if (statusMap[lowerCaseStatus] !== undefined) {
                        // Navigate to status URL
                        const statusId = statusMap[lowerCaseStatus];
                        const url = `/leads/statusleads/${statusId}`;
                        window.location.href = url;
                    }
                }
            }
        }
    });
</script>

<script>
    // Data passed from the controller for feedbacks
    const feedbackNames = @json($data['userscallbackdata']->pluck('userName'));
    const notPickedCounts = @json($data['userscallbackdata']->pluck('notPicked'));
    const onRequestCounts = @json($data['userscallbackdata']->pluck('onRequest'));
    const notReachableCounts = @json($data['userscallbackdata']->pluck('notReachable'));
    const switchOffCounts = @json($data['userscallbackdata']->pluck('switchOff'));

    // Render Feedback Summary Bar Chart using Chart.js
    const ctxFeedback = document.getElementById('feedbackChart').getContext('2d');
    new Chart(ctxFeedback, {
        type: 'bar',
        data: {
            labels: feedbackNames,
            datasets: [
                {
                    label: 'Not Picked',
                    data: notPickedCounts,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'On Request',
                    data: onRequestCounts,
                    backgroundColor: 'rgba(153, 102, 255, 0.7)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Not Reachable',
                    data: notReachableCounts,
                    backgroundColor: 'rgba(255, 159, 64, 0.7)',
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Switch Off',
                    data: switchOffCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Other',
                    data: otherCounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: { enabled: true }
            },
            scales: {
                x: { title: { display: true, text: 'Team' }},
                y: { beginAtZero: true, title: { display: true, text: 'Lead Feedback Count' }}
            }
        }
    });
    
    
    document.getElementById('download-table').addEventListener('click', function () {
    const table = document.getElementById('lead-distribution-table');
    let csvContent = '';
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('th, td');
        const rowData = Array.from(cols).map(col => `"${col.textContent.trim()}"`);
        csvContent += rowData.join(',') + '\n';
    });

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'lead_distribution.csv';
    link.click();
});


    document.getElementById('call-table').addEventListener('click', function () {
    const table = document.getElementById('call-distribution-table');
    let csvContent = '';
    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {
        const cols = row.querySelectorAll('th, td');
        const rowData = Array.from(cols).map(col => `"${col.textContent.trim()}"`);
        csvContent += rowData.join(',') + '\n';
    });

    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = 'lead_distribution.csv';
    link.click();
});

</script>

 <script>
        // Data passed from controller
        const callbackData = @json($data['callbackdata']);
        console.log(callbackData); // Check the structure of the data

        // Extract counts for the pie chart
        const statusCounts = {
            notPicked: callbackData[0].notPicked,
            onRequest: callbackData[0].onRequest,
            notReachable: callbackData[0].notReachable,
            switchOff: callbackData[0].switchOff
        };

        const labels = Object.keys(statusCounts); // ['notPicked', 'onRequest', 'notReachable', 'switchOff']
        const data = Object.values(statusCounts);  // [0, 1, 0, 1]

        // Create the Pie Chart
        const ctx = document.getElementById('leadStatusChart').getContext('2d');
        const leadStatusChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Lead Status Distribution',
                    data: data,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'], // Colors for each segment
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' leads';
                            }
                        }
                    }
                },
                onClick: function(e, elements) {
                    if (elements.length > 0) {
                        const clickedLabel = elements[0].index;
                        const clickedStatus = labels[clickedLabel];

                        let substatusId;
                        if (clickedStatus === 'notPicked') substatusId = 8;
                        if (clickedStatus === 'onRequest') substatusId = 10;
                        if (clickedStatus === 'notReachable') substatusId = 9;
                        if (clickedStatus === 'switchOff') substatusId = 11;

                        const url = `/leads/substatusleads/${substatusId}`;
                        window.location.href = url;
                    }
                }
            }
        });
    </script>
    @endsection
