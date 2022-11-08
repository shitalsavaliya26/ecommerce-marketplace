@extends('layouts.main')
@section('title', 'Home')
@section('css')
<style>
    .append-product {
        display: none;
    }
</style>
@endsection
@section('content')
<section class="bg-gray pt-2 pb-5">
    <div class="container">
        <div class="row">
            @if($topBanners && $topBanners->bannerImages && count($topBanners->bannerImages) > 0)
            @foreach($topBanners->bannerImages as $topBanner)
            <div class="col-12 col-mg-6 col-lg-4 mt-3">
                <a href="{{$topBanner->link}}" target="_blank">
                    <img src="{{$topBanner->image}}" class="img-fluid banner-border" alt=""  style="width:450px; height:175px">
                </a>
            </div>
            @endforeach
            @endif
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="bg-orange sale-label">
                    <h1 class="font-GilroyBlackItalic text-white text-center mb-0">{{@$mainBanners->name}}</h1>
                </div>
            </div>
            <div class="col-12 px-0">
                <div class="sale-slider">
                    @if($mainBanners && $mainBanners->bannerImages && count($mainBanners->bannerImages) > 0)
                    @foreach($mainBanners->bannerImages as $mainBanner)
                    <div>
                        <a href="{{$mainBanner->link}}" target="_blank">
                            <img src="{{ $mainBanner->image }}" class="img-fluid banner-border" alt="" style="width:1420px; height:423px">
                        </a>
                    </div>
                    @endforeach
                    @else
                    <div>
                        <img src="{{asset('assets/images/Homepage-4.png')}}" class="img-fluid banner-border" alt="" height="711px" width="2387px">
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 bg-white br-15 py-3 px-sm-3 shadow">
            <div class="row mx-0 align-items-center justify-content-between">
                <div class="col-sm-1 col-xl-auto">
                    <div id="left-arrow">
                        <img src="{{asset('assets/images/Homepage-arrow.png')}}" class="img-fluid w-7px cursor-pointer rotate-180" alt="">
                    </div>
                </div>
                <div class="col-sm-10 col-xl-11">
                    <ul class="home-tabs list-unstyled mb-0 tab-slider">
                        @foreach($categories as $key=>$category)
                        <li class="nav-item category-list" name="{{ $category->slug }}">
                            <a class="nav-link @if ($key == 0) active @endif category" id="{{$category->slug}}">{{$category->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-sm-1 col-xl-auto text-sm-right">
                    <div id="right-arrow">
                        <img src="{{asset('assets/images/Homepage-arrow.png')}}" class="img-fluid w-7px cursor-pointer" alt="">
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

        <div class="row mt-4">
            @if($midBanners && $midBanners->bannerImages && count($midBanners->bannerImages) > 0)
            <div class="col-12 col-lg-8">
                <div class="sale-slider no-margin">
                    @foreach($midBanners->bannerImages as $midBanner)
                    <a href="{{$midBanner->link}}" target="_blank">
                        <img src="{{ $midBanner->image }}" class="img-fluid br-15" alt="" style="width:930px; height:385px">
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
            @if($smallBanners && $smallBanners->bannerImages && count($smallBanners->bannerImages) > 0)
            <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                @foreach($smallBanners->bannerImages as $key => $smallBanner)
                <a href="{{$smallBanner->link}}" target="_blank">
                    <img src="{{ $smallBanner->image }}" style="width:450px; height:186px" @if($key > 0) class="img-fluid br-15 mt-3" @else class="img-fluid br-15" @endif alt="">
                </a>
                @endforeach
            </div>
            @endif
        </div>
        @if($promotions->count() > 0)
        <div class="row mt-4 bg-white br-15 px-sm-3 py-4 mx-0 shadow">
            <div class="col-12">
                <h4 class="text-black font-20 font-GilroyBold">{{trans('label.latest_promotion')}}</h4>
            </div>
            @foreach($promotions as $promotion)
            <div class="col-12 col-md-4 col-lg-3 col-xl-2 text-center text-md-left">
                <div class="mt-3">
                    <img onerror="this.src='{{asset('assets/images/Promotion banner-1.png')}}'" src="{{ $promotion->image }}" class="img-fluid rounded" alt="">
                    <h4 class="text-gray font-16 mt-2 mb-1 font-GilroySemiBold">{{$promotion->title}}</h4>
                    <a href="{{route('promotion',$promotion->slug)}}" class="btn bg-orange orange-btn text-white font-14 py-1 px-3 mt-2 font-GilroyMedium">{{trans('label.shop_now')}}</a>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>

<section class="bg-white py-4">
    <div class="container">
        <div class="row px-sm-3 mx-0">
            <div class="col-12">
                <h4 class="text-white font-20 font-GilroyBold">{{trans('label.all_categories')}}</h4>
            </div>
        </div>
        <div class="row justify-content-between mt-3 mx-0">
            @foreach($categories as $category)
            <div class="col-6 col-sm-4 col-md-3 col-lg-auto">
                <div class="text-center mt-3">
                    <a href="{{route('show-category',$category->slug)}}">
                        @if($category->images && count($category->images) > 0)
                        <img onerror="this.src='{{asset('assets/images/Category-1.png')}}'" src="{{ $category->images[0]->image }}" class="img-fluid max-w-90px" alt="">
                        @else
                        <img src="{{asset('assets/images/Category-1.png')}}" class="img-fluid max-w-90px" alt="">
                        @endif
                        <h4 class="text-black font-16 mt-1 font-GilroyMedium">{{$category->name}}</h4>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-white py-5 py-lg-0">
    <div class="container">
        <div class="row -mb-150px">
            @if($lastBanners && $lastBanners->bannerImages && count($lastBanners->bannerImages) > 0)
            <div class="col-12">
                <div class="sale-slider">
                    @foreach($lastBanners->bannerImages as $lastBanner)
                    <div>
                        <a href="{{$lastBanner->link}}" target="_blank">
                            <img src="{{ $lastBanner->image }}" class="img-fluid" alt="" style="width:1390px; height:369px">
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@if($sockingSale->count() > 0)
<section class="bg-gray py-4">
    <div class="container">
        <div class="row mt-150px bg-white br-15 mx-0 overflow-hidden shadow">
         @include('frontend.shockingsale')
     </div>
 </div>
</section>
@endif
<?php $i =0; ?>
@foreach($displayCategories as $key=>$display)
<section class="bg-gray py-4 @if($i == 0) pt-13 @endif">
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
                    <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-3 px-2 mt-3">
                        <a href="{{ route('productDetail',$product->slug) }}">
                            <div class="overflow-hidden">
                                <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"
                                src="{{ $product->images[0]->thumb }}" class="img-fluid prd-image" alt="" style="">
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
                                        class="text-light-gray font-10 font-GilroyMedium">RM{{number_format($product->customer_price,2) }} (RSP) </span>
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
                    <h4>{{trans('label.no_records_found')}}!</h4>
                    @endif
                </div>
            </div>
            @if($key % 2 != 0 && $key != 0)
            <div class="col-12 col-lg-4 px-0">
                <div class="sale-slider no-margin">
                    @if($display->displayCategoryBanners && count($display->displayCategoryBanners) > 0)
                    @foreach($display->displayCategoryBanners as $image)
                    <div>
                        <img onerror="this.src='{{asset('assets/images/Homepage-sale-banner-1.png')}}'" style="height:793px; width:470px"
                        src="{{ $image->image }}" class="img-fluid mx-auto br-15" alt="">
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
<?php $i++; ?>

@endforeach
@if(count($searchedCategories) > 0 || count($keywords) > 0)
<section class="bg-gray pb-4">
    <div class="container">
        <div class="row bg-dark-blue br-15 py-4 mx-0">
            <div class="col-12">
                <div class="row mx-0">
                    <div class="col-12">
                        <h4 class="text-white font-20 font-GilroyBold">{{trans('label.most_user_search')}}</h4>
                    </div>
                </div>
                <div class="row mt-3 mx-0 px-3">
                    @foreach($searchedCategories as $categories) 
                        <a href="{{route('show-category',$categories->getCategory->slug)}}">
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="text-center mt-3 d-flex align-items-center">
                                    <img src="{{asset('assets/images/Category-1.png')}}" class="img-fluid max-w-70px" alt="">
                                    <h4 class="text-white font-18 mt-1 ml-3">
                                        {{$categories->getCategory->name}}
                                    </h4>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="row mx-0 mt-4">
                    <div class="col-12">
                        <div class="d-flex flex-wrap align-items-center justify-content-between">
                            @for($i=0; $i < count($keywords) ; $i++) 
                                <a href="{{route('searchfilter', ['search' => $keywords[$i]->keyword])}}">
                                    <h4 class="text-white font-18 font-weight-normal mr-2">{{$keywords[$i]->keyword}}</h4>
                                </a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-gray pb-5">
    <div class="container">
        <div class="row bg-white br-15 p-3 mx-0 shadow">
            @for($i=0; $i < count($productsOfKeywords) ; $i++) 
                <div class="col-12 col-sm-6 col-md-4 col-xl-2 px-2 mt-3">
                    <a href="{{ route('productDetail',$productsOfKeywords[$i]->slug) }}">
                        <div class="overflow-hidden">
                            <div class="">
                                <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'"
                                src="{{ $productsOfKeywords[$i]->images[0]->thumb }}" class="img-fluid d-block mx-auto prd-image">
                            </div>
                            <div class="py-2">
                                <h4 class="text-black font-16 font-GilroyBold">{{$productsOfKeywords[$i]->name}}</h4>
                                <div class="d-flex align-items-center">
                                    <button class="btn local-seller-btn py-1 px-2">{{$productsOfKeywords[$i]->seller->name}}</button>
                                    @if($productsOfKeywords[$i]->cod)
                                        <button class="btn cod-btn py-1 px-2 ml-2">COD</button>
                                    @endif
                                    <div class="ml-3">
                                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                                        <span class="text-light-gray font-10">{{$productsOfKeywords[$i]->seller->state}}</span>
                                    </div>
                                </div>
                                <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                    RM{{number_format(App\Helpers\Helper::customerPrice($productsOfKeywords[$i]->id), 2) }}
                                    (CP)
                                    <span class="text-light-gray font-10 font-weight-normal">RM{{number_format(App\Helpers\Helper::customerPrice($productsOfKeywords[$i]->id), 2) }} (RSP) </span>
                                </h4>
                                <h4 class="text-light-gray font-12 font-weight-normal">
                                    <span class="text-black mr-1">
                                        @if($productsOfKeywords[$i]->avgReviewRating() > 0)
                                            <img src="{{asset('assets/images/Review.png')}}" class="img-fluid w-7px mb-1" alt="">{{number_format($productsOfKeywords[$i]->avgReviewRating(),1) }}
                                        @endif
                                    </span>
                                    @if($productsOfKeywords[$i]->countReviewRating() > 0)
                                        ({{$productsOfKeywords[$i]->countReviewRating() }}) .
                                    @endif
                                    @if($productsOfKeywords[$i]->sold > 0) {{($productsOfKeywords[$i]->sold > 1000) ?
                                        ceil($productsOfKeywords[$i]->sold/1000).'K' : $productsOfKeywords[$i]->sold}} {{trans('label.sold')}}
                                    @endif
                                </h4>
                            </div>
                        </div>
                    </a>
                </div>
            @endfor
        </div>
    </div>
</section>
@endif
@endsection
@section('script')
<script src="{{ asset('js/jquery.flipper-responsive.js').'?v='.time() }}"></script>
<script>
  //   $( ".myFlipper" ).each(function( index ) {

  //     jQuery(function ($) {
  //       $('#'+$(this).attr('id')).flipper('init');
  //   });
  // })
  jQuery(function ($) {
    $( ".myFlipper" ).each(function( index ) {
        $('#'+$(this).attr('id')).flipper('init');
    });
});
</script>
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
                    $('#loadMore').attr('href', "{{route('show-category','')}}/" + slug)
                    $('#loadMore').show();
                }
            }
        });
    }
</script>
@endsection