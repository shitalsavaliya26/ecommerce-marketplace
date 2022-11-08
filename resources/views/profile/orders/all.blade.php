<div class="col-12 mt-2  table-responsive" id="all">
    <table class="table history-table">
        <thead>
            <tr>
                <th scope="col">{{trans('label.order')}}</th>
                <th scope="col">{{trans('label.ordered_on')}}</th>
                <!--  <th scope="col">COURIER COMPANY</th>
                <th scope="col">TRACKING CODE</th> -->
                <th scope="col">{{trans('label.discount')}}</th>
                <th scope="col">{{trans('label.total_amount')}}</th>
                <th scope="col">{{trans('label.status')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td><a href="{{ route('user.orders.view',$order->order_id) }}" class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold">{{ $order->order_id}}</a></td>
                    <td>{{ date('d/m/Y',strtotime($order->created_at)) }}</td>
                    <!-- <td>
                        @if($order->shippingCompany && $order->courier_company_name !=
                        null && $order->courier_company_name != '' )
                        {{ $order->shippingCompany->name }}({{
                            $order->shippingCompany->slug }})
                            @else
                            @foreach($order->counriercompanies as $companyDetail)
                            {{$companyDetail->shippingcomapny['name']}}<br>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            @if($order->tracking_number != null && $order->tracking_number
                            != '')
                            {{ $order->tracking_number }}
                            @else
                            @foreach($order->tracking_no as $track)
                            {{ $track->tracking_number }}<br>
                            @endforeach
                            @endif
                    </td> -->
                    <td>RM {{ number_format(($order->discount + $order->product_discount),2) }}</td>
                    <td>
                        RM {{
                            number_format($order->getorderpricebyidwithoutshipping($order->id),2)
                        }}{{-- +$order->shipping_charge --}}
                    </td>
                    <td>
                        @if($order->status == 'pending_payment')
                            {{trans('label.pending_payment')}}
                        @elseif($order->status == 'pending')
                            {{trans('label.to_ship')}}
                        @else
                            {{ucfirst($order->status)}}
                        @endif
                    </td>
                    <td  data-toggle="collapse" data-target="#order{{$order->id}}"
                        class="accordion-toggle" id="main"><img src="{{ asset('assets/images/add.png') }}" class="select-arrow" style="position: relative;" alt="">
                        <img src="{{ asset('assets/images/minus.png') }}" class="select-arrow d-none" style="position: relative;" alt=""></td>

                </tr>
                <tr id="sub">
                    <td colspan="12" class="hiddenRow">
                        <div class=" collapse" id="order{{$order->id}}">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="20%">{{trans('label.product')}}</th>
                                        <th width="5%">{{trans('label.qty')}}</th>
                                        <th width="7%">{{trans('label.price')}} </th>
                                        <th width="9%">{{trans('label.created')}}</th>
                                        @if($order->status == 'delivered')
                                            <th width="30%">{{trans('label.rate')}}</th>
                                        @endif 
                                        <!-- <th  width="10%">
                                                <a href="{{ route('user.orders.view',$order->order_id) }}"><img src="{{ asset('assets/images/edit.png') }}" class="w-20px h-20px img-fluid"></a> 
                                                <a href="javascript:void(0)"><img src="{{ asset('assets/images/cancel.png') }}" class="w-20px h-20px img-fluid"></a>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderProduct as $product)
                                        @if($product->productdetail && $product->productdetail != null)
                                            <tr>
                                                <td>{{$product->productdetail->name}}</td>
                                                <td>{{$product->qty}}</td>
                                                <td>RM {{round($product->price,2)}}</td>
                                                <td>{{date('d-m-Y H:i:s', strtotime($product->created_at))}}</td>
                                                @if($order->status == 'delivered')
                                                    <td id="product_{{$product->productdetail->id}}_{{$product->id}}">
                                                        @if($product->reviewrating == null)
                                                            <div class="modal-header border-0">
                                                                <button type="button" class="btn orange-btn text-white bg-orange reviewRating" data-orderProductId="{{$product->id}}" data-toggle="modal" data-target=".bd-example-modal-lg" data-productId="{{$product->productdetail->id}}">{{trans('label.review_rating')}}</button>
                                                            </div>
                                                        @else
                                                        <h6> {{trans('label.you_rated')}} {{$product->reviewrating->rate}} <i class="active fa fa-star" aria-hidden="true"></i> </h6>
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endforeach
            @if(count($orders) == 0)
                <tr>
                    <td colspan="7">    
                        {{trans('label.no_order_found')}}.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
    <div class="col-12">
        {{ $orders->render('vendor.default_paginate') }}
    </div>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true" id="reviewRatingModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{route('getproductvoucher')}}" id="reviewForm">
                <input type="hidden" name="product_id" id="product_id" >
                <input type="hidden" name="order_id" id="order_id" >
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exampleModalLabel">{{trans('label.rate_product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <div class="d-flex flex-column flex-sm-row mt-3">
                                <div class="mr-sm-3">
                                    <img id="product_image" src="" class="img-fluid max-w-60px br-15" alt="">
                                </div>
                                <div class="mt-3 mt-sm-0">
                                    <h4 class="text-black font-GilroyBold font-16 mb-0" id="product_name"></h4>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3 text-center">
                            <div class="star-rating">
                                <input id="star-5" type="radio" name="rating" value="5"  checked required/>
                                <label for="star-5" title="5 stars">
                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                </label>
                                <input id="star-4" type="radio" name="rating" value="4" />
                                <label for="star-4" title="4 stars">
                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                </label>
                                <input id="star-3" type="radio" name="rating" value="3" />
                                <label for="star-3" title="3 stars">
                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                </label>
                                <input id="star-2" type="radio" name="rating" value="2" />
                                <label for="star-2" title="2 stars">
                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                </label>
                                <input id="star-1" type="radio" name="rating" value="1" />
                                <label for="star-1" title="1 star">
                                    <i class="active fa fa-star" aria-hidden="true"></i>
                                </label>
                            </div>
                            <div class="review_radio_container">
                                <input class="d-none" type="radio" name="review_type" id="product_quality" value="product_quality" checked>
                                <label for="product_quality">{{trans('label.good_product_quality')}}</label>
                                <input class="d-none" type="radio" name="review_type" id="value_for_money" value="value_for_money">
                                <label for="value_for_money">{{trans('label.good_value_for_money')}}</label>
                                <input class="d-none" type="radio" name="review_type" id="fast_delivery" value="fast_delivery">
                                <label for="fast_delivery">{{trans('label.fast_delivery')}}</label>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="bg-product-rating p-3">
                                <textarea class="form-control border-rating text-medium-gray font-GilroyMedium bg-white font-14" id="exampleFormControlTextarea1" rows="4" placeholder="{{trans('label.tell_others_why_you_loved_this_product')}}." name="description"></textarea>
                                <div class="d-flex flex-column flex-sm-row align-itmes-center mt-3">
                                    <div>
                                        <input type="file" name="camera_img" id="camera_img" class="d-none form-control">
                                        <label class="border-orange font-GilroySemiBold text-orange bg-white font-14 py-2 cursor-pointer px-4" for="camera_img">
                                            <img src="assets/images/camera.png" class="img-fluid mr-2" alt="">{{trans('label.add_photo')}}</label>
                                    </div>
                                    <div class="ml-sm-2">
                                        <input type="file" name="video_img" id="video_img" class="d-none form-control">
                                        <label class="border-orange font-GilroySemiBold text-orange bg-white font-14 py-2 cursor-pointer px-4" for="video_img">
                                            <img src="assets/images/video.png" class="img-fluid mr-2" alt="">{{trans('label.add_video')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="custom-control custom-checkbox review-checkbox mt-2 ml-2">
                                <input type="checkbox" class="custom-control-input form-control" id="check_anonymously" name="check_anonymously" value="1">
                                <label class="custom-control-label text-black font-GilroySemiBold font-16 pl-2" for="check_anonymously">{{trans('label.leave_your_review_anonymously')}}</label>
                                <p class="text-medium-gray font-GilroyMedium font-14 mb-0 pl-2">{{trans('label.hide_username')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn bg-transparent text-black shadow-none"data-dismiss="modal">{{trans('label.cancel')}}</button>
                    <button type="button" class="btn orange-btn text-white bg-orange rounded-0 px-4 shadow-none" id="submitReview">{{trans('label.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
