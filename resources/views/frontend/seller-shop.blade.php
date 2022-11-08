@extends('layouts.main')
@section('title', 'Sub Category')
@section('content')

<section class="bg-gray py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="position-relative">
                    <div class="bg-follow" style="background-image: url('{{$seller->bg_image }}')"></div>
                    <div class="bg-follow-black"></div>
                    <div class="cus-follow-content-pos">
                        <div class="d-flex">
                            <div>
                                <img onerror="this.src='{{asset('assets/images/adidas-logo.png') }}'" 
                                    src="{{$seller->image }}" class="cus-follow-img-style"
                                    alt="">
                            </div>
                            <div class="mt-3 pl-3">
                                <h4 class="text-white font-18 font-GilroyBold mb-1">{{ $seller->name }}</h4>
                                <h4 class="text-light-gray font-12 font-GilroySemiBold mb-0">{{$sellerDetails['joined']}}</h4>
                            </div>
                        </div>
                        @if(Auth::user() && Auth::user()->id != $sellerDetails['user'])
                            <div class="d-flex mt-3" id="following">
                                @if(Helper::isFollowing($sellerDetails['sellerId']) == false)
                                    <button type="button" class="btn cus-btn-outline-light font-GilroySemiBold font-12 py-1 rounded-0 w-50 mr-2 follow-button" data-id="{{$sellerDetails['sellerId']}}" > + FOLLOW</button>
                                @else
                                    <button type="button" class="btn cus-btn-outline-light font-GilroySemiBold font-12 py-1 rounded-0 w-50 mr-2 follow-button" data-id="{{$sellerDetails['sellerId']}}" > 
                                        <img src="{{asset('assets/images/checkmark-16.png')}}" class="img-fluid mr-2"
                                            alt="">  FOLLOWING
                                    </button>
                                @endif
                                <button type="button" class="btn cus-btn-outline-light font-GilroySemiBold font-12 py-1 rounded-0 w-50">
                                    <img src="{{asset('assets/images/msg.png')}}" class="img-fluid mr-2"
                                        alt=""> CHAT
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <span class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Products.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Products: <span class="text-orange">{{$sellerDetails['productCount']}}</span>
                    </h4>
                </span>
                <span class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Following.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Following: <span class="text-orange">{{$sellerDetails['followings']}}</span>
                    </h4>
                </span>
                <!-- <span target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/ChatNew.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Chat Performance: <span class="text-orange">96%(Within Hours)</span>
                    </h4>
                </span> -->
            </div>
            <div class="col-12 col-md-6 col-lg-4" id="totalFollower">
                <span target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Followers.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Followers: <span class="text-orange">{{$sellerDetails['followers']}}</span>
                    </h4>
                </span>
                <span target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Rating.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Rating: <span class="text-orange">{{$sellerDetails['avgRating']}}({{$sellerDetails['totalRating']}} Rating)</span>
                    </h4>
                </span>
                <!-- <span target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Joined.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Joined: <span class="text-orange">{{$sellerDetails['joined']}}</span>
                    </h4>
                </span> -->
            </div>
        </div>

        <!-- decoration -->
        @foreach($shopDecoration as $content)
            @if($content->type == 'product')
            <div class="row mt-4">
                <div class="col-12">
                    <div class="slider-grid-6 pb-4">
                        @foreach($content->products as $products)
                        <div class="col-12 col-md-6 col-xl-3 mt-3 append-product" name="append-product">
                            <a href="{{ route('productDetail',$products->product->slug) }}">
                                <div class="overflow-hidden">
                                    @if($products->product->images && count($products->product->images) > 0)
                                    <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $products->product->images[0]->thumb }}" class="img-fluid prd-image" alt="">
                                    @else
                                    <img src="{{asset('images/product/product-placeholder.png')}}" class="img-fluid" alt="">
                                    @endif
                                    <div class="py-2">
                                        <h4 class="text-black font-16 font-GilroyBold mb-0">{{$products->product->name}}</h4>
                                        <div class="d-flex flex-wrap align-items-center">
                                            <button class="btn local-seller-btn py-1 px-2 mr-2 mt-2">{{$products->product->seller->name}}</button>
                                            @if($products->product->cod)
                                            <button class="btn cod-btn py-1 px-2 mr-3 mt-2">COD</button>
                                            @endif
                                            <div class="mt-2 d-flex">
                                                <span>
                                                    <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px mr-2" alt="">
                                                </span>
                                                <span class="text-light-gray font-10">{{$products->product->seller->state}}</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM{{($products->product->is_variation == '1' && $products->product->variation) ? number_format($products->product->variation->sell_price,2) : number_format($products->product->sell_price, 2) }}  (CP) 
                                            <span class="text-light-gray font-10 font-weight-normal">
                                                RM{{($products->product->is_variation == '1' && $products->product->variation) ? number_format($products->product->variation->customer_price,2) : number_format($products->product->customer_price, 2) }} (RSP) 
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal"><span
                                            class="text-black mr-1"><img src="{{asset('assets/images/Review.png')}}"
                                            class="img-fluid w-7px mb-1" alt=""> 0</span>
                                            (0) @if($products->product->sold > 0). {{($products->product->sold > 1000) ? ceil($products->product->sold/1000).'K' : $products->product->sold}} {{trans('label.sold')}} @endif 
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if($content->type == 'image')
                <div class="row mt-4">
                    <div class="col-12 px-0">
                        <div class="sale-slider">
                            @foreach($content->images as $imageData)
                                <div>
                                    <img src="{{ $imageData->image }}" class="img-fluid" alt="" style="width:1420px; height:423px">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="row mt-5 mx-0 br-15 bg-dark-blue shadow overflow-hidden">
            <div class="col-12 px-0">
                <nav class="profile-tabs">
                    <div class="nav nav-tabs border-0 flex-column flex-md-row justify-content-start" id="nav-tab"
                        role="tablist">
                        @foreach($shopCategories as $key=>$shopCategory)
                            <a class="nav-item font-GilroySemiBold nav-link @if ($key == 0) active @endif" id="{{$shopCategory->slug}}-tab" data-id="{{Helper::encrypt($shopCategory->id)}}"
                                href="#{{$shopCategory->slug}}" role="tab" aria-controls="{{$shopCategory->slug}}" aria-selected="true">{{$shopCategory->display_name}}</a>
                        @endforeach
                    </div>
                </nav>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12 bg-white">
                <div class="tab-content" id="nav-tabContent">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
<script>

$(document).on('click','.nav-link',function(e){
    var id = $(this).data("id");
    $('.nav-link.active').removeClass('active');
    $(this).addClass('active');

    getProduct(id);
});

function getProduct(id){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var url = "{{ route('shopCategoryProduct',':id') }}";
    url = url.replace(':id', id);

    $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
            $('#nav-tabContent').html(response.view);
        }
    });
}

$(document).on('click','.follow-button',function(e){
    var sellerId = $(this).data("id");
    var url = "{{ route('updateFollower') }}";
    $.ajax({
        type:'POST',
        url:url,
        data:{
            'seller_id': sellerId,
        },
        success: function(response){
            if(response.success == true){
                $("#following").load(location.href+" #following>*","");
                $("#totalFollower").load(location.href+" #totalFollower>*","");
            }
        }
    });
});

$(document).ready(function(){
    var activetab = jQuery('#nav-tab').find('a.active').attr('data-id');
    getProduct(activetab);
});
</script>

@endsection