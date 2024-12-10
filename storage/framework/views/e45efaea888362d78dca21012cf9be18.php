<?php $__env->startPush('script-page'); ?>
<?php $__env->stopPush(); ?>
<?php
$profile=\App\Models\Utility::get_file('uploads/avatar/');
?>
<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Dashboard')); ?></h5>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <?php if(\Auth::user()->type=='company'): ?>
        <div class="row">
            <?php if($data['pipelines']<=0): ?>
                <div class="col-3">
                    <div class="alert alert-danger">
                        <?php echo e(__('Please add constant pipeline.')); ?> <a href="<?php echo e(route('pipeline.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($data['leadStages']<=0): ?>
                <div class="col-3">
                    <div class="alert alert-danger">
                        <?php echo e(__('Please add constant lead stage.')); ?> <a href="<?php echo e(route('leadStage.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($data['dealStages']<=0): ?>
                <div class="col-3">
                    <div class="alert alert-danger">
                        <?php echo e(__('Please add constant deal stage.')); ?> <a href="<?php echo e(route('dealStage.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                    </div>
                </div>
            <?php endif; ?>
            <?php if($data['projectStages']<=0): ?>
                <div class="col-3">
                    <div class="alert alert-danger">
                        <?php echo e(__('Please add constant project stage.')); ?> <a href="<?php echo e(route('projectStage.index')); ?>"><b class="text-white"><?php echo e(__('click here')); ?></b></a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- [ sample-page ] start -->
    
        <?php if(\Auth::user()->type=='company'): ?>
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
                                        <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                        <h6 class="m-0"><?php echo e(__('Employees')); ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end" style="display:block!important;">
                                <h4 class="m-0" ><?php echo e($data['totalEmployee']); ?></h4>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='client' || \Auth::user()->type=='employee'): ?>
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
                                        <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                        <h6 class="m-0"><?php echo e(__('Projects')); ?></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto text-end" style="display:block!important;">
                                <h4 class="m-0"><?php echo e($data['totalProject']); ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
      
        <?php if(\Auth::user()->type=='company' || \Auth::user()->type=='employee'): ?>
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
                                    <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                    <h6 class="m-0"><?php echo e(__('Lead')); ?></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto text-end" style="display:block!important;">
                            <h4 class="m-0"><?php echo e($data['totalLead']); ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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

      
       
        <?php if(\Auth::user()->type=='employee'): ?>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('Mark Attendance')); ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-6 float-right border-right">
                                <?php echo e(Form::open(array('route'=>array('employee.attendance'),'method'=>'post'))); ?>

                                <?php if(empty($data['employeeAttendance']) || $data['employeeAttendance']->clock_out != '00:00:00'): ?>
                                    <?php echo e(Form::submit(__('CLOCK IN'),array('class'=>'btn btn-success btn-sm','name'=>'in','value'=>'0','id'=>'clock_in'))); ?>

                                <?php else: ?>
                                    <?php echo e(Form::submit(__('CLOCK IN'),array('class'=>'btn btn-success btn-sm disabled','disabled','name'=>'in','value'=>'0','id'=>'clock_in'))); ?>

                                <?php endif; ?>
                                <?php echo e(Form::close()); ?>

                            </div>
                            <div class="col-md-6 float-left">
                                <?php if(!empty($data['employeeAttendance']) && $data['employeeAttendance']->clock_out == '00:00:00'): ?>
                                    <?php echo e(Form::model($data['employeeAttendance'],array('route'=>array('attendance.update',$data['employeeAttendance']->id),'method' => 'PUT'))); ?>

                                    <?php echo e(Form::submit(__('CLOCK OUT'),array('class'=>'btn btn-danger btn-sm','name'=>'out','value'=>'1','id'=>'clock_out'))); ?>

                                <?php else: ?>
                                    <?php echo e(Form::submit(__('CLOCK OUT'),array('class'=>'btn btn-danger btn-sm disabled','name'=>'out','disabled','value'=>'1','id'=>'clock_out'))); ?>

                                <?php endif; ?>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        <?php endif; ?>


    

        <div class="card">
            <div class="card-header" style ="margin-left: -12px;">
                <h5><?php echo e(__('Goals')); ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php $__currentLoopData = $data['goals']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $data       = $goal->target($goal->goal_type,$goal->from,$goal->to,$goal->amount);
                            $total      = $data['total'];
                            $percentage = $data['percentage'];
                        ?>
                        <div class="col-xl-3">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0"> <?php echo e($goal->name); ?></h6>
                                </div>
                                <div class="card-body ">
                                    <div class="flex-fill text-limit">
                                        <div class="row">
                                            <div class="col">
                                                <h6 class="progress-text mb-1 text-sm d-block text-limit"><?php echo e(\Auth::user()->priceFormat($total).' of '. \Auth::user()->priceFormat($goal->amount)); ?></h6>
                                            </div>
                                            <div class="col-auto text-end">
                                                <?php echo e(number_format($percentage, 2, '.', '')); ?>%
                                            </div>
                                        </div>
                                        <div class="progress progress-xs mb-0">
                                            <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo e(number_format($percentage , 2, '.', '')); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e(number_format($percentage , 2, '.', '')); ?>%;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer py-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <span class="form-control-label"><?php echo e(__('Type')); ?>:</span>
                                                </div>
                                                <div class="col text-end">
                                                    <?php echo e(__(\App\Models\Goal::$goalType[$goal->goal_type])); ?>

                                                </div>
                                            </div>
                                        </li>
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <span class="form-control-label"><?php echo e(__('Duration')); ?>:</span>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <?php echo e($goal->from .' To '.$goal->to); ?>

                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
        <!-- [ sample-page ] end -->
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
<?php if(\Auth::user()->type == 'company'): ?>

<script>
(function () {
    var options = {
        series: [<?php echo e($storage_limit); ?>],
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
    var leadsData = <?php echo json_encode($data['leadsCount'], 15, 512) ?>;

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
    var leadsData = <?php echo json_encode($data['leadsUserCount'], 15, 512) ?>;

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
    var leadsData = <?php echo json_encode($data['leadsSourceCount'], 15, 512) ?>;

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
    var leadsData = <?php echo json_encode($data['leadsProjectCount'], 15, 512) ?>;

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



<?php endif; ?>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/dashboard/index.blade.php ENDPATH**/ ?>