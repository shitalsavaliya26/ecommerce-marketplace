 <div class="col-12 bg-orange p-4">
    <div class="d-flex flex-column flex-md-row align-items-center">
        <h4 class="text-white font-22 font-GilroySemiBold mb-0">Shocking Sales</h4>
        <a href="{{route('shockingsale')}}" class="pull-right">See all ></a>
        <!-- <div class="countdown ml-md-5 mt-3 mt-md-0">
            <div class="bloc-time hours" data-init-value="24">
                <div class="figure hours hours-1">
                    <span class="top">2</span>
                    <span class="top-back">
                        <span>2</span>
                    </span>
                    <span class="bottom">2</span>
                    <span class="bottom-back">
                        <span>2</span>
                    </span>
                </div>

                <div class="figure hours hours-2">
                    <span class="top">4</span>
                    <span class="top-back">
                        <span>4</span>
                    </span>
                    <span class="bottom">4</span>
                    <span class="bottom-back">
                        <span>4</span>
                    </span>
                </div>
            </div>

            <div class="bloc-time min" data-init-value="0">
                <div class="figure min min-1">
                    <span class="top">0</span>
                    <span class="top-back">
                        <span>0</span>
                    </span>
                    <span class="bottom">0</span>
                    <span class="bottom-back">
                        <span>0</span>
                    </span>
                </div>

                <div class="figure min min-2">
                    <span class="top">0</span>
                    <span class="top-back">
                        <span>0</span>
                    </span>
                    <span class="bottom">0</span>
                    <span class="bottom-back">
                        <span>0</span>
                    </span>
                </div>
            </div>

            <div class="bloc-time sec" data-init-value="0">
                <div class="figure sec sec-1">
                    <span class="top">0</span>
                    <span class="top-back">
                        <span>0</span>
                    </span>
                    <span class="bottom">0</span>
                    <span class="bottom-back">
                        <span>0</span>
                    </span>
                </div>

                <div class="figure sec sec-2">
                    <span class="top">0</span>
                    <span class="top-back">
                        <span>0</span>
                    </span>
                    <span class="bottom">0</span>
                    <span class="bottom-back">
                        <span>0</span>
                    </span>
                </div>
            </div>
        </div> -->
    </div>
</div>

