<div class="col-12 mt-2  table-responsive" id="pay">
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
            @foreach($topay as $order)
            <tr >
                <td><a href="{{ route('user.orders.view',$order->order_id) }}">{{ $order->order_id}}</a></td>
                <td>{{ date('d/m/Y',strtotime($order->created_at)) }}</td>
                <?php /* <td>
                    @if($order->paypingCompany && $order->courier_company_name !=
                    null && $order->courier_company_name != '' )
                    {{ $order->paypingCompany->name }}({{
                        $order->paypingCompany->slug }})
                        @else
                        @foreach($order->counriercompanies as $companyDetail)
                        {{$companyDetail->paypingcomapny['name']}}<br>
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
                    </td> */ ?> 
                    <td>RM {{ number_format(($order->discount + $order->product_discount),2) }}</td>
                    <td>
                        RM {{
                            number_format($order->getorderpricebyidwithoutshipping($order->id),2)
                        }}{{-- +$order->payping_charge --}}
                    </td>

                    <td>
                        Pending Payment
                    </td>
                    <td  data-toggle="collapse" data-target="#order{{$order->id}}"
                        class="accordion-toggle" id="main"><img src="{{ asset('assets/images/add.png') }}" class="select-arrow" style="position: relative;" alt="">
                        <img src="{{ asset('assets/images/minus.png') }}" class="select-arrow d-none" style="position: relative;" alt=""></td>

                    </tr>
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
                                        <!-- @if($order->status == 'delivered')
                                        <th width="59%">Rate</th>
                                        @endif -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderProduct as $product)
                                        @if($product->productdetail &&$product->productdetail != null)
                                            <tr>
                                                <td>{{$product->productdetail->name}}</td>
                                                <td>{{$product->qty}}</td>
                                                <td>{{$product->price}}</td>
                                                <td>{{date('d-m-Y H:i:s', strtotime($product->created_at))}}</td>
                                                <!-- @if($order->status == 'delivered')
                                                    <td id="product-rate-div">
                                                        <form id="rateProduct{{$product->id}}">
                                                            {{ csrf_field() }}
                                                            <div class="row">
                                                                <input type="hidden" name="orderProductId" value="{{$product->id}}" id="orderProductId">
                                                                <input type="hidden" name="productId" value="{{$product->productdetail->id}}" id="productId">
                                                                <div class="col-3">
                                                                    <input type="number" name="rate" class="form-control login-border login-ph mt-2" min="1" max="5" value="5" id="rate">
                                                                </div>
                                                                <div class="col-9">
                                                                    <textarea id="description" name="description" rows="4" cols="50" class="form-control login-border login-ph mt-2"> </textarea>
                                                                </div>
                                                                <div class="col-lg-3">
                                                                    <br /><br /><br />
                                                                    <label class="col-form-label">Product Images</label>
                                                                </div>
                                                                <div class="col-lg-9 col-md-9 col-sm-12">
                                                                    <div class="m-dropzone dropzone m-dropzone--primary productDropZonenew" id="productDropZonenew{{$product->id}}"action="/" method="post">
                                                                        <div class="m-dropzone__msg dz-message needsclick">
                                                                            <h3 class="m-dropzone__msg-title">Drop image here</h3>
                                                                            <span class="m-dropzone__msg-desc">Allowed only image files</span>
                                                                        </div>
                                                                        <div id="image_data"></div>
                                                                        <div id="image-holder"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 mt-3 submitreview" data-id="{{$product->id}}" id="submitreview{{$product->id}}"> Submit your review</button>
                                                    </td>
                                                @endif -->
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>
            @endforeach
            @if(count($topay) == 0)
            <tr>
                <td colspan="7">    
                    {{trans('label.no_order_found')}}.
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <div class="col-12">
        {{ $topay->render('vendor.default_paginate') }}
    </div>
</div>
