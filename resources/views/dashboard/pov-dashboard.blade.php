@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>
        $(document).ready(function(){
            $('#filter-date').change(function(){
                var selectedDate = $(this).val();
                $.ajax({
                    url: '{{ route("dashboard.filterByDate") }}',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
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
                    url: '{{ route("dashboard.filterByToday") }}',
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
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
                    data:{!! json_encode(array_values($home_data['task_overview'])) !!}
                },],
                xaxis: {
                    categories:{!! json_encode(array_keys($home_data['task_overview'])) !!},
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
                    data: {!! json_encode(array_values($home_data['timesheet_logged'])) !!}
                }],
                xaxis: {
                    categories: {!! json_encode(array_keys($home_data['timesheet_logged'])) !!},
                },
            };
            var chart = new ApexCharts(document.querySelector("#timesheet_logged"), options);
            chart.render();
        })();
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">Dashboard POS</li>
@endsection
@section('content')
@php
    $rendahoje = 0;
    $rendames = 0;

@endphp

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

@forelse ($posPayments as $posPayment)
    @php
        $rendahoje += floatval($posPayment->posPayment->discount_amount);
    @endphp
@empty
    <tr>
        <td colspan="7" class="text-center text-dark"><p>{{ __('No Data Found') }}</p></td>
    </tr>
@endforelse

@forelse ($posPayments2 as $posPayment2)
    @php
            $rendames += floatval($posPayment2->posPayment->discount_amount);

    @endphp
@empty
    <tr>
        <td colspan="7" class="text-center text-dark"><p>{{ __('No Data Found') }}</p></td>
    </tr>
@endforelse

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
                                <h4 class="mb-0 text-success" id="rendahoje">{{ Auth::user()->priceFormat($rendahoje) }}</h4>
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
                                <h4 class="mb-0 text-warning">{{ Auth::user()->priceFormat($rendames) }}</h4>
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
            <th>{{__('POS ID')}}</th>
            <th>{{ __('Date') }}</th>
            <th>{{ __('Sub Total') }}</th>
            <th>{{ __('Discount') }}</th>
            <th>{{ __('Total') }}</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($posPayments as $posPayment)
            <tr>
                <td class="Id">
                    <a href="{{ route('pos.show',\Crypt::encrypt($posPayment->id)) }}" class="btn btn-outline-primary">
                        {{ Auth::user()->posNumberFormat($posPayment->id) }}
                    </a>
                </td>
                <td>{{ Auth::user()->dateFormat($posPayment->created_at)}}</td>
               
                <td>{{ !empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->amount) : 0 }}</td>
                <td>{{ !empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->discount) : 0 }}</td>
                <td>{{ !empty($posPayment->posPayment) ? Auth::user()->priceFormat($posPayment->posPayment->discount_amount) : 0 }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-dark"><p>{{__('No Data Found')}}</p></td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
