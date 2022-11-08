@extends('seller.layouts.main')
@section('title', 'Order detail')

@section('content')

<style>

    .btn-brand {
        color: #fff;
        background-color: purple;
        border-color: purple;
    }

    ul.lSPager.lSGallery {
        margin-left: 10px !important;
    }

    .table-bordered th, .table-bordered td {
        border: none;
        border-top: 1px solid #f4f5f8;
    }
    .tdtext{
        vertical-align: top !important;
        font-weight: 500;
        font-size: 1.2rem;
    }
    .lasttdtext{
        font-weight: 500;
        font-size: 1.24rem;
    }
    .firstTdtext{
        margin: 5px;
        width: 100%;
        font-size: 1.2rem;
    }
    .lasttd{
        vertical-align: top !important;
        font-size: 1.2rem;
    }
    .m-wizard__head.m-portlet__padding-x {
        margin: 3rem 0 0rem 0 !important;
    }
    .m-wizard.m-wizard--2 .m-wizard__head .m-wizard__nav .m-wizard__steps .m-wizard__step .m-wizard__step-number>span {
        margin: -4.70rem auto 0 auto !important;
        width: 3rem;
        height: 3rem;
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
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="##" class="m-nav__link">
                        <span class="m-nav__link-text">Order details</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- END: Subheader -->
<div class="m-content">
    <div class="row">
        <div class="col-md-12">
            <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="m-portlet__body">

                    <div class="row" style="width:100%">
                        <div class="col-md-6">
                            <h3> Order Details </h3>
                            <h6>Order On <?php $str = $order->created_at;
                            $order_date =  date("d M Y", strtotime($str));
                            $total = 0;
                            $totalqty = 0;
                            echo $order_date; ?>  <?php if($order->order_id != ''){ echo  '     | Order # '.$order->order_id ; } ?>
                        </h6>
                        <h6><span class="fw-600">Full Name </span> : {{ $order->user->name }}</h6>
                    </div>
                    <div class="col-md-5" style="text-align:right">
                        <h4>Shipping Address </h4>
                        <h6>
                            @if($order->orderAddress->self_pickup_address && $order->orderAddress->self_pickup_address != '')
                            <h5>SELF COLLECT</h5>
                            {{ $order->orderAddress->self_pickup_address }}
                            @else
                            @if($order->orderAddress)
                            <?php $orderAddress = $order->orderAddress;  ?>
                            {{$orderAddress->name}} <br/>
                            @if($orderAddress->address_line1 != '') {{$orderAddress->address_line1}} @endif 
                            @if($orderAddress->address_line2 != ''), {{$orderAddress->address_line2}} @endif <br/>
                            @if($orderAddress->town != '') {{$orderAddress->town}} @endif 
                            @if($orderAddress->state != ''), {{$orderAddress->state}} @endif 
                            @if($orderAddress->postal_code != ''), {{$orderAddress->postal_code}} @endif  <br/>
                            @if($orderAddress->country != '') {{$orderAddress->country}} @endif 
                            @if($orderAddress->contact_number != ''), Tel : +60{{$orderAddress->contact_number}} @endif 
                            @else
                            {{$order->user->name}}
                            @endif
                            @endif

                        </h6>
                        <h4><b>Payment method :</b>
                            @if($order->payment_by == 1)
                            COD
                            @elseif($order->payment_by == 2)
                            Ipay
                            @elseif($order->payment_by == 3)
                            Wallet
                            @elseif($order->payment_by == 4)
                            Manual bank transfer
                            @endif
                        </h4>
                        
                    </div>
                    <div class="col-md-1" style="text-align:right">
                        <a onclick="window.history.back()" class="btn btn-secondary">
                            Back
                        </a>
                        
                        @if($order->payment_by == 4 && $order->bank_receipt != '')
                        <a href="{{ url('public/bank_receipts/'.$order->bank_receipt) }}" class="btn btn-sm btn-primary mt5" target="_blank">View receipt</a>
                        @endif
                        
                        @if($order->payment_by == 4 && $order->bank_receipt2 != '')
                        <a href="{{ url('public/bank_receipts/'.$order->bank_receipt2) }}" class="btn  btn-sm btn-primary mt5" target="_blank">View other receipt</a>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
      @if (\Session::has('success'))
      <div class="m-section__content">
        <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </button>
            <strong> {!! \Session::get('success') !!}</strong>
        </div>
    </div>
    @endif
    @if (\Session::has('error'))
    <div class="m-section__content">
        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            </button>
            <strong> {!! \Session::get('error') !!}</strong>
        </div>
    </div>
    @endif
</div>
<div class="col-md-8">
 <form class="" id="order_frm" action="" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" name="user" value="{{ $order->user_id }}">
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption" style="width:100%">
                <div class="row" style="width:100%">
                    <h5> Product details </h5>
                </div>
            </div>
            {{-- <div class="m-portlet__head-caption">
                <div class="row">
                    <a href="#" class="btn btn-primary add_item">
                        Add Item
                    </a>
                </div>
            </div> --}}
        </div>
        <div class="m-portlet__body" style="padding:0px;">
            <table class="table table-checkable dataTable dtr-inline no-footer collapsed " id="m_table_1">

                <thead>
                    <tr>
                        <th width="10%">Product name</th>
                        <th style="width: 10%;">SKU</th>
                        <th style="width: 15%;text-align:right;">Price</th>
                        <th style="width: 15%;text-align:right;"></th>
                        <th style="width: 15%;text-align:right;">Quantity</th>
                        <th style="width: 10%;text-align:right;">Amount</th>
                        <th style="width: 15%;text-align:right;">Variation</th>									
                    </tr>
                </thead>
                <tbody  id="prrow">
                    <?php $products = $order->orderProduct;?>
                    @foreach($products as $product)
                    <?php 
                    $orderItem = json_decode($product['product_info'], true);
                    $productObj = App\Product::with('attributevariationprice')->find($orderItem['id']);
                    ?>
                    <tr>
                        <td width="15%" ><img width="70" height="70" style="margin-left: 10%;" src="{{ $productObj->images[0]['image'] }}" >
                            <div>
                               <select class="d-none product-item" name="productId[]">
                                <option  value="">Select Product</option>
                                @foreach($allproducts as $pro)
                                <option data-sku="{{$pro->sku}}" data-qty ="{{ $pro->qty }}" data-id="{{ $pro->id }}"  value="{{$pro->id }}" @if($pro->id == $productObj->id) selected @endif>{{$pro->name}} </option>
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td >
                     <span class="tdtext" >{{  $productObj->name }} </span> <br/> {{ $productObj->code }} 
                 </td>
                 <td class="tdtext" style="text-align: right;" > RM {{ number_format($product->price,2) }}<input type="hidden" name="price[]" value="{{ number_format($product->price,2) }}"></td>
                 <td></td>
                 
                <td class="tdtext" style="text-align: right;" > {{ $product->qty }}</td>
                <td class="tdtext" style="text-align: right;" >RM <?php   $subtotal = $product->qty * $product->price;   $total = $total + $subtotal; echo  number_format($subtotal,2);   ?></td>
                @if($product->productdetail && $product->productdetail->is_variation == 1 && count((array)$product->attributevariationprice) > 0)
                    <?php $variationArray = explode('_', $product->attributevariationprice->variation_value_text);
                    ?>
                    <td class="tdtext" style="text-align: center;" >
                    <input type = "hidden" style="text-align:right" class="form-control variationId" name="variationId[]" value="{{$product->variation_id}}" readonly />
                        @foreach($product->productdetail->attributes as $key => $row)
                            {{$row->name}} -{{ $variationArray[$key]}} <br>
                        @endforeach
                    </td>                                    
                @else
                    <td>
                        <input type = "text" style="text-align:right" class="form-control variationId" name="variationId[]" value="" readonly />
                    </td>
                @endif
            </tr>
            @endforeach
            
        </tbody>
        <tfoot>
         <tr>
            <th>                            
                </th>
        </tr>
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Sub total</th>
            <!-- <th class="tdtext" style="text-align: right;" > </th> -->
            <th  class="tdtext ng-total" style="text-align: right;" colspan="2" >RM {{ number_format($total,2) }}</th>
        </tr>
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Shipping charge</th>
            <!-- <th class="tdtext" style="text-align: right;" > </th> -->
            
            <th class="tdtext" style="text-align: right;" colspan="2" >RM {{ number_format($order->shipping_charge+$order->shipping_paid_by_agent,2) }}</th>
        </tr>
        @if($order->discount > 0)
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Discount</th>
            <!-- <th class="tdtext" style="text-align: right;" >  </th> -->
            <th  class="tdtext ng-total" style="text-align: right;" colspan="2" >RM {{ number_format($order->discount,2) }}</th>
        </tr>
        @endif
        @if($order->used_coins_in_rm > 0 && $order->used_coins > 0)
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Used Coins</th>
            <th  class="tdtext ng-total" style="text-align: right;" colspan="2" >RM{{number_format($order->used_coins_in_rm,2)}} ({{round($order->used_coins)}} Coins)</th>
        </tr>
        @endif
        @if($sellerDiscount > 0)
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Discount</th>
            <th  class="tdtext ng-total" style="text-align: right;" colspan="2" >RM{{number_format($sellerDiscount,2)}}</th>
        </tr>
        @endif
        @if($sellerCashback > 0)
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Cashback</th>
            <th  class="tdtext ng-total" style="text-align: right;" colspan="2" >{{number_format($sellerCashback,2)}}</th>
        </tr>
        @endif
        <tr>
            <th class="tdtext" style="text-align: right;" colspan="6">Total</th>
            <!-- <th class="tdtext" style="text-align: right;" > </th> -->
            <th  class="tdtext ng-totalship" style="text-align: right;" colspan="2"  >RM {{ number_format($order->total_amount,2) }}</th>
        </tr>
        
    </tfoot>
</table>
</div> 
</div>
</form>
</div>
<div class="col-md-4">
    <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="row">
                    <h5> Order status </h5> 
                    @if($order->status == 'pending')
                    <span class="m-badge m-badge--brand m-badge--wide ml115">Pending</span>
                    @elseif($order->status == 'shipped')
                    <span class="m-badge m-badge--metal m-badge--wide ml115">Shipped</span>
                    @elseif($order->status == 'delivered')
                    <span class="m-badge m-badge--success m-badge--wide ml115">Delivered</span>
                    @elseif($order->status == 'cancelled')
                    <span class="m-badge m-badge--danger m-badge--wide ml115">Cancelled</span>
                    @elseif($order->status == 'rejected')
                    <span class="m-badge m-badge--danger m-badge--wide ml115">Rejected</span>
                    @else
                    <span class="m-badge m-badge--primary m-badge--wide ml115">{{ ucwords($order->status) }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="m-portlet__body">

            @if($order->status == 'cancelled')
            {{ $order->cancel_order_reason }}
            @endif

            @php $is_action = false; @endphp
            
            @if($order->status == 'rejected')
            <p style="overflow: auto;">cancel reason : {{ $order->cancel_order_reason }}</p>
            @endif
        </div>
    </div>
</div>
</div>

@if(count($order->orderNote) != 0 && $order->orderNote[0]->note !=  null)
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="m-portlet__body">

                <div class="row" style="width:100%">
                    <div class="col-md-12">
                        <h5> Order note </h5>
                        <p>{{ $order->orderNote[0]->note}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if($order->status == 'shipped' || $order->status == 'delivered' )
<div class="row">
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
            <div class="m-portlet__body">

                <div class="row" style="width:100%">
                    <div class="col-md-12">
                        <h5> Shipping details </h5>
                        @if($order->Gdex_api == 4)
                        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            <strong> Gdex failed reason : {!! $order->remark !!}</strong>
                        </div>
                        @endif
                        <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_2">
                            <tbody id="itemdata" >
                                <tr>
                                    <th style="width: 200px;">
                                        Courier company name
                                    </td>
                                    <td>
                                        @if($order->shippingCompany && $order->courier_company_name != null && $order->courier_company_name != '' )
                                            {{ $order->shippingCompany->name }}({{ $order->shippingCompany->slug }})
                                        @else
                                            @foreach($order->counriercompanies as $companyDetail)
                                                {{$companyDetail->shippingcomapny['name']}}<br>
                                            @endforeach
                                        @endif  
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Tracking code
                                    </td>
                                    <td>
                                        @if($order->tracking_number != null && $order->tracking_number != '') 
                                            {{ $order->tracking_number }} 
                                        @else 
                                            @foreach($order->tracking_no as $track)
                                                {{ $track->tracking_number }}<br>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        Shipping charge
                                    </td>
                                    <td>
                                        RM {{number_format($order->shipping_charge+$order->shipping_paid_by_agent,2)}}
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        Shipped on
                                    </td>
                                    <td>
                                        {{$order->shipped_date}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
</div>
</div>


<!--begin::Modal Verification-->
<div class="modal fade" id="confirm-status-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs20" id="exampleModalLabel">Order process</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6 class="show_confirm_title" style="display: none;"></h6>
                <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_3">
                    <tbody id="itemdatanew" >
                        <tr>
                            <th style="width: 200px;">
                                Status
                            </td>
                            <td>
                                <div id="m_status"></div>
                            </td>
                        </tr>
                        @if(Auth::user()->role_id == 1) 
                        <tr>
                            <th>
                                Courier company name
                            </td>
                            <td>
                                <div id="m_courier_comapny"></div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Tracking code
                            </td>
                            <td>
                                <div id="m_tracking_code"></div>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Shipping charge
                            </td>
                            <td>
                                <div id="m_shipping_charge"></div>
                            </td>
                        </tr>
                        
                        @endif
                    </tbody>
                </table>
                <div class="row" id="enter_reason">
                    <br><br>
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <form method="GET" >

                            <div class="form-group m-form__group row">
                                <label>Enter cancle reason:</label>
                                <input type="text" name="cancel_reason" class="form-control " placeholder="Enter cancel reason" id="en_cancel_reason"  value=""/>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary confirm-status">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!--end::Modal Verification-->

<!--begin::Modal Product add-->
<div class="modal fade" id="add_item_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Product:</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="#" id="add_product_form">
            {{csrf_field()}}
            <div class="modal-body">
                <div class="text-center">
                    <h6><?php if($order->order_id != ''){ echo  'Order # '.$order->order_id ; } ?> </h6>
                    <h6><strong>Full Name : </strong>{{ $order->user->name }}</h6>
                </h6>
            </div>
            {{-- <input type="hidden" name="user_id" id="user_id" value=""> --}}

            <div class="form-group m-form__group row">
                <label class="col-3 col-form-label align-right">Product</label>
                <div class="col-7 input-group ">
                    <select class="form-control" name="product" required>
                        <option value="">Select product</option>
                        @foreach($products as $product)
                        <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                        {{-- <option value="debit">Debit</option> --}}
                    </select>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-3 col-form-label align-right">Price</label>
                <div class="col-7 input-group ">
                    <input type="text" readonly disabled class="form-control m-input" name="price">
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-3 col-form-label align-right">Quantity</label>
                <div class="col-7 input-group ">
                    <input type="text" name="quantity" class="form-control m-input width-200"
                    placeholder="Enter Quantity" value="" required>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <label class="col-3 col-form-label align-right">Amount</label>
                <div class="col-7 input-group ">
                    <input type="text" readonly disabled class="form-control m-input" name="amount">
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary submitConfirm">Add</button>
        </div>
    </form>
</div>
</div>
</div>
<!--end::Modal Product add-->


<script type="text/javascript">
  
</script>

{{-- <script src="{!!url('/public/vendors/jquery/dist/jquery.js')!!}"></script>
<script src="{{url('/public/vendors/js/jquery.desoslide.min.js')}}"></script>
<link href="{{url('/public/vendors/css/jquery.desoslide.css')}}" rel="stylesheet" type="text/css" /> --}}
@endsection

