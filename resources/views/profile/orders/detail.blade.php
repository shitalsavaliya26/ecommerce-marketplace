@extends('layouts.main')
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="productsection">
                   <div class="row" style="width:100%">
                        <div class="col-md-6">
                            <h3> {{trans('label.order_details')}} </h3>
                            <h6> {{trans('label.order_on')}} <?php $str = $order->created_at;
                                $order_date =  date("d M Y", strtotime($str));
                                $total = 0;
                                $totalqty = 0;
                                echo $order_date; ?>  <?php if($order->order_id != ''){ echo  '     | Order # '.$order->order_id ; } ?>
                            </h6>
                            <a href="{{route('user.orders')}}" class="btn btn-info m-badge--wide delivery-status">< Back</a>
                        </div>
                        <div class="col-md-6" style="text-align:right">
                            <h6>{{trans('label.shipping_address')}} </h6>
                            <h6>
                                @if($order->orderAddress->self_pickup_address && $order->orderAddress->self_pickup_address != '')
                                    <h5>{{trans('label.self_collect')}}</h5>
                                    {{ $order->orderAddress->self_pickup_address }}
                                @else
                                    <strong>{{$address[0]->name}}
                                        @if($address[0]->contact_number != '' )
                                        (Mo) - {{$address[0]->contact_number}} 
                                        @endif
                                    </strong>
                                    <br/>
                                    @if($address[0]->address_line1 != '') 
                                        {{$address[0]->address_line1}},  
                                    @endif 
                                    @if($address[0]->address_line2 != '') 
                                        {{$address[0]->address_line2}},  
                                    @endif 

                                    @if($address[0]->town != '') 
                                        {{$address[0]->town}}, 
                                    @endif 

                                    @if($address[0]->state != '') 
                                        {{$address[0]->state}}, 
                                    @endif 

                                    @if($address[0]->postal_code != '') 
                                        {{$address[0]->postal_code}}
                                    @endif

                                    @if($address[0]->country != '') 
                                        {{$address[0]->country}} 
                                    @endif
                                @endif
                            </h6>
                            <h6>
                                <b>{{trans('label.payment_method')}} :</b>
                                @if($order->payment_by == 1)
                                    COD
                                @elseif($order->payment_by == 2)
                                    Ipay
                                @elseif($order->payment_by == 3)
                                    {{trans('label.wallet')}}
                                @elseif($order->payment_by == 4)
                                    {{trans('label.manual_bank_transfer')}}
                                @endif
                            </h6>
                            @if($order->status == 'pending')
                                <span class="btn btn-info m-badge--wide delivery-status">{{trans('label.to_ship')}}</span>
                            @elseif($order->status == 'shipped')
                                <span class="btn btn-warning m-badge--wide delivery-status">{{trans('label.shipped')}}</span>
                            @elseif($order->status == 'delivered')
                                <span class="btn btn-success m-badge--wide delivery-status">{{trans('label.delivered')}}</span>
                            @elseif($order->status == 'rejected')
                                <span class="btn btn-danger m-badge--wide delivery-status">{{trans('label.rejected')}}</span> {{($order->cancel_order_reason) ? '- due to '.strtolower($order->cancel_order_reason) : ''}}
                            @elseif($order->status == 'cancelled')
                                <span class="btn btn-danger m-badge--wide delivery-status">{{trans('label.cancelled')}}</span> {{($order->cancel_order_reason) ? '- due to '.strtolower($order->cancel_order_reason) : ''}}
                            @elseif($order->status == 'pending_payment')
                                <span class="btn btn-info m-badge--wide delivery-status">{{trans('label.pending_payment')}}</span>
                            @endif
                        </div>
                    </div>
                    @if($order->status == 'pending_payment')
                        <div class="alert alert-danger mt-4" role="alert">
                            {{trans('label.order_is_not_processed_due_to_insufficient_balance')}}
                        </div>
                    @endif
                    <?php $shipping_fees = 0; ?>
                    @foreach($result as $key => $item)
                        <div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
                            <div class="col-12 table-responsive">
                                <table class="table voucher-table">
                                    <thead>
                                        <tr>
                                            <th width="50%" class="font-16 text-black font-GilroySemiBold">{{trans('label.products_ordered')}}</th>
                                            <th width="15%"></th>
                                            <th width="15%" class="font-14 text-gray font-GilroyMedium text-center text-nowrap">
                                                {{trans('label.unit_price')}}
                                            </th>
                                            <th width="10%" class="font-14 text-gray font-GilroyMedium text-center text-nowrap">
                                                {{trans('label.amount')}}
                                            </th>
                                            <th width="10%" class="font-14 text-gray font-GilroyMedium text-right text-nowrap">
                                                {{trans('label.item_subtotal')}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5">
                                                <div class="d-flex align-items-center">
                                                    <img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{ $item['image'] }}" class="img-fluid max-w-35px mr-2"
                                                    alt="">
                                                    <span>{{$item['seller_name']}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @foreach($item['products'] as $product)
                                            <?php //$product = $productitem->productdetails; 
                                            $productitem = $product;  ?>
                                            <tr>
                                                <td class="font-14 align-middle">
                                                    <a href="{{ route('productDetail',$product->slug) }}" class="d-flex align-items-center">
                                                        <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $product->images[0]->thumb }}" class="img-fluid max-w-70px mr-3 prd-image"
                                                        alt="">
                                                        <span>{{$product->name}}</span>
                                                    </a>
                                                </td>
                                                @if($productitem->variation_id != 0 && isset($productitem->variation))
                                                <?php $variation = implode(', ', $productitem->variation->variation); ?> 
                                                <td class="text-gray font-14 align-middle">{{trans('label.variation')}}: {{$variation}}</td>
                                                @else
                                                    <td class="text-gray font-14 align-middle"></td>
                                                @endif
                                                <td class="font-14 text-center align-middle">RM{{number_format(($productitem->variation_id != 0 && isset($productitem->variation)) ? $productitem->variation->sell_price : $product->sell_price,2)}}</td>
                                                <td class="font-14 text-center align-middle">{{$productitem->qty}}</td>
                                                <input type="hidden" name="subtotal[]" value="{{number_format(($productitem->variation_id != 0 && isset($productitem->variation)) ? $productitem->variation->sell_price * $productitem->qty : $product->sell_price * $productitem->qty,2)}}">
                                                <td class="text-right font-14 align-middle">RM{{number_format(($productitem->variation_id != 0 && isset($productitem->variation)) ? $productitem->variation->sell_price * $productitem->qty : $product->sell_price * $productitem->qty,2)}}</td>
                                            </tr>
                                        @endforeach
                                        <!-- <tr class="border-top border-bottom border-secondary">
                                            <td class="font-14 align-middle text-right font-GilroyMedium" colspan="2">Shop
                                            Voucher</td>
                                            <td class="text-right font-16 align-middle" colspan="3">
                                                <span class="cursor-pointer text-light-blue font-GilroySemiBold"
                                                data-toggle="modal" data-target="#modalVoucher">Select Voucher</span>
                                            </td>
                                        </tr> -->
                                        <?php $sellerWiseDiscount = 0;?>
                                        @if($order->orderVouchers && count($order->orderVouchers) > 0 && isset($order->orderVouchers[$key]))
                                            @if($order->orderVouchers[$key]->discount && $order->orderVouchers[$key]->discount > 0)
                                                <tr class="border-bottom border-secondary">
                                                    <td></td>
                                                    <td class="font-GilroySemiBold text-black">{{trans('label.shop_voucher')}}:</td>
                                                    <td class="font-14 text-center align-middle">{{$order->orderVouchers[$key]->voucher->code}}</td>
                                                    <td class="text-right font-14 align-middle" colspan="2">{{trans('label.discount')}} : RM{{number_format($order->orderVouchers[$key]->discount,2)}}</td>
                                                    <?php $sellerWiseDiscount = $order->orderVouchers[$key]->discount; ?>
                                                </tr>
                                            @elseif($order->orderVouchers[$key]->cashback > 0)
                                                <tr class="border-bottom border-secondary">
                                                    <td></td>
                                                    <td class="font-GilroySemiBold text-black">{{trans('label.shop_voucher')}}:</td>
                                                    <td class="font-14 text-center align-middle">{{$order->orderVouchers[$key]->voucher->code}}</td>
                                                    <td class="text-right font-14 align-middle" colspan="2">{{trans('label.cashback')}} : {{number_format($order->orderVouchers[$key]->cashback,2)}}</td>
                                                </tr>
                                            @endif
                                        @endif
                                        <tr class="border-bottom border-secondary">
                                            <!--  <td class="border-right border-secondary">
                                                    <div class="row align-items-center">
                                                        <div class="col-auto pr-0">
                                                            <span class="text-black font-14 font-GilroyMedium">Message:</span>
                                                        </div>
                                                        <div class="col-8 col-sm-9">
                                                            <div class="form-group mb-0">
                                                                <div class="from-inner-space">
                                                                    <input class="form-control" type="text"
                                                                    placeholder="(Optional) Leave a message to seller">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>-->
                                            <td class="font-14 text-slate-green align-middle font-GilroyMedium">{{trans('label.shipping_option')}}:</td>
                                            <td></td>
                                            <td class="font-14 align-middle">
                                                <div class="font-GilroySemiBold text-black">{{($item['shipping_company']) ? $item['shipping_company']->name : trans('label.no_shipping_available')}}</div>
                                                <!-- <div class="text-gray font-10 font-GilroyMedium">Receive by 29 Jul - 3 Aug</div> -->
                                            </td>
                                            <td class="text-right font-14 align-middle">    
                                                <?php 
                                                    $seller_shipping = ($item['shipping_company']) ? $item['shipping_company']->price : 0;
                                                    $shipping_fees += $seller_shipping; 
                                                ?>
                                            </td>  
                                            <td class="text-right font-14 align-middle">RM{{$seller_shipping}}</td>
                                        </tr>
                                        <tr>
                                            <td class="font-14 align-middle text-right font-GilroyMedium" colspan="5">
                                                <div class="d-flex align-items-center justify-content-end">
                                                    <p class="text-gray font-14 font-GilroyMedium mb-0">{{trans('label.order_total')}} ({{$item['totalitems']}} @if($item['totalitems'] == 1) {{trans('label.item')}} @else {{trans('label.items')}} @endif):
                                                    </p>
                                                    <span class="text-orange font-22 font-GilroyBold ml-3">RM{{number_format((($item['seller_total'] + $seller_shipping)),2)}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-12 text-right pt-2">
                                    <button type="button" class="btn btn-green-seller font-GilroyMedium text-white font-14 py-1 rounded px-4 mr-md-2 contactseller" onclick="contactsell(this);"  data-id="{{App\Helpers\Helper::encrypt($item['seller_id'])}}">
                                        {{trans('label.contact_seller')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- <div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
                        <div class="col-12 col-sm-6">
                            <h4 class="text-black font-GilroyBold font-18 mb-sm-0">Shopee Voucher</h4>
                        </div>
                        <!-- <div class="col-12 col-sm-6 text-sm-right">
                            <span class="cursor-pointer text-light-blue font-GilroySemiBold" data-toggle="modal"
                            data-target="#modalVoucher">Select Voucher</span>
                        </div> ->

                        <div class="col-12 my-2">
                            <hr>
                        </div>

                        <div class="col-12 col-md-6">
                            <h4 class="text-black font-GilroyBold font-18 mb-lg-0"><img
                                src="assets/images/dollor-orange.png" class="img-fluid max-w-20px mr-2" alt=""> Shopee
                                Coins <span class="text-gray font-14 ml-3">Coins cannot be redeemed</span></h4>
                            </div>
                            <div class="col-12 col-md-6 text-md-right">
                                <div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
                                    <input type="checkbox" class="custom-control-input" id="All" disabled>
                                    <label class="custom-control-label text-medium-gray font-GilroySemiBold font-16 pl-2"
                                    for="All">[-RM0.00]</label>
                                </div>
                            </div>
                    </div> -->
                    <div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
                        <div class="col-12 col-lg-3">
                            <h4 class="text-black font-GilroyBold font-22 mb-lg-0">{{trans('label.payment_method')}}</h4>
                        </div>
                        <div class="col-12 col-lg-9">
                            <div class="payment_radio_container">
                                <!-- <input class="d-none" type="radio" name="radio" id="Cash" disabled>
                                <label for="Cash">Cash on Delivery</label> -->
                                @if($order->payment_by == '2')
                                <input class="d-none" type="radio" name="payment_method" value="2" id="Online" checked>
                                <label for="Online">Ipay</label>
                                @elseif($order->payment_by == '3')
                                <input class="d-none" type="radio" name="payment_method" value="2" id="Online" checked>
                                <label for="Online">{{trans('label.wallet')}}</label>
                                @endif
                                    <!--    <input class="d-none" type="radio" name="radio" id="Maybank2u">
                                        <label for="Maybank2u">Maybank2u</label>
                                        <input class="d-none" type="radio" name="radio" id="Maxshop">
                                        <label for="Maxshop">Maxshop Pay</label>
                                        <input class="d-none" type="radio" name="radio" id="Credit">
                                        <label for="Credit">Credit/Debit Card</label> -->
                            </div>
                        </div>
                        <div class="col-12 mt-4">
                            <hr>
                        </div>
                        @if($order->status == 'pending_payment')
                        <div class="col-12 col-lg-3">
                            <h4 class="text-black font-GilroyBold font-22 mb-lg-0">{{trans('label.credit_balance')}}</h4>
                        </div>
                        <div class="col-12 col-lg-9">
                            RM{{ Auth::user()->wallet_amount }}
                        </div>
                        @endif
                        <div class="col-12 mt-3">
                            <div class="row justify-content-end">
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                    <!-- <div class="d-flex align-items-center justify-content-between">
                                        <span class="text-gray font-14 font-GilroyMedium">Merchandise Subtotal:</span>
                                        <span class="text-gray font-14 font-GilroyMedium">RM28.99</span>
                                    </div> -->
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <span class="text-gray font-14 font-GilroyMedium">{{trans('label.shipping_total')}}:</span>
                                        <span class="text-gray font-14 font-GilroyMedium">RM{{number_format($order->shipping_charge,2)}}</span>
                                    </div>
                                    <!-- @if($order->product_discount > 0)
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="text-gray font-14 font-GilroyMedium">Voucher Discount:</span>
                                    <span class="text-gray font-14 font-GilroyMedium">- RM{{number_format($order->product_discount,2)}} </span>
                                    </div>
                                    @endif
                                    @if($order->product_cashback > 0)
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <span class="text-gray font-14 font-GilroyMedium">Voucher Cashback:</span>
                                        <span class="text-gray font-14 font-GilroyMedium">{{number_format($order->product_cashback,2)}} </span>
                                    </div>
                                    @endif -->
                                    @if($sellerDiscount > 0)
                                    <div class="d-flex align-items-center justify-content-between mt-3 shopDiscount">
                                        <span class="text-gray font-14 font-GilroyMedium">{{trans('label.discount')}}:</span>
                                        <span class="text-gray font-14 font-GilroyMedium" id="shopDiscount">- RM{{number_format($sellerDiscount,2)}}</span>
                                    </div>
                                    @endif
                                    @if($sellerCashback > 0)
                                    <div class="d-flex align-items-center justify-content-between mt-3 shopCashback">
                                        <span class="text-gray font-14 font-GilroyMedium">{{trans('label.cashback')}}:</span>
                                        <span class="text-gray font-14 font-GilroyMedium" id="shopCashback">{{number_format($sellerCashback,2)}}</span>
                                    </div>
                                    @endif
                                    @if($order->used_coins_in_rm > 0 && $order->used_coins > 0)
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <span class="text-gray font-14 font-GilroyMedium">{{trans('label.used_coins')}}:</span>
                                        <span class="text-gray font-14 font-GilroyMedium">-RM{{number_format($order->used_coins_in_rm,2)}} ({{round($order->used_coins)}} Coins)</span>
                                    </div>
                                    @endif
                                    <div class="d-flex align-items-center justify-content-between mt-3">
                                        <span class="text-gray font-14 font-GilroyMedium">{{trans('label.total_payment')}}</span>
                                        <span class="text-orange font-22 font-GilroyBold">RM{{number_format($sub_total+$order->shipping_charge - $sellerDiscount - $order->product_discount - $order->used_coins_in_rm,2)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <hr>
                        </div>
                        <div class="col-12 mt-2 text-right">
                            @if($order->status == 'pending' || $order->status == 'pending_payment')
                                <button type="button" class="btn bg-orange orange-btn text-white font-16 rounded px-5 font-GilroySemiBold" data-target="#cancelordermodal" data-toggle="modal">
                                    {{trans('label.cancel_order')}}
                                </button>
                                <!--   <a href="{{route('user.order.edit',$order->order_id)}}" 
                                    class="btn bg-orange orange-btn text-white font-16 rounded px-5 font-GilroySemiBold">Edit
                                Order</a> -->
                            @endif
                            @if($order->status == 'pending_payment')
                                <a href="{{route('user.order.payByWallet',$order->order_id)}}" 
                                    class="btn  btn-secondary text-white font-16 rounded px-5 font-GilroySemiBold">{{trans('label.pay_now')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="cancelordermodal" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.cancel_order')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" action="{{route('cancelorder')}}" id="cacelorder">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">

                    <div class="col-12 form-group-sub">
                        <input type="hidden" name="order_id" value="{{$order->order_id}}">
                        <div class="form-group">
                            <div class="from-inner-space">
                                <label class="bmd-label-static">
                                    {{trans('label.reason')}}: <span class="text-red">*</span>
                                </label>
                                <div class="form-element">
                                    <textarea class="form-control m-input" placeholder="{{trans('label.reason')}}"
                                    name="reason" id="reason" required
                                    title="{{trans('label.please_enter_reason')}}"></textarea> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
                        id="address-button">{{trans('label.cancel')}}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>


@endsection
@section('script')
<script type="text/javascript">
    var cancelorder = "{{route('cancelorder')}}";
    // $(document).on('click','#cancelorder',function(e){

    // })
    $("#cacelorder").validate({
      rules: {
        order_id: {
          required: true,
      },
      reason: {
          required: true,
      }
  },
  messages: {
    order_id: {
      required: "",
  },
  reason: {
      required: "Please provide password",
  }
},
errorPlacement: function(label, element) {
    label.addClass('mt-2 text-danger');
    label.insertAfter(element);
},
highlight: function(element, errorClass) {
    $(element).parent().addClass('has-danger')
    $(element).addClass('form-control-danger')
}
});
    $.ajax({
        type:'PUT',
        url: cancelorder,
        data:{
            'order_id': cancelorder,
            'reason': reason
        },
        success: function(response){
                // if(response.status){
                    $('#modalShippingOption'+id).modal('hide');
                    location.reload();
                    // $("#productsection").load(location.href + " #productsection");
                // }
            }
        });

    // $(document).on('click','#contactsell',function(e){
    //     alert();
        // var data = $(this).data('id');
        // $('#reference_id').val(data);
        // $('#contactseller').modal('show');
    // })
    </script>
    @endsection