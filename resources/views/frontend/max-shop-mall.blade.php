@extends('layouts.main')
@section('title', 'Max Shop Mall')
@section('content')
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 px-0">
                <div class="sale-slider no-margin">
                    @if($seller && $seller->topBanners && count($seller->topBanners) > 0)
                    @foreach ($seller->topBanners as $image)
                    <div>
                        <img src="{{ $image->image }}" class="img-fluid" alt="" style="height:420px; width:1583px "/>
                    </div>
                    @endforeach
                    @else
                    <div>
                        <img src="{{asset('assets/images/All-Category-banner.png')}}" class="img-fluid" alt="">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-orange py-3">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4 text-center text-lg-left">
                <h4 class="text-white mb-0 font-24 font-GilroyBold">{{trans('label.maxshop_mall')}}</h4>
            </div>
            <div class="col-12 col-lg-8">
                <div
                class="d-flex flex-column flex-md-row align-items-md-center justify-content-center justify-content-lg-end">
                <div class="d-flex align-items-center mt-2 mt-lg-0 mr-md-5">
                    <img src="{{asset('assets/images/Authentic.png')}}" class="img-fluid max-w-24px mr-2" alt="">
                    <h4 class="text-white mb-0 font-20 font-GilroyBold">{{trans('label.authentic')}}</h4>
                </div>
                <div class="d-flex align-items-center mt-2 mt-lg-0 mr-md-5">
                    <img src="{{asset('assets/images/Discount.png')}}" class="img-fluid max-w-24px mr-2" alt="">
                    <h4 class="text-white mb-0 font-20 font-GilroyBold">{{trans('label.best_price')}}</h4>
                </div>
                <div class="d-flex align-items-center mt-2 mt-lg-0">
                    <img src="{{asset('assets/images/Returns.png')}}" class="img-fluid max-w-24px mr-2" alt="">
                    <h4 class="text-white mb-0 font-20 font-GilroyBold">{{trans('label.free_returns')}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

@if($categories && count($categories) > 0)
<section class="bg-gray py-4">
    <div class="container">
        <div class="row bg-white br-15 p-4 p-xl-5 mx-0 align-items-center overflow-hidden shadow cus-xl-size-12">
            @foreach($categories as $category)
            @if($category && $category->images && count($category->images) > 0)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                <div>
                    <img onerror="this.src='{{asset('assets/images/Nike.png')}}'"
                    src="{{ $category->images[0]->image }}" class="img-fluid" alt="" style="height:22px; width:128px">
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
@endif
@foreach($displayCategories as $key=>$display)
<section class="bg-gray pt-2 pb-4">
    <div class="container">
        <div class="row bg-white br-15 mx-0 overflow-hidden shadow">
            @if($key % 2 == 0 || $key == 0)
            <div class="col-12 col-lg-4 px-0">
                <div class="sale-slider no-margin">
                    @if($display->displayCategoryBanners && count($display->displayCategoryBanners) > 0)
                    @foreach($display->displayCategoryBanners as $image)
                    <div>
                        <img onerror="this.src='{{asset('assets/images/Homepage-sale-banner-1.png')}}'"
                        src="{{ $image->image }}" class="img-fluid mx-auto br-15" alt="" style="height:793px; width:470px">
                    </div>
                    @endforeach
                    @else
                    <div>
                        <img src="{{asset('assets/images/Homepage-sale-banner-1.png')}}" class="img-fluid br-15 mx-auto"
                        alt="">
                    </div>
                    @endif
                </div>
            </div>
            @endif
            <div class="col-12 col-lg-8">
                <div class="row py-4">
                    <div class="col-12">
                        <h4 class="text-black font-20 font-GilroyExtraBold">{{$display->display_name}}</h4>
                    </div>
                    @if($display->displayCategoryProducts && count($display->displayCategoryProducts) > 0)
                    @foreach($display->displayCategoryProducts as $i=>$product)
                    <?php $product = $product->product;?>
                    @if($product && $product != '')
                    <div class="col-12 col-md-6 col-xl-4 mt-3">
                        <a href="{{ route('productDetail',$product->slug) }}">
                            <div class="overflow-hidden">
                                <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"
                                src="{{ $product->images[0]->thumb }}" class="img-fluid prd-image" alt="" style="" >
                                <div class="py-2">
                                    <h4 class="text-black font-16 font-GilroyBold">{{$product->name}}
                                    </h4>
                                    <div class="d-flex align-items-center">
                                        <button class="btn local-seller-btn py-1 px-2 font-GilroyMedium">{{$product->seller->name}}</button>
                                        @if($product->cod)
                                        <button class="btn cod-btn py-1 px-2 ml-2 font-GilroyMedium">COD</button>
                                        @endif
                                        <div class="ml-3">
                                            <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                                            <span class="text-light-gray font-10 font-GilroyMedium">{{$product->seller->state}}</span>
                                        </div>
                                    </div>
                                    <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                        RM{{number_format($product->sell_price, 2) }} (CP)
                                        <span
                                        class="text-light-gray font-10 font-GilroyMedium">RM{{number_format($product->customer_price,
                                    2) }} (RSP) </span>
                                </h4>
                                <h4 class="text-light-gray font-12 font-GilroyMedium">
                                    <span class="text-black mr-1 font-GilroySemiBold">
                                        @if($product->avgReviewRating() > 0)
                                        <img src="{{asset('assets/images/Review.png')}}" class="img-fluid w-7px mb-1"
                                        alt="">
                                        {{number_format($product->avgReviewRating(),1) }}
                                        @endif
                                    </span>
                                    @if($product->countReviewRating() > 0)
                                    ({{$product->countReviewRating() }})
                                    @endif
                                    {{($product->sold > 1000) ? ceil($product->sold/1000).'K' : $product->sold}} {{trans('label.sold')}}
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
                @endif
                @endforeach
                @else
                <h4>{{trans('label.no_records_found')}}</h4>
                @endif
            </div>
        </div>
        @if($key % 2 != 0 && $key != 0)
        <div class="col-12 col-lg-4 px-0">
            <div class="sale-slider no-margin">
                @if($display->displayCategoryBanners && count($display->displayCategoryBanners) > 0)
                @foreach($display->displayCategoryBanners as $image)
                <div>
                    <img onerror="this.src='{{asset('assets/images/Homepage-sale-banner-1.png')}}'"
                    src="{{ $image->image }}" class="img-fluid mx-auto br-15" alt="" style="height:793px; width:470px">
                </div>
                @endforeach
                @else
                <div>
                    <img src="{{asset('assets/images/Homepage-sale-banner-1.png')}}" class="img-fluid br-15 mx-auto"
                    alt="">
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
</section>
@endforeach

<section class="bg-dark-blue py-5 py-lg-0">
    <div class="container pt-4">
        <div class="row -mb-150px">
            <div class="col-12">
                <div class="sale-slider">

                    @if($seller && $seller->lastBanners && count($seller->lastBanners) > 0)
                    @foreach ($seller->lastBanners as $image)
                    <div>
                        <img src="{{ $image->image }}" class="img-fluid" alt="" style="height:369px; width:1390px "/>
                    </div>
                    @endforeach
                    @else
                    <div>
                        <img src="{{asset('assets/images/All-Category-banner.png')}}" class="img-fluid" alt="">
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-gray py-4">
    <div class="container mt-150px">
        <div class="mt-4 bg-white br-15 py-3 px-sm-3 shadow">
            <div class="row mx-0 align-items-center justify-content-between">
                <div class="col-sm-1 col-xl-auto">
                    <div id="left-arrow">
                        <img src="{{asset('/public/frontend/images/Homepage-arrow.png')}}"
                        class="img-fluid w-7px cursor-pointer rotate-180" alt="">
                    </div>
                </div>
                <div class="col-sm-10 col-xl-11">
                    <ul class="home-tabs list-unstyled mb-0 tab-slider">
                        @foreach($categories as $key=>$category)
                        <li class="nav-item category-list" name="{{ $category->slug }}">
                            <a class="nav-link @if ($key == 0) active @endif category"
                            id="{{$category->slug}}">{{$category->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-1 col-xl-auto text-sm-right">
                    <div id="right-arrow">
                        <img src="{{asset('/public/frontend/images/Homepage-arrow.png')}}" class="img-fluid w-7px cursor-pointer" alt="">
                    </div>
                </div>
            </div>

            <div class="row mx-0 category-product" id="category-product">

            </div>

            <div class="row mx-0 pb-3">
                <div class="col-12 mt-3 text-center">
                    <a class="btn bg-orange orange-btn text-white font-14 rounded-1 px-80 py-1 font-GilroyMedium"
                    id="loadMore">{{trans('label.view_more')}}</a>
                </div>
            </div>
        </div>
    </div>
</section>

@if($products && count($products) > 0)
<section class="bg-gray pb-5">
    <div class="container">
        <div class="row bg-white br-15 p-3 mx-0 shadow">
            @foreach($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-xl-2 px-2 mt-3">
                <a href="{{ route('productDetail',$product->slug) }}" >
                    <div class="overflow-hidden">
                        <div class="">
                            @if($product->images && count($product->images) > 0)
                            <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"
                            src="{{ $product->images[0]->thumb }}" class="img-fluid d-block mx-auto prd-image" style="height:212px, width:315px">
                            @else
                            <img src="{{asset('images/product/product-placeholder.png')}}" class="img-fluid" alt="">
                            @endif
                        </div>
                        <div class="py-2">
                            <h4 class="text-black font-16 font-GilroyBold mb-0">{{$product->name}}</h4>
                            <div class="d-flex flex-wrap align-items-center">
                                <button class="btn local-seller-btn py-1 px-2 mr-2 mt-2">Local Seller</button>
                                <button class="btn cod-btn py-1 px-2 mr-3 mt-2">COD</button>
                                <div class="mt-2">
                                    <img src="{{asset('/public/frontend/images/Location.png')}}" class="img-fluid w-7px" alt="">
                                    <span class="text-light-gray font-10">Selangor</span>
                                </div>
                            </div>
                            <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM250.00 (CP) <span
                                class="text-light-gray font-10 font-weight-normal">RM250.00 (RSP) </span>
                            </h4>
                            <h4 class="text-light-gray font-12 font-weight-normal"><span class="text-black mr-1"><img
                                src="{{asset('/public/frontend/images/Review.png')}}" class="img-fluid w-7px mb-1" alt=""> 4.8</span>
                            (162) . 1k sold </h4>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
@section('script')
<script>
    $(window).on('load', function () {
        var name = $(".category-list").attr("name");
        showProduct(name);
    });

    $(".category").click(function () {
        var name = $(this).attr("id");
        showProduct(name);
    });

    $(".category").click(function () {
        var id = $(this).attr("id");
        $(".category").removeClass('active');
        $(this).addClass('active');
        showProduct(id);
    });

    function showProduct(slug) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = "{{ route('show-product',':slug') }}";
        url = url.replace(':slug', slug);
        $.ajax({
            type: 'GET',
            url: url,
            success: function (response) {
                $('#category-product').html(response.view);
                size_li = $("#category-product .append-product").length;
                x = 12;
                $('#category-product .append-product:lt(' + x + ')').show();
                if (size_li < 12) {
                    $('#loadMore').hide();
                } else {
                    $('#loadMore').attr('href', "route('searchfilter',['search',''])" + slug)
                    $('#loadMore').show();
                }
            }
        });
    }
</script>
@endsection