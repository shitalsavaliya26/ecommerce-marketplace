@extends('layouts.main')
@section('title', 'Promotion')
@section('css')
@endsection
@section('content')

<?php $current_content = null; ?>
@foreach($contents as $content)
<?php $last_content = $current_content; $current_content = $content->type; $i=1;  ?>

@if($content->type == 'html')
<div class="@if($last_content == 'product_slider')  mt-250px @endif">

    {!! $content->content !!}
</div>
@elseif($content->type == 'product_slider')
<section class="bg-dark-blue py-5 py-lg-0">
    <div class="container-fluid">
        <div class="row -mb-150px">
            <div class="col-12 px-md-0">
                <div class="promotion-slider">
                    @foreach($content->products as $product)
                    <?php $product = $product->product; ?>
                    <div>
                        <div class="bg-product-promo p-4 d-flex flex-column justify-content-end">
                            <div class="d-flex flex-column justify-content-end align-items-center">
                                <div class="mb-2">
                                    <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ ($product->images->count() > 0) ? $product->images[0]->thumb : '' }}" class="img-fluid d-block mx-auto prd-image" alt="">
                                </div>
                                <h4 class="text-black font-20 font-GilroyBold text-center">{{$product->name}}</h4>
                                <h4 class="text-gray font-16 font-GilroyRegular mb-0 mt-2">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->customer_price,2) : number_format($product->customer_price, 2) }} (RSP)</h4>
                                <h1 class="text-orange font-24 font-GilroyBold">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->sell_price,2) : number_format($product->sell_price, 2) }} (CP)</h1>
                                <a href="{{ route('productDetail',$product->slug) }}" class="btn bg-orange orange-btn text-white font-14 py-1 px-3 mt-2 font-GilroyMedium">{{trans('label.shop_now')}}</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@if($i == $content->count())
