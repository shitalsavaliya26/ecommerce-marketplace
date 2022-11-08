<div class="row">
    <div class="col-12">
        <h1 class="text-black font-30 font-GilroyBold">{{$product[0]->name}}</h1>
        <h1 class="text-orange font-28 font-GilroyBold mt-3">RM{{number_format($product[0]->customer_price, 2) }} (CP) <del
            class="text-light-gray font-16 font-GilroyMedium">RM{{ number_format($product[0]->sell_price, 2) }} (RSP)</del></h1>

        <div class="d-flex flex-wrap">
            <div class="border-rating rounded-pill d-flex align-items-center px-3 mt-4">
                <img src="{{ asset('assets/images/star.png') }}" class="img-fluid max-w-14px mr-1" alt="">
                <span class="text-black font-16 font-GilroySemiBold">4.1</span>
            </div>
            <div class="ml-3 mt-4">
                <span class="text-black font-16 font-GilroySemiBold">3.1K {{trans('label.ratings')}}</span>
            </div>
            @if($product[0]->sold > 0)
                <div class="ml-3 mt-4">
                    <span class="text-light-gray font-18">|</span>
                </div>
                <div class="ml-3 mt-4">
                    <span class="text-black font-16 font-GilroySemiBold">. {{($product[0]->sold > 1000) ? ceil($product[0]->sold/1000).'K' : $product[0]->sold}} {{trans('label.sold')}} </span>
                </div>
            @endif
        </div>
    </div>
</div>

<!--  <div class="row mt-5 align-items-center">
    <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
        <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">Shop Vouncher</p>
    </div>
    <div class="col-12 col-sm-8 col-lg-7 col-xl-8 mt-3 mt-sm-0">
        <div class="bg-light-pink px-3 py-2 d-inline-block">
            <p class="text-orange font-GilroySemiBold font-16 mb-0">8% Coins Cashback</p>
        </div>
    </div>
</div> -->

@if($productdetail->is_variation == '1')
    <hr class="mt-4" />
    <?php $i = 0; ?>
    <div class="row mt-3 align-items-center">
        <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
            <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">{{trans('label.variation')}}</p>
        </div>
        @foreach($productdetail->attributes as $variation)
            @if($i != 0)
                <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                    <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block"></p>
                </div>
            @endif
            <div class="col-12 col-sm-8 col-lg-7 col-xl-8">
                {{$variation->name}}:
                <div class="radio_container">
                    @foreach($variation->variations as $value)
                    <?php //dd($value->id); ?>
                    <input class="d-none" type="radio" value="{{$value->id}}" name="variation[{{$variation->id}}]" id="{{$value->id}}" @if(in_array($value->id, $product[0]->variation_value)) checked @endif>
                    <label for="{{$value->id}}" >{{$value->variation_value}}</label>
                    @endforeach
                </div>
            </div>
            <?php $i++; ?>
        @endforeach
    </div>
@endif

<div class="row mt-4 align-items-center">
    <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
        <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">{{trans('label.quantity')}}</p>
    </div>
    <div class="col-12 col-sm-8 col-lg-7 col-xl-8 mt-3 mt-sm-0 d-flex align-items-center">
        <div class="d-flex align-items-center">
            <div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer">
                <span class="text-gray font-GilroyMedium font-16" id="minus">-</span>
            </div>
            <div class="text-gray font-16 mx-4" id="increment">
                <input type="hidden" name="product_id" id="product_id" value="{{ App\Helpers\Helper::encrypt($product[0]->product_id) }}">
                <input type="hidden" name="qty" id="qty" value="1">
                1
            </div>
            <div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer">
                <span class="text-gray font-GilroyMedium font-16 " id="plus">+</span>
            </div>
        </div>
        <div class="ml-4">
            <p class="text-gray font-GilroySemiBold font-14 mb-0">{{$product[0]->qty}} {{trans('label.pieces_available')}}</p>
        </div>
    </div>
</div>