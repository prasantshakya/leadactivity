<?php
    $profile = \App\Models\Utility::get_file('uploads/avatar/');
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
<div class="d-inline-block">
    <h5 class="h4 d-inline-block font-weight-400 mb-0"><?php echo e(__('Dashboard')); ?></h5>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                <h3><a class="alink" href="<?php echo e(route('dashboard.allleads')); ?>"><?php echo e($data['totalLeadCount']); ?></a></h3>
            </div>
            <div class="card bg-primary text-white">
                <h5>Fresh</h5>
                <h3><a class="alink" href="<?php echo e(route('dashboard.freshleads')); ?>"><?php echo e($data['pendingCount']); ?></a></h3>
            </div>
            <div class="card bg-secondary text-white">
                <h5>Call Back</h5>
                <h3><a class="alink" href="<?php echo e(route('dashboard.callback')); ?>"><?php echo e($data['callbackCount']); ?></a></h3>
            </div>
            <div class="card bg-warning text-dark">
                <h5>Interested</h5>
                <h3><a class="alink" href="<?php echo e(route('dashboard.interested')); ?>"><?php echo e($data['interestedCount']); ?></a></h3>
            </div>
            <div class="card bg-info text-white">
                <h5>Not Interested</h5>
                <h3><a class="alink" href="<?php echo e(route('dashboard.notinterested')); ?>"><?php echo e($data['notInterestedCount']); ?></a></h3>
            </div>
            <div class="card bg-light text-dark">
                <h5>Site Visit</h5>
                <h3><a class="alink" href="<?php echo e(route('dashboard.sitevisit')); ?>"><?php echo e($data['siteVisitCount']); ?></a></h3>
            </div>
            <div class="card bg-success text-white">
                <h5>Closed Won</h5>
                <h3><a class="alink" href="<?php echo e(route('dashboard.wonleads')); ?>"><?php echo e($data['wonCount']); ?></a></h3>
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
    const budgetWiseData = <?php echo json_encode($data['budgetWiseData'], 15, 512) ?>;
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
    const leadsSourceCount = <?php echo json_encode($data['leadsSourceCount'], 15, 512) ?>;
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
    const leadsStatusCount = <?php echo json_encode($data['leadsSourceCount'], 15, 512) ?>;
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/pspace/leadactpro.in/resources/views/dashboard/useranalytics.blade.php ENDPATH**/ ?>