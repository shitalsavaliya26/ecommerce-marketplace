@extends('seller.layouts.main')
@section('title', 'Orders')

@section('content')
@php
//use App\Commands\SortableTrait;
@endphp
<style>
    select{
        padding: 0.60rem 1.00rem !important;
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
                        <span class="m-nav__link-text">My Orders</span>
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
                     My Orders
                 </h3>
             </div>
         </div>
         <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">

            </div>
        </div>
        <div class="m-portlet__head-tools">
            <div class="m-portlet__head-title">
               <h3 class="m-portlet__head-text mr-2">
                 Total Amount : {{ number_format($order_status_total,2)}} 
             </h3>
         </div>
         <div class="row">

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
            <div class="col-md-2">
                <div class="m-input-icon m-input-icon--left">
                    <input type="text" class="form-control m-input" placeholder="Search..." name="search" value="{{ @$search }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group m-form__group">
                    <select class="form-control m-input" name="status">
                        <option value="" >Select Status</option>
                        <option value="pending" @if (@$status == 'pending' ) selected="selected" @endif >Pending</option>

                        <option value="confirmed" @if (@$status == 'confirmed' ) selected="selected" @endif >Confirmed</option>

                        <option value="shipped" @if (@$status == 'shipped' ) selected="selected" @endif >Shipped</option>

                        <option value="delivered" @if (@$status == 'delivered' ) selected="selected" @endif >Delivered</option>

                        <option value="rejected" @if (@$status == 'rejected' ) selected="selected" @endif >Rejected</option>
                        <option value="cancelled" @if (@$status == 'cancelled' ) selected="selected" @endif >Cancelled</option>
                    </select>
                </div>  
            </div>
            <div class="col-md-2">
                <div class="form-group m-form__group">
                    <div class="m-input-icon ">
                        <input type="text" name="fromDate" class="form-control m-input" id="fromDate" value="{{ @$fromDate }}" placeholder="From Date" autocomplete="off">
                        <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group m-form__group">
                    <div class="m-input-icon " id="m_daterangepicker_2">
                        <input type="text" name="toDate" class="form-control m-input" id="toDate" value="{{ @$toDate }}" placeholder="To Date" autocomplete="off">
                        <span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <select class="form-control" name="courier_company_name">
                    <option value="" >Select Courier Company</option>
                    @foreach($shipping as $ship)
                    <option @if(request()->courier_company_name == $ship->id) selected  @else value="{{ $ship->id }}"  @endif  >{{ $ship->name }} ({{ $ship->slug }})</option> 
                    @endforeach
                </select>
            </div>

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
    <div class="table-responsive">
      <table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
        <thead>
            <tr>
                <th>Order #</th>
                <th>Ordered On</th>
                <th>Customer name</th> 
                <!-- <th width="30%">Ship To</th> -->
                <th>Courier company</th>
                <th>Tracking code</th>
                @if(in_array(Auth::user()->role_id, [1,9]))
                <!-- <th class="align-right" >Agent profit</th> -->
                <th class="align-right" >Company profit</th>
                @endif
                <th class="align-right sort-header" >Delivered On</th>
                <th class="align-right" >Discount</th>
                <th class="align-right" >Total Amount</th>
                <th >Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @if(count($orders) == 0)
            <tr>
                <td colspan="8" style="text-align:center;">No record found</td>
            </tr>
            @endif
            @foreach($orders as $order)
            @php  $bgcolor = ''; @endphp
            @if($order->payment_by == 4) 
            @php $bgcolor = '#bfe3b4';  @endphp
            @endif
            <tr style="background-color:{{ $bgcolor }} ">
                <td><a class="linkremove" href="{{ route('seller.orderdetail', $order->order_id) }}"> {{ $order->order_id}} </a></td>
                <td>{{ date('d/m/Y h:i:s',strtotime($order->created_at)) }}</td>
                <td>{{ $order->user->name }} ({{$order->user->referal_code}})</td>
                <td>
                    @if($order->shippingCompany && $order->courier_company_name != null && $order->courier_company_name != '' )
                    {{ $order->shippingCompany->name }}({{ $order->shippingCompany->slug }})
                    @else
                    @foreach($order->counriercompanies as $companyDetail)
                    {{$companyDetail->shippingcomapny['name']}}<br>
                    @endforeach
                    @endif
                </td>
                <td class="align-center">
                    @if($order->tracking_number != null && $order->tracking_number != '') 
                    {{ $order->tracking_number }} 
                    @else 
                    @foreach($order->tracking_no as $track)
                    {{ $track->tracking_number }}<br>
                    @endforeach
                    @endif
                </td>

                @if(in_array(Auth::user()->role_id, [1,9]))
                <!-- <td class="align-center">@if($order->created_at > \Carbon\Carbon::parse('2021-10-05 18:33:32')) RM {{ number_format($order->getCOrderAgentProfit($order->id),2) }} @else - @endif</td> -->
                <td class="align-center">@if($order->created_at > \Carbon\Carbon::parse('2021-10-05 18:33:32')) RsM {{ number_format($order->getCOrderCompanyProfit($order->id),2) }} @else - @endif</td>
                @endif
                <td>{{ ($order->delivered_date) ? date('d/m/Y h:i:s',strtotime($order->delivered_date)) : '-' }}</td>

                <td class="align-center">RM {{ number_format($order->discount,2) }}</td>

                <td class="align-right">
                    RM {{ number_format($order->getorderpricebyidwithoutshipping($order->id),2) }}{{-- +$order->shipping_charge --}}
                </td>

                <td>
                    @if($order->status == 'pending')
                    <span class="m-badge m-badge--brand m-badge--wide">Pending</span>
                    @elseif($order->status == 'confirmed')
                    <span class="m-badge m-badge--info m-badge--wide">Confirmed</span>
                    @elseif($order->status == 'shipped')
                    <span class="m-badge m-badge--metal m-badge--wide">Shipped</span>
                    @elseif($order->status == 'delivered')
                    <span class="m-badge m-badge--success m-badge--wide">Delivered</span>
                    @elseif($order->status == 'cancelled')
                    <span class="m-badge m-badge--danger m-badge--wide">Cancelled</span>
                    @elseif($order->status == 'transferred')
                    <span class="m-badge m-badge--success m-badge--wide">Transferred</span>
                    @elseif($order->status == 'rejected')
                    <span class="m-badge m-badge--danger m-badge--wide">Rejected</span>
                    @else
                    <span class="m-badge m-badge--primary m-badge--wide">{{ ucwords($order->status) }}</span>
                    @endif
                </td>
                <td nowrap>
                    <span class="dropdown">
                        <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                            <i class="la la-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                            <a class="dropdown-item" href="{{ route('seller.orderdetail', $order->order_id) }}">View</a>

                            @if( $order->status == "pending" || $order->status == "shipped")
                          <!--   <a class="dropdown-item reject_modal" href="#"  data-order_id="{{ $order->order_id }}" data-id = "{{ $order->id }}" >Reject</a> -->
                            @endif
                            @if($order->status == "shipped")
                            <a class="dropdown-item deliverd_modal" href="#"  data-order_id="{{ $order->order_id }}" data-id = "{{ $order->id }}">Deliver</a>
                            @endif
                        </div>
                    </span>
                </td>
            </tr>
            <tr style="background-color:{{ $bgcolor }} ">
                <td colspan="8">
                    <span class="fs10">
                        @if($order->order_address && $order->order_address->self_pickup_address && $order->order_address->self_pickup_address != '')
                        <span>SELF COLLECT&nbsp; </span>
                        <b class="fs10"> Address:</b>
                        {{ $order->order_address->self_pickup_address }}
                        @else
                        @if( $order->order_address)
                        <?php $orderAddress = $order->order_address;  ?>
                        <b class="fs10">Name:</b> {{$orderAddress->name}}&nbsp;  
                        <b class="fs10"> Address:</b>
                        @if($orderAddress->address_line1 != '') {{$orderAddress->address_line1}} ,@endif 
                        @if($orderAddress->address_line2 != '') {{$orderAddress->address_line2}} , @endif 
                        @if($orderAddress->town != '') {{$orderAddress->town}} , @endif 
                        @if($orderAddress->state != '') {{$orderAddress->state}} , @endif 
                        @if($orderAddress->postal_code != '') {{$orderAddress->postal_code}}, @endif  
                        @if($orderAddress->country != '') {{$orderAddress->country}} @endif 
                        @if($orderAddress->contact_number != '') <b class="fs10"> &nbsp;Phone:</b>{{$orderAddress->country_code}}&nbsp;   {{$orderAddress->contact_number}} @endif 
                        @else 
                        {{ $order->user->name }}   
                        @endif
                        @endif
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $orders->render()}}

