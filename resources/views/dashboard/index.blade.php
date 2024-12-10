@extends('layouts.admin')
@push('script-page')
@endpush
@php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Dashboard')}}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Dashboard')}}</h5>
    </div>
@endsection
@section('breadcrumb')
@endsection
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if(\Auth::user()->type=='company')
        <div class="row">
            @if($data['pipelines']<=0)
                <div class="col-3">
                    <div class="alert alert-danger">
                        {{__('Please add constant pipeline.')}} <a href="{{route('pipeline.index')}}"><b class="text-white">{{__('click here')}}</b></a>
                    </div>
                </div>
            @endif
            @if($data['leadStages']<=0)
                <div class="col-3">
                    <div class="alert alert-danger">
                        {{__('Please add constant lead stage.')}} <a href="{{route('leadStage.index')}}"><b class="text-white">{{__('click here')}}</b></a>
                    </div>
                </div>
            @endif
            @if($data['dealStages']<=0)
                <div class="col-3">
                    <div class="alert alert-danger">
                        {{__('Please add constant deal stage.')}} <a href="{{route('dealStage.index')}}"><b class="text-white">{{__('click here')}}</b></a>
                    </div>
                </div>
            @endif
            @if($data['projectStages']<=0)
                <div class="col-3">
                    <div class="alert alert-danger">
                        {{__('Please add constant project stage.')}} <a href="{{route('projectStage.index')}}"><b class="text-white">{{__('click here')}}</b></a>
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="row">
        <!-- [ sample-page ] start -->
    
        @if(\Auth::user()->type=='company')
            <div class="col-lg-4 col-md-6 dashboard-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-success">
                                        <i class="ti ti-users"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted">{{ __('Total') }}</small>
                                        <h6 class="m-0">{{ __('Employees') }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end" style="display:block!important;">
                                <h4 class="m-0" >{{$data['totalEmployee']}}</h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee')
            <div class="col-lg-4 col-md-12 dashboard-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mb-3 mb-sm-0">
                                <div class="d-flex align-items-center">
                                    <div class="theme-avtar bg-danger">
                                        <i class="ti ti-list-check"></i>
                                    </div>
                                    <div class="ms-3">
                                        <small class="text-muted">{{ __('Total') }}</small>
                                        <h6 class="m-0">{{ __('Projects') }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end" style="display:block!important;">
                                <h4 class="m-0">{{$data['totalProject']}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
      
        @if(\Auth::user()->type=='company' || \Auth::user()->type=='employee')
        <div class="col-lg-4 col-md-12 dashboard-card">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mb-3 mb-sm-0">
                            <div class="d-flex align-items-center">
                                <div class="theme-avtar bg-dark">
                                    <i class="ti ti-report-money"></i>
                                </div>
                                <div class="ms-3">
                                    <small class="text-muted">{{ __('Total') }}</small>
                                    <h6 class="m-0">{{ __('Lead') }}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end" style="display:block!important;">
                            <h4 class="m-0">{{$data['totalLead']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
<div class="col-lg-6 col-md-12 dashboard-card">
            <div class="card">
                <div class="card-body">
                           <canvas id="leadsPieChart" width="400" height="400"></canvas>

                </div>
            </div>
            </div>

      
      <div class="col-lg-6 col-md-12 dashboard-card">
            <div class="card">
                <div class="card-body">
    <canvas id="leadsUserPieChart" width="400" height="400"></canvas>

                </div>
            </div>
            </div>
            
            
              <div class="col-lg-6 col-md-12 dashboard-card">
            <div class="card">
                <div class="card-body">
    <canvas id="leadsSourceBarChart" width="400" height="400"></canvas>

                </div>
            </div>
            </div>
            
              <div class="col-lg-6 col-md-12 dashboard-card">
            <div class="card">
                <div class="card-body">
    <canvas id="leadsProjectBarChart" width="400" height="400"></canvas>

                </div>
            </div>
            </div>

      
       
        @if(\Auth::user()->type=='employee')
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('Mark Attendance') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 float-right border-right">
                                {{Form::open(array('route'=>array('employee.attendance'),'method'=>'post'))}}
                                @if(empty($data['employeeAttendance']) || $data['employeeAttendance']->clock_out != '00:00:00')
                                    {{Form::submit(__('CLOCK IN'),array('class'=>'btn btn-success btn-sm','name'=>'in','value'=>'0','id'=>'clock_in'))}}
                                @else
                                    {{Form::submit(__('CLOCK IN'),array('class'=>'btn btn-success btn-sm disabled','disabled','name'=>'in','value'=>'0','id'=>'clock_in'))}}
                                @endif
                                {{Form::close()}}
                            </div>
                            <div class="col-md-6 float-left">
                                @if(!empty($data['employeeAttendance']) && $data['employeeAttendance']->clock_out == '00:00:00')
                                    {{Form::model($data['employeeAttendance'],array('route'=>array('attendance.update',$data['employeeAttendance']->id),'method' => 'PUT')) }}
                                    {{Form::submit(__('CLOCK OUT'),array('class'=>'btn btn-danger btn-sm','name'=>'out','value'=>'1','id'=>'clock_out'))}}
                                @else
                                    {{Form::submit(__('CLOCK OUT'),array('class'=>'btn btn-danger btn-sm disabled','name'=>'out','disabled','value'=>'1','id'=>'clock_out'))}}
                                @endif
                                {{Form::close()}}
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        @endif


    

        <div class="card">
            <div class="card-header" style ="margin-left: -12px;">
                <h5>{{ __('Goals') }}</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($data['goals'] as $goal)
                        @php
                            $data       = $goal->target($goal->goal_type,$goal->from,$goal->to,$goal->amount);
                            $total      = $data['total'];
                            $percentage = $data['percentage'];
                        @endphp
                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"> {{$goal->name}}</h6>
                                </div>
                                <div class="card-body ">
                                    <div class="flex-fill text-limit">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="progress-text mb-1 text-sm d-block text-limit">{{\Auth::user()->priceFormat($total).' of '. \Auth::user()->priceFormat($goal->amount)}}</h6>
                                            </div>
                                            <div class="col-auto text-end">
                                                {{ number_format($percentage, 2, '.', '')}}%
                                            </div>
                                        </div>
                                        <div class="progress progress-xs mb-0">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{number_format($percentage , 2, '.', '')}}" aria-valuemin="0" aria-valuemax="100" style="width: {{number_format($percentage , 2, '.', '')}}%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="form-control-label">{{__('Type')}}:</span>
                                                </div>
                                                <div class="col text-end">
                                                    {{ __(\App\Models\Goal::$goalType[$goal->goal_type]) }}
                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <span class="form-control-label">{{__('Duration')}}:</span>
                                                </div>
                                                <div class="col-auto text-end">
                                                    {{$goal->from .' To '.$goal->to}}
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>


@endsection

@push('script-page')
@if(\Auth::user()->type == 'company')

<script>
(function () {
    var options = {
        series: [{{ $storage_limit }}],
        chart: {
            height: 350,
            type: 'radialBar',
            offsetY: -20,
            sparkline: {
                enabled: true
            }
        },
        plotOptions: {
            radialBar: {
                startAngle: -90,
                endAngle: 90,
                track: {
                    background: "#e7e7e7",
                    strokeWidth: '97%',
                    margin: 5, // margin is in pixels
                },
                dataLabels: {
                    name: {
                        show: true
                    },
                    value: {
                        offsetY: -50,
                        fontSize: '20px'
                    }
                }
            }
        },
        grid: {
            padding: {
                top: -10
            }
        },
        colors: ["#6FD943"],
        labels: ['Used'],
    };
    var chart = new ApexCharts(document.querySelector("#device-chart"), options);
    chart.render();
})();


function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

</script>
<script>
    // Data from the controller
    var leadsData = @json($data['leadsCount']);

    // Extract labels and data for the chart
    var labels = leadsData.map(item => item.status);
    var data = leadsData.map(item => parseInt(item.count));

    // Generate random colors for each pie slice
    var backgroundColors = data.map(() => getRandomColor());

    // Create pie chart
    var ctx = document.getElementById('leadsPieChart').getContext('2d');
    var leadsPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,  // Status labels
            datasets: [{
                label: 'Lead Status Distribution',
                data: data,  // Lead count
                backgroundColor: backgroundColors,  // Random pie slice colors
                borderColor: '#fff',
                borderWidth: 1
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
            }
        }
    });
</script>
    
<script>
    // Data from the controller
    var leadsData = @json($data['leadsUserCount']);

    // Extract labels (user names) and data (lead count)
    var labels = leadsData.map(item => item.name);  // User names
    var data = leadsData.map(item => parseInt(item.count));  // Lead count per user

    // Generate random colors for each pie slice
    var backgroundColors = data.map(() => getRandomColor());

    // Create pie chart
    var ctx = document.getElementById('leadsUserPieChart').getContext('2d');
    var leadsPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,  // User names
            datasets: [{
                label: 'User-wise Lead Distribution',
                data: data,  // Lead count per user
                backgroundColor: backgroundColors,  // Random pie slice colors
                borderColor: '#fff',
                borderWidth: 1
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
            }
        }
    });
