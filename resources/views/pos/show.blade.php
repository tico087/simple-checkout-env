@php
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $company_logo = Utility::getValByName('company_logo');
@endphp

{{-- @dump($details); --}}
@if (!empty($sales) && count($sales) > 0)
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-6">
                    <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                        width="120px;">
                </div>
                {{--                <div class="col-6 text-end"> --}}
                {{--                    <a href="#" class="btn btn-sm btn-primary" onclick="saveAsPDF()"><span class="ti ti-download"></span></a> --}}
                {{--                </div> --}}
            </div>
            <div id="printableArea">
                <div class="row mt-3">
                    <div class="col-6">
                        <h1 class="invoice-id h6">{{ $details['pos_id'] }}</h1>
                        <div class="date"><b>{{ __('Date') }}: </b>{{ $details['date'] }}</div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="text-dark "><b>{{ __('Warehouse Name') }}: </b>
                            {!! $details['warehouse']['details'] !!}
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col contacts d-flex justify-content-between pb-4">
                        <div class="invoice-to">
                            <div class="text-dark h6"><b>{{ __('Billed To :') }}</b></div>
                            {!! $details['customer']['details'] !!}
                        </div>
                        @if (!empty($details['customer']['shippdetails']))
                            <div class="invoice-to">
                                <div class="text-dark h6"><b>{{ __('Shipped To :') }}</b></div>
                                {!! $details['customer']['shippdetails'] !!}
                            </div>
                        @endif
                        <div class="company-details">
                            <div class="text-dark h6"><b>{{ __('From:') }}</b></div>
                            {!! $details['user']['details'] !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left">{{ __('Items') }}</th>
                                <th>{{ __('Quantity') }}</th>
                                <th class="text-right">{{ __('Price') }}</th>
                                <th class="text-right">{{ __('Tax') }}</th>
                                <th class="text-right">{{ __('Tax Amount') }}</th>
                                <th class="text-right">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales['data'] as $key => $value)
                                {{--                            @dd($value) --}}
                                <tr>
                                    <td class="cart-summary-table text-left">
                                        {{ $value['name'] }}
                                    </td>
                                    <td class="cart-summary-table">
                                        {{ $value['quantity'] }}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {{ $value['price'] }}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {!! $value['product_tax'] !!}
                                    </td>


                                    <td class="text-right cart-summary-table">
                                        {{ $value['tax_amount'] }}
                                    </td>
                                    <td class="text-right cart-summary-table">
                                        {{ $value['subtotal'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="">{{ __('Sub Total') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">{{ $sales['sub_total'] }}</td>
                            </tr>
                            <tr>
                                <td class="">{{ __('Discount') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">{{ $sales['discount'] }}</td>
                            </tr>
                            <tr class="pos-header">
                                <td class="">{{ __('Total') }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="text-right">{{ $sales['total'] }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            @if ($details['pay'] == 'show')
                <div class="row mt-3">
                    <div class="col-12">
                        <h5>{{ __('Select Payment Method') }}</h5>
                        <div class="payment-options d-flex justify-content-around">
                            <button class="btn btn-outline-primary payment-method-btn btn-cash" data-method="cash">
                                {{ __('Cash Payment') }}
                            </button>
                            <button class="btn btn-outline-success payment-method-btn btn-pix" data-method="pix">
                                {{ __('Pix Payment') }}
                            </button>
                            <button class="btn btn-outline-info payment-method-btn btn-debit" data-method="debit">
                                {{ __('Debit Payment') }}
                            </button>
                            <button class="btn btn-outline-warning payment-method-btn btn-credit" data-method="credit">
                                {{ __('Credit Payment') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3" style="height: 20vh;">
                    <div class="col-12 d-flex justify-content-center align-items-center">
                        <button id="confirm-payment-btn" class="btn btn-success rounded mt-2" disabled
                            data-url="{{ route('pos.printview') }}" data-ajax-popup="true" data-size="sm"
                            data-bs-toggle="tooltip" data-title="{{ __('POS Invoice') }}">
                            {{ __('Confirm Payment') }}
                        </button>
                    </div>
                </div>
            @endif

        </div>
    </div>

@endif


<script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
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
            _token: "{{ csrf_token() }}",
            pos_id: "{{ $details['pos_id'] }}",
            date: "{{ $details['date'] }}",
            warehouse: {!! json_encode($details['warehouse']) !!},
            customer_details: {!! json_encode($details['customer']['details']) !!},
            shipping_details: {!! json_encode($details['customer']['shippdetails']) !!},
            user_details: {!! json_encode($details['user']['details']) !!},
            sales: salesData,
            sub_total: "{{ $sales['sub_total'] }}",
            discount: "{{ $sales['discount'] }}",
            total: "{{ $sales['total'] }}",
            payment_method: paymentMethod
        };


        $.ajax({
            url: "{{ route('pos.data.store') }}",
            method: 'POST',
            data: formData,
            beforeSend: function() {
                ele.remove();
            },
            success: function(data) {
                if (data.code == 200) {
                    show_toastr('success', data.success, 'success')
                }
            },
            error: function(data) {
                data = data.responseJSON;
                show_toastr('{{ __('Error') }}', data.error, 'error');
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