<div class="col-12 pb-5">
    <div class="slider-grid-6 pt-4 py-5">
        @foreach($sockingSale as $productdetail)
        <?php $product = $productdetail->product; ?>
        <div class="overflow-hidden  px-2">
            <a href="{{ route('productDetail',$product->slug) }}">
                <div class="position-relative">
                    <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ @$product->images[0]->thumb }}" class="img-fluid d-block mx-auto prd-image" alt="">
                    <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                    alt="">
                    <div class="shocking-sale-offer-label-text">
                        <h3 class="font-GilroySemiBold font-16 text-white mb-0">{{$productdetail->discount}}%</h3>
                        <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                    </div>
                    <div class="timer">
                        <div class="flipper myFlipper" data-reverse="true" data-datetime="{{$productdetail->end_date}}" data-template="dd|HH|ii|ss" data-labels="" id="{{App\Helpers\Helper::encrypt($productdetail->id)}}"></div>
                    </div>
                    
                </div>
                <div class="py-2">
                    <h4 class="text-black font-16 font-GilroyBold">{{$product->name}}
                    </h4>
                    <div class="d-flex align-items-center">
                        <button class="btn local-seller-btn py-1 px-2">{{$product->seller->name}}</button>
                        @if($product->cod)
                        <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                        @endif
                        <div class="ml-3">
                            <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px inline-block" alt="">
                            <span class="text-light-gray font-10">{{$product->seller->state}}</span>
                        </div>
                    </div>
                    <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->sell_price,2) : number_format($product->sell_price, 2) }} (CP)
                        <span class="text-light-gray font-10 font-weight-normal">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->customer_price,2) : number_format($product->customer_price, 2) }} (RSP) </span>
                    </h4>
                    <h4 class="text-light-gray font-12 font-GilroyMedium">
                        <span class="text-black mr-1 font-GilroySemiBold">
                            @if($product->avgReviewRating() > 0)
                            <img src="{{asset('assets/images/Review.png')}}"
                            class="img-fluid w-7px mb-1" alt="">
                            {{number_format($product->avgReviewRating(),1) }}
                        @endif</span>
                        @if($product->countReviewRating() > 0)
                        ({{$product->countReviewRating() }}) @if($product->sold > 0).@endif
                        @endif  @if($product->sold > 0) {{($product->sold > 1000) ? ceil($product->sold/1000).'K' : $product->sold}} {{trans('label.sold')}} @endif
                    </h4>
                </div>
                
                <div class="progress sale-progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$productdetail->percent_archived['percent']}}%;" aria-valuenow="25"
                        aria-valuemin="0" aria-valuemax="100"><span class="total-sale">{{$productdetail->percent_archived['sold']}} {{trans('label.sold')}}</span></div>

                    </div>
                    
                </a>
            </div>
            @endforeach
       <!--  <div class="overflow-hidden">
            <div class="position-relative">
                <img src="{{asset('images/product/1649314594423499877.jpeg')}}" onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"  class="img-fluid" alt="">
                <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                alt="">
                <div class="shocking-sale-offer-label-text">
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">10%</h3>
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                </div>
            </div>
            <div class="py-2">
                <h4 class="text-black font-16 font-GilroyBold">Bird’s Nest Shot 97
                </h4>
                <div class="d-flex align-items-center">
                    <button class="btn local-seller-btn py-1 px-2">Local Seller</button>
                    <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                    <div class="ml-3 d-flex align-items-center">
                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                        <span class="text-light-gray font-10 ml-2">Selangor</span>
                    </div>
                </div>
                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP)
                    <span class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                </h4>
                <h4 class="text-light-gray font-12 font-GilroyMedium">
                    <span class="text-black mr-1 font-GilroySemiBold">
                        <img src="assets/images/Review.png" class="img-fluid w-7px mb-1 d-inline" alt="">
                    4.8</span>
                    (162) . 1k sold
                </h4>
            </div>
            <div class="progress sale-progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"><span class="total-sale">7 Sold</span></div>
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="position-relative">
                <img src="{{asset('images/product/1649314594423499877.jpeg')}}" onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"  class="img-fluid d-block mx-auto" alt="">
                <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                alt="">
                <div class="shocking-sale-offer-label-text">
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">10%</h3>
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                </div>
            </div>
            <div class="py-2">
                <h4 class="text-black font-16 font-GilroyBold">Bird’s Nest Shot 97
                </h4>
                <div class="d-flex align-items-center">
                    <button class="btn local-seller-btn py-1 px-2">Local Seller</button>
                    <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                    <div class="ml-3 d-flex align-items-center">
                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                        <span class="text-light-gray font-10 ml-2">Selangor</span>
                    </div>
                </div>
                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP)
                    <span class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                </h4>
                <h4 class="text-light-gray font-12 font-GilroyMedium">
                    <span class="text-black mr-1 font-GilroySemiBold">
                        <img src="assets/images/Review.png" class="img-fluid w-7px mb-1 d-inline" alt="">
                    4.8</span>
                    (162) . 1k sold
                </h4>
            </div>
            <div class="progress sale-progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"><span class="total-sale">7 Sold</span></div>
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="position-relative">
                <img src="{{asset('images/product/1649314594423499877.jpeg')}}" onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"  class="img-fluid d-block mx-auto" alt="">
                <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                alt="">
                <div class="shocking-sale-offer-label-text">
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">10%</h3>
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                </div>
            </div>
            <div class="py-2">
                <h4 class="text-black font-16 font-GilroyBold">Bird’s Nest Shot 97
                </h4>
                <div class="d-flex align-items-center">
                    <button class="btn local-seller-btn py-1 px-2">Local Seller</button>
                    <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                    <div class="ml-3 d-flex align-items-center">
                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                        <span class="text-light-gray font-10 ml-2">Selangor</span>
                    </div>
                </div>
                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP)
                    <span class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                </h4>
                <h4 class="text-light-gray font-12 font-GilroyMedium">
                    <span class="text-black mr-1 font-GilroySemiBold">
                        <img src="assets/images/Review.png" class="img-fluid w-7px mb-1 d-inline" alt="">
                    4.8</span>
                    (162) . 1k sold
                </h4>
            </div>
            <div class="progress sale-progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"><span class="total-sale">7 Sold</span></div>
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="position-relative">
                <img src="{{asset('images/product/1649314594423499877.jpeg')}}" onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"  class="img-fluid d-block mx-auto" alt="">
                <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                alt="">
                <div class="shocking-sale-offer-label-text">
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">10%</h3>
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                </div>
            </div>
            <div class="py-2">
                <h4 class="text-black font-16 font-GilroyBold">Bird’s Nest Shot 97
                </h4>
                <div class="d-flex align-items-center">
                    <button class="btn local-seller-btn py-1 px-2">Local Seller</button>
                    <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                    <div class="ml-3 d-flex align-items-center">
                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                        <span class="text-light-gray font-10 ml-2">Selangor</span>
                    </div>
                </div>
                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP)
                    <span class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                </h4>
                <h4 class="text-light-gray font-12 font-GilroyMedium">
                    <span class="text-black mr-1 font-GilroySemiBold">
                        <img src="assets/images/Review.png" class="img-fluid w-7px mb-1 d-inline" alt="">
                    4.8</span>
                    (162) . 1k sold
                </h4>
            </div>
            <div class="progress sale-progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"><span class="total-sale">7 Sold</span></div>
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="position-relative">
                <img src="{{asset('images/product/1649314594423499877.jpeg')}}" onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"  class="img-fluid d-block mx-auto" alt="">
                <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                alt="">
                <div class="shocking-sale-offer-label-text">
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">10%</h3>
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                </div>
            </div>
            <div class="py-2">
                <h4 class="text-black font-16 font-GilroyBold">Bird’s Nest Shot 97
                </h4>
                <div class="d-flex align-items-center">
                    <button class="btn local-seller-btn py-1 px-2">Local Seller</button>
                    <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                    <div class="ml-3 d-flex align-items-center">
                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                        <span class="text-light-gray font-10 ml-2">Selangor</span>
                    </div>
                </div>
                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP)
                    <span class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                </h4>
                <h4 class="text-light-gray font-12 font-GilroyMedium">
                    <span class="text-black mr-1 font-GilroySemiBold">
                        <img src="assets/images/Review.png" class="img-fluid w-7px mb-1 d-inline" alt="">
                    4.8</span>
                    (162) . 1k sold
                </h4>
            </div>
            <div class="progress sale-progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"><span class="total-sale">7 Sold</span></div>
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="position-relative">
                <img src="{{asset('images/product/1649314594423499877.jpeg')}}" onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"  class="img-fluid d-block mx-auto" alt="">
                <img src="{{asset('assets/images/badge.png')}}" class="img-fluid shocking-sale-offer-label"
                alt="">
                <div class="shocking-sale-offer-label-text">
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">10%</h3>
                    <h3 class="font-GilroySemiBold font-16 text-white mb-0">OFF</h3>
                </div>
            </div>
            <div class="py-2">
                <h4 class="text-black font-16 font-GilroyBold">Bird’s Nest Shot 97
                </h4>
                <div class="d-flex align-items-center">
                    <button class="btn local-seller-btn py-1 px-2">Local Seller</button>
                    <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                    <div class="ml-3 d-flex align-items-center">
                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                        <span class="text-light-gray font-10 ml-2">Selangor</span>
                    </div>
                </div>
                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP)
                    <span class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                </h4>
                <h4 class="text-light-gray font-12 font-GilroyMedium">
                    <span class="text-black mr-1 font-GilroySemiBold">
                        <img src="assets/images/Review.png" class="img-fluid w-7px mb-1 d-inline" alt="">
                    4.8</span>
                    (162) . 1k sold
                </h4>
            </div>
            <div class="progress sale-progress">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                aria-valuemin="0" aria-valuemax="100"><span class="total-sale">7 Sold</span></div>
            </div>
        </div> -->
    </div>
</div>