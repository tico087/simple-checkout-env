<?php
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $company_logo = Utility::getValByName('company_logo');
?>


<?php if(!empty($sales) && count($sales) > 0): ?>
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-6">
                    <img src="<?php echo e($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png')); ?>"
                        width="120px;">
                </div>
                
                
                
            </div>
            <div id="printableArea">
                <div class="row mt-3">
                    <div class="col-6">
                        <h1 class="invoice-id h6"><?php echo e($details['pos_id']); ?></h1>
                        <div class="date"><b><?php echo e(__('Date')); ?>: </b><?php echo e($details['date']); ?></div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="text-dark "><b><?php echo e(__('Warehouse Name')); ?>: </b>
                            <?php echo $details['warehouse']['details']; ?>

                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col contacts d-flex justify-content-between pb-4">
                        <div class="invoice-to">
                            <div class="text-dark h6"><b><?php echo e(__('Billed To :')); ?></b></div>
                            <?php echo $details['customer']['details']; ?>

                        </div>
                        <?php if(!empty($details['customer']['shippdetails'])): ?>
                            <div class="invoice-to">
                                <div class="text-dark h6"><b><?php echo e(__('Shipped To :')); ?></b></div>
                                <?php echo $details['customer']['shippdetails']; ?>

                            </div>
                        <?php endif; ?>
                        <div class="company-details">
                            <div class="text-dark h6"><b><?php echo e(__('From:')); ?></b></div>
                            <?php echo $details['user']['details']; ?>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left"><?php echo e(__('Items')); ?></th>
                                <th><?php echo e(__('Quantity')); ?></th>
                                <th class="text-right"><?php echo e(__('Price')); ?></th>
                                <th class="text-right"><?php echo e(__('Tax')); ?></th>
                                <th class="text-right"><?php echo e(__('Tax Amount')); ?></th>
                                <th class="text-right"><?php echo e(__('Total')); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $sales['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <tr>
                                    <td class="cart-summary-table text-left">
                                        <?php echo e($value['name']); ?>

                                    </td>
                                    <td class="cart-summary-table">
                                        <?php echo e($value['quantity']); ?>

                                    </td>
                                    <td class="text-right cart-summary-table">
                                        <?php echo e($value['price']); ?>

                                    </td>
                                    <td class="text-right cart-summary-table">
                                        <?php echo $value['product_tax']; ?>

                                    </td>


                                    <td class="text-right cart-summary-table">
                                        <?php echo e($value['tax_amount']); ?>

                                    </td>
                                    <td class="text-right cart-summary-table">
                                        <?php echo e($value['subtotal']); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class=""><?php echo e(__('Sub Total')); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><?php echo e($sales['sub_total']); ?></td>
                            </tr>
                            <tr>
                                <td class=""><?php echo e(__('Discount')); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><?php echo e($sales['discount']); ?></td>
                            </tr>
                            <tr class="pos-header">
                                <td class=""><?php echo e(__('Total')); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right"><?php echo e($sales['total']); ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            

            <?php if($details['pay'] == 'show'): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <h5><?php echo e(__('Select Payment Method')); ?></h5>
                        <div class="payment-options d-flex justify-content-around">
                            <button class="btn btn-outline-primary payment-method-btn btn-cash" data-method="cash">
                                <?php echo e(__('Cash Payment')); ?>

                            </button>
                            <button class="btn btn-outline-success payment-method-btn btn-pix" data-method="pix">
                                <?php echo e(__('Pix Payment')); ?>

                            </button>
                            <button class="btn btn-outline-info payment-method-btn btn-debit" data-method="debit">
                                <?php echo e(__('Debit Payment')); ?>

                            </button>
                            <button class="btn btn-outline-warning payment-method-btn btn-credit" data-method="credit">
                                <?php echo e(__('Credit Payment')); ?>

                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" style="height: 20vh;">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <button id="confirm-payment-btn" class="btn btn-success rounded mt-2" disabled
                            data-url="<?php echo e(route('pos.printview')); ?>" data-ajax-popup="true" data-size="sm"
                            data-bs-toggle="tooltip" data-title="<?php echo e(__('POS Invoice')); ?>">
                            <?php echo e(__('Confirm Payment')); ?>

                        </button>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>

<?php endif; ?>


<script type="text/javascript" src="<?php echo e(asset('js/html2pdf.bundle.min.js')); ?>"></script>
<script>
    var filename = $('#filename').val()

    function saveAsPDF() {
        var element = document.getElementById('printableArea');
        var opt = {
            margin: 0.3,
            filename: filename,
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 4,
                dpi: 72,
                letterRendering: true
            },
            jsPDF: {
                unit: 'in',
                format: 'A2'
            }
        };
        html2pdf().set(opt).from(element).save();
    }

    $('.payment-method-btn').on('click', function() {
        $('.payment-method-btn').removeClass('active');
        $(this).addClass('active');
        selectedMethod = $(this).data('method');
        $('#confirm-payment-btn').prop('disabled', false);
    });


    $('#confirm-payment-btn').on('click', function(e) {
        e.preventDefault();
        var ele = $(this);
        var paymentMethod = $('.payment-method-btn.active').data('method');
        var salesData = [];

        var formData = {
            _token: "<?php echo e(csrf_token()); ?>",
            pos_id: "<?php echo e($details['pos_id']); ?>",
            date: "<?php echo e($details['date']); ?>",
            warehouse: <?php echo json_encode($details['warehouse']); ?>,
            customer_details: <?php echo json_encode($details['customer']['details']); ?>,
            shipping_details: <?php echo json_encode($details['customer']['shippdetails']); ?>,
            user_details: <?php echo json_encode($details['user']['details']); ?>,
            sales: salesData,
            sub_total: "<?php echo e($sales['sub_total']); ?>",
            discount: "<?php echo e($sales['discount']); ?>",
            total: "<?php echo e($sales['total']); ?>",
            payment_method: paymentMethod
        };


        $.ajax({
            url: "<?php echo e(route('pos.data.store')); ?>",
            method: 'POST',
            data: formData,
            /*beforeSend: function() {
                ele.remove();
            },*/
            success: function(data) {
                if (data.code == 200) {
                    show_toastr('success', data.success, 'success')
                }
            },
            error: function(data) {
                data = data.responseJSON;
                show_toastr('<?php echo e(__('Error')); ?>', data.error, 'error');
            }
        });
    });
</script>

<style>
    .payment-method-btn {
        font-size: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
    }

    .btn-cash {
        background-color: #f8f9fa;
        border-color: #007bff;

    }

    .btn-pix {
        background-color: #e2e6ea;
        border-color: #28a745;

    }

    .btn-debit {
        background-color: #d1ecf1;
        border-color: #17a2b8;

    }

    .btn-credit {
        background-color: #fff3cd;
        border-color: #ffc107;

    }
</style>
<?php /**PATH /var/www/resources/views/pos/show.blade.php ENDPATH**/ ?>