</script>
    
<script>
    // Data from the controller
    var leadsData = @json($data['leadsSourceCount']);

    // Extract labels (source names) and data (lead count)
    var labels = leadsData.map(item => item.name);  // Source names
    var data = leadsData.map(item => parseInt(item.count));  // Lead count per source

    // Generate random colors for each bar
    var backgroundColors = data.map(() => getRandomColor());
    var borderColors = data.map(() => getRandomColor());

    // Create bar chart
    var ctx = document.getElementById('leadsSourceBarChart').getContext('2d');
    var leadsBarChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
            labels: labels,  // Source names
            datasets: [{
                label: 'Lead Count by Source',
                data: data,  // Lead count per source
                backgroundColor: backgroundColors,  // Random bar colors
                borderColor: borderColors,  // Random border colors for bars
                borderWidth: 1  // Border width for bars
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,  // Start the y-axis from zero
                }
            },
            plugins: {
                legend: {
                    display: false,  // Hide legend
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Leads: ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>


<script>
    // Data from the controller
    var leadsData = @json($data['leadsProjectCount']);

    // Extract labels (project names) and data (lead count)
    var labels = leadsData.map(item => item.title);  // Project names
    var data = leadsData.map(item => parseInt(item.count));  // Lead count per project

    // Generate random colors for each bar
    var backgroundColors = data.map(() => getRandomColor());
    var borderColors = data.map(() => getRandomColor());

    // Create bar chart
    var ctx = document.getElementById('leadsProjectBarChart').getContext('2d');
    var leadsBarChart = new Chart(ctx, {
        type: 'bar',  // Bar chart type
        data: {
            labels: labels,  // Project names
            datasets: [{
                label: 'Lead Count by Project',
                data: data,  // Lead count per project
                backgroundColor: backgroundColors,  // Random bar colors
                borderColor: borderColors,  // Random border colors for bars
                borderWidth: 1  // Border width for bars
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,  // Start the y-axis from zero
                }
            },
            plugins: {
                legend: {
                    display: false,  // Hide legend
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return 'Leads: ' + tooltipItem.raw;
                        }
                    }
                }
            }
        }
    });
</script>



@endif
@endpush

