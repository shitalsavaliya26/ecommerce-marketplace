<div class="row justify">
    @foreach($products as $product)
    <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-2 cus-col-xl-search px-2 mt-4">
        <a href="{{ route('productDetail',$product->slug) }}">
            <div class="overflow-hidden bg-white h-100">
                <div class="position-relative">
                    @if($product->images && count($product->images) > 0)
                    <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $product->images[0]->thumb }}" class="img-fluid imgprd prd-image" alt="">
                    @else
                    <img src="{{asset('images/product/product-placeholder.png')}}" class="img-fluid" alt="">
                    @endif

                   <!--  <div class="product-offer-position bg-light-blue py-1 px-3 font-GilroyBold font-12 text-white">
                        10% Cashback
                    </div> -->
                </div>
                <div class="py-2 px-3">
                    <h4 class="text-black font-16 font-GilroyBold mb-0">{{$product->name}}</h4>
                    <div class="d-flex align-items-center flex-wrap">
                        <button class="btn local-seller-btn py-1 px-2 mt-2 mr-2">{{$product->seller->name}}</button>
                        @if($product->cod)
                        <button class="btn cod-btn py-1 px-2 mt-2 mr-3">COD</button>
                        @endif
                        <div class="mt-2">
                            <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                            <span class="text-light-gray font-10">Selangor</span>
                        </div>
                    </div>
                    <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                        RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->sell_price,2) : number_format($product->sell_price, 2) }}  (CP) <span
                        class="text-light-gray font-10 font-weight-normal">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->customer_price,2) : number_format($product->customer_price, 2) }} (RSP) </span>
                    </h4>
                    <h4 class="text-light-gray font-12 font-weight-normal">
                        <span class="text-black mr-1">
                            @if($product->avgReviewRating() > 0)
                            <img src="{{asset('assets/images/Review.png')}}" class="img-fluid w-7px mb-1" alt="">
                            {{number_format($product->avgReviewRating(),1) }}
                            @endif
                        </span>
                        @if($product->countReviewRating() > 0)
                        ({{$product->countReviewRating() }})
                        @endif
                        @if($product->sold > 0). {{($product->sold > 1000) ? ceil($product->sold/1000).'K' :
                        $product->sold}} {{trans('label.sold')}} @endif
                    </h4>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="row mt-5">
    <div class="col-12">
        {{ $products->render('vendor.default_paginate') }}
    </div>
</div>