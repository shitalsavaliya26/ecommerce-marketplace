@extends('seller.layouts.main')
@section('title', 'Dashboard')

@section('content')
<link href="{{url('public/vendors/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
<style>
    span.m-widget6__text,
    span.m-widget6__caption {
        width: 25% !important;
    }

    .thankspart {
        text-align: center;
        margin-top: 60px;
    }
</style>
<div class="m-content">
    <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        To Do List
                    </h3>
                </div>
            </div>
        </div>

        <div class="m-portlet__body">
            <div class="row">
               <div class="col-sm text-center">
                <a href="{{route('seller.orders').'?status=pending_payment'}}">
                    {{$unpaid}}<br>
                    <span class="text-black">Unpaid</span>
                </a>
            </div>
            <div class="col-sm text-center">
                <a href="{{route('seller.orders').'?status=pending'}}">
                    {{$toprocessship}}<br>
                    <span class="text-black">To-process Shipment</span>
                </a>
            </div>
            <div class="col-sm text-center">
                <a href="{{route('seller.orders').'?status=shipped'}}">
                    {{$shipped}}<br>
                    <span class="text-black">Processed Shipment</span>
                </a>
            </div>
            <div class="col-sm text-center">
                <a href="{{route('seller.orders').'?status=cancelled'}}">
                    {{$cancelled}}<br>
                    <span class="text-black">Cancelled</span>
                </a>
            </div>
            <div class="col-sm text-center">
                <a href="{{route('seller.orders').'?status=rejected'}}">
                    {{$rejected}}<br>
                    <span class="text-black">Rejected</span>
                </a>
            </div>
        </div>
    </div>
</div>
</div>
@endsection