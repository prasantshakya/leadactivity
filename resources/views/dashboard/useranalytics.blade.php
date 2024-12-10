@extends('layouts.admin')

@php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
@endphp

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('title')
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0">{{ __('Dashboard') }}</h5>
</div>
@endsection

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="container">
    <div class="row">
        <!-- Analytics Header -->
        <div class="analytics-header">
            <h1>Contacts Analytics</h1>
        </div>

        <!-- Summary Cards -->
        <div class="card-summary">
            <div class="card bg-danger text-white">
                <h5>Total Leads</h5>
                <h3><a class="alink" href="{{route('dashboard.allleads')}}">{{ $data['totalLeadCount'] }}</a></h3>
            </div>
            <div class="card bg-primary text-white">
                <h5>Fresh</h5>
                <h3><a class="alink" href="{{route('dashboard.freshleads')}}">{{ $data['pendingCount'] }}</a></h3>
            </div>
            <div class="card bg-secondary text-white">
                <h5>Call Back</h5>
                <h3><a class="alink" href="{{route('dashboard.callback')}}">{{ $data['callbackCount'] }}</a></h3>
            </div>
            <div class="card bg-warning text-dark">
                <h5>Interested</h5>
                <h3><a class="alink" href="{{route('dashboard.interested')}}">{{ $data['interestedCount'] }}</a></h3>
            </div>
            <div class="card bg-info text-white">
                <h5>Not Interested</h5>
                <h3><a class="alink" href="{{route('dashboard.notinterested')}}">{{ $data['notInterestedCount'] }}</a></h3>
            </div>
            <div class="card bg-light text-dark">
                <h5>Site Visit</h5>
                <h3><a class="alink" href="{{route('dashboard.sitevisit')}}">{{ $data['siteVisitCount'] }}</a></h3>
            </div>
            <div class="card bg-success text-white">
                <h5>Closed Won</h5>
                <h3><a class="alink" href="{{route('dashboard.wonleads')}}">{{ $data['wonCount'] }}</a></h3>
            </div>
        </div>

        <!-- Feedback Summary and Bar Chart -->
        <div class="row">
            <!-- Feedback Summary Table -->
       

            <!-- Bar Chart -->
            <div class="col-md-6 chart-container">
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="card-title">Lead Status Distribution</h5>
                        <canvas id="statusChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
      
            <!-- Source Chart -->
            <div class="col-md-6 table-container">
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="card-title">Status wise Lead</h5>
                        <br>
                        <canvas id="sourceChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>

           
        </div>

        <div class="row">
            <!-- Budget-Wise Lead Distribution -->
            <div class="card mb-5">
                <div class="card-body">
                    <h5 class="card-title">Budget-Wise Lead Distribution</h5>
                    <canvas id="budgetChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Budget-Wise Lead Chart
    const budgetWiseData = @json($data['budgetWiseData']);
    const budgetLabels = budgetWiseData.map(item => item.budgetName);
    const budgetData = budgetWiseData.map(item => item.totalLeads);

    const budgetCtx = document.getElementById('budgetChart').getContext('2d');
    const budgetChart = new Chart(budgetCtx, {
        type: 'bar',
        data: {
            labels: budgetLabels,
            datasets: [{
                label: 'Total Leads',
                data: budgetData,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Source-Wise Lead Chart
    const leadsSourceCount = @json($data['leadsSourceCount']);
    const sourceLabels = leadsSourceCount.map(item => item.sourceName);
    const sourceData = leadsSourceCount.map(item => item.count);

    const sourceCtx = document.getElementById('sourceChart').getContext('2d');
    const sourceChart = new Chart(sourceCtx, {
        type: 'bar',
        data: {
            labels: sourceLabels,
            datasets: [{
                label: 'Lead Count',
                data: sourceData,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Status-Wise Lead Chart
    const leadsStatusCount = @json($data['leadsSourceCount']);
    const statusLabels = leadsStatusCount.map(item => item.sourceName);
    const statusData = leadsStatusCount.map(item => item.count);

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(statusCtx, {
        type: 'bar',
        data: {
            labels: statusLabels,
            datasets: [{
                label: 'Lead Count',
                data: statusData,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

@endsection