<div class="mt-250px"></div>
@endif
@elseif($content->type == 'voucher')
<section class="bg-gray pt-2 pb-4">
    <div class="container @if($last_content == 'product_slider')  mt-150px @endif">
        <div class="bg-white br-15 py-5 px-sm-3 shadow">
            <div class="row mx-0">
                <div class="col-12 text-center">
                    <h4 class="text-black font-20 font-GilroyBold mb-0">{{trans('label.vouchers_claim')}}</h4>
                </div>
            </div>
            <div class="row mx-0">
                @foreach($content->vouchers as $voucher)
                <div class="col-12 col-md-6 col-xl-4 mt-4">
                    <div class="row align-items-center h-100 mx-0">
                        @if($voucher->redeemed)
                        <img src="{{ asset('assets/images/stamp.png') }}" class="img-fluid redeemed-stamp-img" alt="">
                        @endif
                        <div
                        class="col-3 col-xl-4 bg-orange p-3 h-100 d-flex align-items-center justify-content-center vouncher-galore1">
                        <p class="font-GilroyBold text-white text-center font-16 text-uppercase mb-0 text-break">{{substr($voucher->voucher->code, 0, 10)}}<br>{{substr($voucher->voucher->code, 10)}}</p>
                    </div>
                    <div class="col-9 col-xl-8 border-vouncher-galore vouncher-galore2">
                        <div class="p-3 vouncher-galore3">
                            <p class="font-GilroyBold text-black font-14 mb-0">{{$voucher->voucher->name}}</p>
                            <p class="font-GilroyMedium text-gray font-8 mb-0">{{trans('label.valid_till')}} {{date("d M", strtotime($voucher->voucher->to_date))}}</p>
                            <p class="font-GilroyBold text-black font-14 mb-0">{{trans('label.min_spend')}} RM{{$voucher->voucher->min_basket_price}}</p>
                            <div class="d-flex justify-content-between align-items-end">
                                @if($voucher->claimed)
                                <a href="@if(!auth()->check()) {{route('login')}} @else javascript:void(0) @endif" data-id="{{App\Helpers\Helper::encrypt($voucher->voucher->id)}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 py-1 font-GilroyMedium mt-2 redeem redeem-button">{{trans('label.use')}}</a>
                                @else
                                <a href="@if(!auth()->check()) {{route('login')}} @else javascript:void(0) @endif" data-id="{{App\Helpers\Helper::encrypt($voucher->voucher->id)}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 py-1 font-GilroyMedium mt-2 claim claim-button">{{trans('label.claim')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</section>
@elseif($content->type == 'vouchers_redeem')
<section class="bg-gray pt-2 pb-4">
    <div class="container @if($last_content == 'product_slider')  mt-150px @endif">
        <div class="bg-white br-15 py-5 px-sm-3 shadow">
            <div class="row mx-0">
                <div class="col-12 text-center">
                    <h4 class="text-black font-20 font-GilroyBold mb-0">{{trans('label.vouchers_redeem')}}</h4>
                </div>
            </div>
            <div class="row mx-0">
                @foreach($content->vouchers as $voucher)
                <div class="col-12 col-md-6 col-xl-4 mt-4">
                    <div class="row align-items-center h-100 mx-0">
                        @if($voucher->redeemed)
                        <img src="{{ asset('assets/images/stamp.png') }}" class="img-fluid redeemed-stamp-img" alt="">
                        @endif
                        <div
                        class="col-3 col-xl-4 bg-orange p-3 h-100 d-flex align-items-center justify-content-center vouncher-galore1">
                        <p class="font-GilroyBold text-white text-center font-16 text-uppercase mb-0 text-break">{{substr($voucher->voucher->code, 0, 10)}}<br>{{substr($voucher->voucher->code, 10)}}</p>
                    </div>
                    <div class="col-9 col-xl-8 border-vouncher-galore vouncher-galore2">
                        <div class="p-3 vouncher-galore3">
                            <p class="font-GilroyBold text-black font-14 mb-0">{{$voucher->voucher->name}}</p>
                            <p class="font-GilroyMedium text-gray font-8 mb-0">{{trans('label.valid_till')}} {{date("d M", strtotime($voucher->voucher->to_date))}}</p>
                            <p class="font-GilroyBold text-black font-14 mb-0">{{trans('label.min_spend')}} RM{{$voucher->voucher->min_basket_price}}</p>
                            <div class="d-flex justify-content-between align-items-end">
                                <a href="@if(!auth()->check()) {{route('login')}} @else javascript:void(0) @endif" data-id="{{App\Helpers\Helper::encrypt($voucher->voucher->id)}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 py-1 font-GilroyMedium mt-2 redeem redeem-button">{{trans('label.redeem')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</section>
@elseif($content->type == 'products_grid')
<section class="bg-gray py-4">
    <div class="container @if($last_content == 'product_slider')  mt-150px @endif">
        <div class="bg-white br-15 py-3 px-sm-3 shadow">
            <div class="row mx-0">
                @foreach($content->products as $product)
                <?php $product = $product->product; ?>
                <div class="col-12 col-md-6 col-xl-3 mt-3">
                    <div class="overflow-hidden">
                        <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ ($product->images->count() > 0) ? $product->images[0]->thumb : '' }}" class="img-fluid prd-image" alt="">
                        <div class="py-2">
                            <h4 class="text-black font-16 font-GilroyBold">{{$product->name}}</h4>
                            <div class="d-flex align-items-center">
                                <button class="btn local-seller-btn py-1 px-2 font-GilroyMedium">{{$product->seller->name}}</button>
                                @if($product->cod)
                                <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                                @endif
                                <div class="ml-3">
                                    <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                                    <span class="text-light-gray font-10">{{$product->seller->state}}</span>
                                </div>
                            </div>
                            <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->sell_price,2) : number_format($product->sell_price, 2) }} (CP)
                                <span class="text-light-gray font-10 font-weight-normal">RM{{($product->is_variation == '1' && $product->variation) ? number_format($product->variation->customer_price,2) : number_format($product->customer_price, 2) }} (RSP) </span>
                            </h4>
                            <h4 class="text-light-gray font-12 font-weight-normal">
                                <span class="text-black mr-1">
                                    @if($product->avgReviewRating() > 0)
                                    <img src="{{asset('assets/images/Review.png')}}"
                                    class="img-fluid w-7px mb-1" alt="">
                                    {{number_format($product->avgReviewRating(),1) }}
                                    @endif
                                </span>
                                @if($product->countReviewRating() > 0)
                                ({{$product->countReviewRating() }}) @if($product->sold > 0).@endif
                                @endif
                                @if($product->sold > 0) {{($product->sold > 1000) ? ceil($product->sold/1000).'K' : $product->sold}} {{trans('label.sold')}} @endif
                            </h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @if($content->content)
            <div class="row mx-0 pb-3">
                <div class="col-12 mt-3 text-center">
                    <a href="{{$content->content}}" 
                        class="btn bg-orange orange-btn text-white font-14 rounded-1 px-80 py-1 font-GilroyMedium">{{trans('label.view_more')}}</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif
<?php $i++; ?>
@endforeach


@endsection
@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var claimurl  = "{{ route('claimvoucher') }}";
    var redeemurl  = "{{ route('redeemVoucher') }}";
    var checkouturl  = "{{ route('checkout') }}";

    var promotion = "{{ $promotion->slug }}";


</script>
<script src="{{ asset('assets/js/promotion.js').'?v='.time() }}"></script>


@endsection
