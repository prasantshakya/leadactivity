<?php $__env->startPush('script-page'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->stopPush(); ?>

<?php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('My Dashboard')); ?></h5>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
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
                                <h4 class="m-0"><?php echo e($data['totalLeadCount']); ?></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.allleads')); ?>"><?php echo e($data['totalLeadCount']); ?></a></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.freshleads')); ?>"><?php echo e($data['pendingCount']); ?></a></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.callback')); ?>"><?php echo e($data['CallbackCount']); ?></a></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.interested')); ?>"><?php echo e($data['interestedCount']); ?></a></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.notinterested')); ?>"><?php echo e($data['NotinterestedCount']); ?></a></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.sitevisit')); ?>"><?php echo e($data['SitevisitCount']); ?></a></h4>
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
                    <h4 class="m-0"><a href="<?php echo e(route('dashboard.wonleads')); ?>"><?php echo e($data['WonCount']); ?></a></h4>
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
                    <?php $__currentLoopData = $data['usersdata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($user->userName); ?></td>
                            <td><?php echo e($user->totalLeadCount); ?></td>
                            <td><a href="<?php echo e(route('dashboard.userleads', ['id' => $user->user_id, 'status' => '0'])); ?>"><?php echo e($user->pendingCount); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.userleads', ['id' => $user->user_id, 'status' => '3'])); ?>"><?php echo e($user->callbackCount); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.userleads', ['id' => $user->user_id, 'status' => '1'])); ?>"><?php echo e($user->interestedCount); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '1'])); ?>"><?php echo e($user->wonCount); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.userleads', ['id' => $user->user_id, 'status' => '2'])); ?>"><?php echo e($user->notInterestedCount); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus_id' => '7'])); ?>"><?php echo e($user->siteVisitCount); ?></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php $__currentLoopData = $data['userscallbackdata']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($user->userName); ?></td>
                            <td><?php echo e($user->totalLeadCount); ?></td>
                            <td><a href="<?php echo e(route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '8'])); ?>"><?php echo e($user->notPicked); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '10'])); ?>"><?php echo e($user->onRequest); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '9'])); ?>"><?php echo e($user->notReachable); ?></a></td>
                            <td><a href="<?php echo e(route('dashboard.substatusLeads', ['id' => $user->user_id, 'substatus' => '11'])); ?>"><?php echo e($user->switchOff); ?></a></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
            <?php $__currentLoopData = $data['pivotData']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userName => $budgetData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $budgetData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget => $leadCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <th><?php echo e($budget); ?></th>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php break; ?> <!-- Ensure budget column headers are only printed once -->
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $data['pivotData']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userName => $budgetData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($userName); ?></td>
                <?php $__currentLoopData = $data['pivotData'][$userName]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $budget => $leadCount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <td><?php echo e($leadCount > 0 ? $leadCount . '' : '0'); ?></td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>



                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Prepare Budget-Wise Data for Chart.js
    const budgetNames = <?php echo json_encode($data['budgetWiseData']->pluck('budgetName'), 15, 512) ?>;
    const budgetCounts = <?php echo json_encode($data['budgetWiseData']->pluck('totalLeads'), 15, 512) ?>;

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
        pending: <?php echo json_encode($data['pendingCount'], 15, 512) ?>,
        interested: <?php echo json_encode($data['interestedCount'], 15, 512) ?>,
        notInterested: <?php echo json_encode($data['NotinterestedCount'], 15, 512) ?>,
        callback: <?php echo json_encode($data['CallbackCount'], 15, 512) ?>,
        won: <?php echo json_encode($data['WonCount'], 15, 512) ?>,
        siteVisit: <?php echo json_encode($data['SitevisitCount'], 15, 512) ?>
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
    const userId = <?php echo json_encode(auth()->id(), 15, 512) ?>;

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
    const feedbackNames = <?php echo json_encode($data['userscallbackdata']->pluck('userName'), 15, 512) ?>;
    const notPickedCounts = <?php echo json_encode($data['userscallbackdata']->pluck('notPicked'), 15, 512) ?>;
    const onRequestCounts = <?php echo json_encode($data['userscallbackdata']->pluck('onRequest'), 15, 512) ?>;
    const notReachableCounts = <?php echo json_encode($data['userscallbackdata']->pluck('notReachable'), 15, 512) ?>;
    const switchOffCounts = <?php echo json_encode($data['userscallbackdata']->pluck('switchOff'), 15, 512) ?>;

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
        const callbackData = <?php echo json_encode($data['callbackdata'], 15, 512) ?>;
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
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/dashboard/analytics.blade.php ENDPATH**/ ?>