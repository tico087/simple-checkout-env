<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-page'); ?>
    <script>
        $(document).ready(function(){
            $('#filter-date').change(function(){
                var selectedDate = $(this).val();
                $.ajax({
                    url: '<?php echo e(route("dashboard.filterByDate")); ?>',
                    method: 'POST',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        "date": selectedDate
                    },
                    success: function(response) {
                        $('#pos-table tbody').html(response.html);
                        $('#rendahoje').text(response.rendahoje);

                    }
                });
            });
        });

        $(document).ready(function(){
            $('#filter-today').click(function(){
                var currentDate = new Date().toISOString().slice(0, 10);
                $.ajax({
                    url: '<?php echo e(route("dashboard.filterByToday")); ?>',
                    method: 'POST',
                    data: {
                        "_token": "<?php echo e(csrf_token()); ?>",
                        "date": currentDate
                    },
                    success: function(response) {
                        $('#pos-table tbody').html(response.html);
                        $('#rendahoje').text(response.rendahoje);
                    }
                });
            });
            $('#filter-today').click();
        });        


        (function () {
            var options = {
                chart: {
                    height: 180,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: 'Refferal',
                    data:<?php echo json_encode(array_values($home_data['task_overview'])); ?>

                },],
                xaxis: {
                    categories:<?php echo json_encode(array_keys($home_data['task_overview'])); ?>,
                },
                colors: ['#3ec9d6'],
                fill: {
                    type: 'solid',
                },
                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                },
            };
            var chart = new ApexCharts(document.querySelector("#task_overview"), options);
            chart.render();
        })();

        (function () {
            var options = {
                chart: {
                    height: 300,
                    type: 'bar',
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 10,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                colors: ["#3ec9d6"],
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                grid: {
                    strokeDashArray: 4,
                },
                series: [{
                    data: <?php echo json_encode(array_values($home_data['timesheet_logged'])); ?>

                }],
                xaxis: {
                    categories: <?php echo json_encode(array_keys($home_data['timesheet_logged'])); ?>,
                },
            };
            var chart = new ApexCharts(document.querySelector("#timesheet_logged"), options);
            chart.render();
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item">Dashboard POS</li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php
    $rendahoje = 0;
    $rendames = 0;

?>

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <input type="date" id="filter-date" class="form-control">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group align-items-center">
            <button id="filter-today" class="btn btn-sm btn-primary">Hoje</button>
        </div>
    </div>
</div>

<?php $__empty_1 = true; $__currentLoopData = $posPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $rendahoje += floatval($posPayment->posPayment->discount_amount);
    ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="7" class="text-center text-dark"><p><?php echo e(__('No Data Found')); ?></p></td>
    </tr>
<?php endif; ?>

<?php $__empty_1 = true; $__currentLoopData = $posPayments2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posPayment2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
            $rendames += floatval($posPayment2->posPayment->discount_amount);

    ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr>
        <td colspan="7" class="text-center text-dark"><p><?php echo e(__('No Data Found')); ?></p></td>
    </tr>
<?php endif; ?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-3 col-3 my-2">
                        <div class="d-flex align-items-start mb-2">
                            <div class="theme-avtar bg-primary">
                                <i class="ti ti-report-money"></i>
                            </div>
                            <div class="ms-2">
                                <p class="text-muted text-sm mb-0">Renda Hoje </p>
                                <h4 class="mb-0 text-success" id="rendahoje"><?php echo e(Auth::user()->priceFormat($rendahoje)); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3 my-2">
                        <div class="d-flex align-items-start mb-2">
                            <div class="theme-avtar bg-info">
                                <i class="ti ti-file-invoice"></i>
                            </div>
                            <div class="ms-2">
                                <p class="text-muted text-sm mb-0">Despesa Hoje </p>
                                <h4 class="mb-0 text-info">R$0.00</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3 my-2">
                        <div class="d-flex align-items-start mb-2">
                            <div class="theme-avtar bg-warning">
                                <i class="ti ti-report-money"></i>
                            </div>
                            <div class="ms-2">
                                <p class="text-muted text-sm mb-0">Renda Este Mês </p>
                                <h4 class="mb-0 text-warning"><?php echo e(Auth::user()->priceFormat($rendames)); ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-3 my-2">
                        <div class="d-flex align-items-start mb-2">
                            <div class="theme-avtar bg-danger">
                                <i class="ti ti-file-invoice"></i>
                            </div>
                            <div class="ms-2">
                                <p class="text-muted text-sm mb-0">Despesa Neste Mês </p>
                                <h4 class="mb-0 text-danger">R$0.00</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table datatable p-3" style="background: white; border-radius:10px;" id="pos-table">
    <thead>
        <tr>
            <th><?php echo e(__('POS ID')); ?></th>
            <th><?php echo e(__('Date')); ?></th>
            <th><?php echo e(__('Sub Total')); ?></th>
            <th><?php echo e(__('Discount')); ?></th>
            <th><?php echo e(__('Total')); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $posPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posPayment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td class="Id">
                    <a href="<?php echo e(route('pos.show',\Crypt::encrypt($posPayment->id))); ?>" class="btn btn-outline-primary">
                        <?php echo e(Auth::user()->posNumberFormat($posPayment->id)); ?>

                    </a>
                </td>
                <td><?php echo e(Auth::user()->dateFormat($posPayment->created_at)); ?></td>
               
                <td><?php echo e(!empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->amount) : 0); ?></td>
                <td><?php echo e(!empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->discount) : 0); ?></td>
                <td><?php echo e(!empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->discount_amount) : 0); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="7" class="text-center text-dark"><p><?php echo e(__('No Data Found')); ?></p></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/resources/views/dashboard/pov-dashboard.blade.php ENDPATH**/ ?>