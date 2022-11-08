@extends('seller.layouts.main')

@section('content')
@php
//use App\Commands\SortableTrait;
@endphp
<style>
    select{
        padding: 0.60rem 1.00rem !important;
    }

    .table tr {
        cursor: pointer;
    }
    .hiddenRow {
        padding: 0 4px !important;
        font-size: 13px;
    }   
</style>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ url('/')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{ route('seller.orders')}}" class="m-nav__link">
                        <span class="m-nav__link-text">Report</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content" id="agentlist-body">
    <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Report
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">

                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="row" id="app_massges">
            @if (\Session::has('success'))
            <div class="col-xl-12 m-section__content toast-container ">
                <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong> {!! \Session::get('success') !!}</strong>
                </div>
            </div>
            @endif
            @if (\Session::has('error'))
            <div class="col-xl-12 m-section__content">
                <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                    <strong> {!! \Session::get('error') !!}</strong>
                </div>
            </div>
            @endif
        </div>

        <form method="get" id="searchForm" action="">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group m-form__group">
                        <div class="m-input-icon ">
                            <input type="text" name="fromDate" class="form-control m-input" id="fromDate" value="{{ @$fromDate }}" placeholder="From Date" autocomplete="off">
                            <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group m-form__group">
                        <div class="m-input-icon " id="m_daterangepicker_2">
                            <input type="text" name="toDate" class="form-control m-input" id="toDate" value="{{ @$toDate }}" placeholder="To Date" autocomplete="off">
                            <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-2 align-right">
                    <button  type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--air">
                        <span>
                            <span class="font12">Go</span>
                        </span>
                    </button>
                    <button  type="reset" id="resetButon" class="btn btn-default m-btn m-btn--custom m-btn--air">
                        <i class="la la-refresh"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-6 mt-5">
                <div id="container" name="container"></div>
            </div>
            <div class="col-md-6 mt-5">
                <div class="table-responsive">
                    <table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>No. of Orders</th>
                                <th>Total Amount</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($orders) == 0)
                            <tr>
                                <td colspan="8" style="text-align:center;">No record found</td>
                            </tr>
                            @endif
                            <?php $i=0; ?>
                            @foreach($orders as $key => $order)
                            <?php 
                            $i++;
                            $orderIds = array_column($order, 'id'); 
                            ?>
                            <tr data-toggle="collapse" data-target="#demo{{$i}}" class="accordion-toggle">
                                <td>{{ $i }}</td>
                                <td>{{ date('d/m/Y',strtotime($key)) }}</td>
                                <td>{{ count($order) }}</td>
                                <td>{{ Helper::dateWiseOrderTotal($orderIds) }}</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="hiddenRow">
                                    <table class="table table-striped accordian-body collapse" id="demo{{$i}}">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
                                                <th>Customer name</th>
                                            </tr>
                                        </thead>
                                        <?php $orderData = Helper::getOrderByIds($orderIds)?>
                                        <tbody>
                                            @foreach($orderData as $orderDetail)
                                            <tr>
                                                <td><a class="linkremove" href="{{ route('seller.orderdetail', $orderDetail->id) }}"> {{ $orderDetail->order_id}} </a></td>
                                                <td>{{ $orderDetail->user->name }} ({{$orderDetail->user->referal_code}})</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="tdtext bold" colspan="2">Sub total</th>
                                <th class="tdtext bold" >{{$totalOrder}} </th>
                                <th class="tdtext bold" >{{$totalAmount}} </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                {{ $orders->appends(\Request::all())->render()}}
            </div>

            <div class="col-md-6 mt-5"> 
                <h3 class="m-portlet__head-text m--font-weight-500 bg-white br-15 py-4 px-3 px-sm-5 shadow">
                    <b>Best selling products by quantity</b>
                </h3>
                @include('seller.myincome.best_selling_product')
            </div>

            <div class="col-md-6 mt-5"> 
                <h3 class="m-portlet__head-text m--font-weight-500 bg-white br-15 py-4 px-3 px-sm-5 shadow">
                    <b>Best selling products by sales</b>
                </h3>
                @include('seller.myincome.best_selling_product_sale')
            </div>
        </div>
    </div>
</div>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script type="text/javascript">
    $('.accordian-body').on('show.bs.collapse', function () {
        $(this).closest("table")
        .find(".collapse.in")
        .not(this)
        .collapse('toggle')
    });

    jQuery(document).ready(function() {    
        $('#fromDate').datepicker({
            autoclose: true,
        });
        $('#toDate').datepicker({
            autoclose: true,
        });
    });

    var date = {!! json_encode(array_values($date)) !!};
    var dayIncome = {!! json_encode($dayIncome) !!};

    Highcharts.chart('container', {
        title: {
            text: ''
        },

        yAxis: {
            title: {
                text: 'Amount'
            }
        },

        xAxis: {
            // type: 'datetime',

            categories: Object.values(date)
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
            }
        },

        series: [
        {
            name: 'Seller Income',
            data: dayIncome
        },
        ],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
</script>
@endsection