</div>
</div>
</div>
<div id="rejectmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Order Reject ( #<span id="display_order_id"></span>)</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

    </div>
    <div class="modal-body">
        <form method="POST" action="{{ route('cancelorder')}}" id="frmorderreject">
            {{ csrf_field() }}
            <div class="form-group m-form__group row">
                <textarea class="form-control" name="cancel_reason" id="cancel_order_reason"  rows="3" placeholder="Enter cancel order reason" required="required"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="order_id" id="reject_order_id" value="">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Submit" name="Submit">
        </div>
    </form>
</div>

</div>
</div>
<div id="deliver_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Order Deliver ( #<span id="display_order_id_del"></span>)</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>

    </div>
    <div class="modal-body">
        <form method="post" action="" id="formdeliveredorder">
            {{ csrf_field() }}
            <div class="form-group m-form__group row">
                <textarea class="form-control" name="remark" rows="3" placeholder="Enter your remark"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" name="order_id" value="" id="Deliver_order_id">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" name="Submit" value="submit" class="btn btn-primary">
        </div>
    </form>
</div>

</div>
</div>
<script type="text/javascript">

    jQuery(document).ready(function() {    
        $('#fromDate').datepicker({
            autoclose: true,
        });
        $('#toDate').datepicker({
            autoclose: true,
        });
    });
    $(document).ready(function () {
        $( "#frmorderreject" ).validate({
        }); 
        $("#formdeliveredorder").validate({
            submitHandler: function(form) {
                return confirm('Do you really want to deliver this order?');
            }
        });
                     // Attach Button click event listener 
                     $(".reject_modal").click(function(){
                         // show Modal
                         $("#display_order_id").html($(this).attr("data-order_id"));
                         $("#reject_order_id").val($(this).attr("data-id"));
                         $('#rejectmodal').modal('show');

                     });
                     $(".deliverd_modal").click(function(){
                         // show Modal
                         $("#display_order_id_del").html($(this).attr("data-order_id"));
                         $("#Deliver_order_id").val($(this).attr("data-id"));
                         $('#deliver_modal').modal('show');

                     });
                 });
             </script>
             @endsection
