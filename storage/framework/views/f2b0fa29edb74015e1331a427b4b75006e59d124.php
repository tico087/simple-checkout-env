<table class="table datatable p-3" style="background: white; border-radius:10px;">
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
                    <a href="<?php echo e(route('pos.show', \Crypt::encrypt($posPayment->id))); ?>" class="btn btn-outline-primary">
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
<?php /**PATH /var/www/resources/views/dashboard/partials/pos_table.blade.php ENDPATH**/ ?>