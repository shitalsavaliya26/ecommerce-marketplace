@foreach($categoryProducts as $product)
<div class="col-12 col-sm-6 col-md-4 col-xl-2 px-2 mt-3 append-product" name="append-product">
    <a href="{{ route('productDetail',$product->slug) }}" >
        <div class="">
            @if($product->images && count($product->images) > 0)
            <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $product->images[0]->thumb }}" class="img-fluid prd-image" alt="">
            @else
            <img src="{{asset('images/product/product-placeholder.png')}}" class="img-fluid" alt="">
            @endif
        </div>
        <div class="py-2">
            <h4 class="text-black font-16 font-GilroyBold mb-0">{{$product->name}}</h4>
            <div class="d-flex flex-wrap align-items-center">
                <button class="btn local-seller-btn py-1 px-2 mr-2 mt-2">{{$product->seller->name}}</button>
                @if($product->cod)
                <button class="btn cod-btn py-1 px-2 mr-3 mt-2">COD</button>
                @endif
                <div class="mt-2">
                    <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                    <span class="text-light-gray font-10">{{$product->seller->state}}</span>
                </div>
            </div>
            <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM{{number_format($product->sell_price, 2) }} (CP)
                <span class="text-light-gray font-10 font-weight-normal">RM{{number_format($product->customer_price, 2) }} (RSP) </span>
            </h4>
            <h4 class="text-light-gray font-12 font-weight-normal"><span
                class="text-black mr-1"><img src="{{asset('assets/images/Review.png')}}"
                class="img-fluid w-7px mb-1" alt=""> 0</span>
                (0) @if($product->sold > 0). {{($product->sold > 1000) ? ceil($product->sold/1000).'K' : $product->sold}} {{trans('label.sold')}} @endif </h4>
            </div>
        </a>
    </div>
    @endforeach