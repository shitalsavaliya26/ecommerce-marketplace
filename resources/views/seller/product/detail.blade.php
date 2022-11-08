@extends('layouts.front.main')
@section('title', 'Product detail')

@section('content')
<style>
    .breadcrumb-content ul li {
        text-transform: capitalize !important;
    }
    .breadcrumb-content ul li a{
        color: #0056b3;
    }
</style>
<div class="breadcrumb-area pt-2 pb-2">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li>
                    <a href="{{url('/')}}">Home</a>
                </li>
                <li >
                    <a href="{{url('/products')}}">Products</a>
                </li>
                <li class="active">
                      {{ $products->name }}
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-area pt-50 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="product-details">
                    <div class="product-details-img">
                        <div class="tab-content jump"> 
                        <?php $i = 1; ?>
                        @foreach($products->images as $Images)
                            <div id="shop-details-<?php echo $i; ?>" class="tab-pane  <?php if($i == 1){ echo 'active'; }?> large-img-style">
                                <img src="{{ $Images->image }}" alt="">
                                <div class="img-popup-wrap">
                                    <a class="img-popup" href="{{ $Images->image }}"><i class="pe-7s-expand1"></i></a>
                                </div>
                            </div>
                            <?php $i++; ?>
                        @endforeach
                        </div>
                        <div class="shop-details-tab nav">
                        <?php $i = 1; ?>
                        @foreach($products->images as $Images)
                            <a class="shop-details-overly" href="#shop-details-<?php echo $i; ?>" data-toggle="tab">
                                <img src="{{ $Images->image }}" alt="">
                            </a>
                            <?php $i++; ?>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="product-details-content ml-70">
                    <h2>{{ $products->name }}</h2>
                    <div class="product-details-price">
                        <span>   RM {{ number_format($products->sell_price,2) }}</span>
                    </div>
                    <!-- <div class="pro-details-rating-wrap">
                        <div class="pro-details-rating">
                            <i class="fa fa-star-o yellow"></i>
                            <i class="fa fa-star-o yellow"></i>
                            <i class="fa fa-star-o yellow"></i>
                            <i class="fa fa-star-o"></i>
                            <i class="fa fa-star-o"></i>
                        </div>
                        <span><a href="#">3 Reviews</a></span>
                    </div> -->
                    <p>{!! nl2br(e($products->description)) !!}</p>
                    <div class="pro-details-size-color">
                        
                       
                    </div>
                    <form method="post" action="{{ route('add_to_cart_post') }}" id="addcart">
                       {{ csrf_field() }}
                       <input type="hidden" name="productId" value="{{ $products->id }}" >
                        <div class="pro-details-quality">
                            <div class="cart-plus-minus">
                                <input class="cart-plus-minus-box" type="text" name="qty" value="1" id="qty" min="1">
                            </div>
                            <div class="pro-details-cart btn-hover">
                                <a href="#" id="cartbtn">Add To Cart</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if($productlist != '')
<div class="related-product-area pb-95">
    <div class="container">
        <div class="section-title text-center mb-50">
            <h2>More products</h2>
        </div>
        <div class="related-product-active owl-carousel">
        @foreach($productlist as $product)
            <div class="product-wrap">
                <div class="product-img">
                    <a href="{{ route('product_detail', [$product->id])  }}" >
                                         @if($product->images != null)
                                            <img class="default-img" src="{{ $product->images[0]->image }}" alt=""  >
                                            <img class="hover-img" src="@if(isset($product->images[1]) ) {{ $product->images[1]->image  }} @else {{ $product->images[0]->image  }} @endif"  alt=""  >
                                        @endif
                    </a>
                    <div class="product-action">
                        <div class="pro-same-action pro-cart" style="width:calc(100% - 60px);">
                            <a title="Add To Cart" href="{{route('customer_add_to_cart', [$product->id])}}" ><i class="pe-7s-cart"></i> Add to cart</a>
                        </div>
                        <div class="pro-same-action pro-quickview" style="width:60px;">
                            <a title="Quick View" href="{{ route('product_detail', [$product->id])  }}" ><i class="pe-7s-look"></i></a>
                        </div>
                    </div>
                </div>
                <div class="product-content text-center">
                    <h3><a href="{{ route('product_detail', [$product->id])  }}">{{$product->name}}</a></h3>
                    <div class="product-price">
                        <span>RM {{ number_format($product->sell_price,2) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
    <script src="{!!url('/public/vendors/jquery/dist/jquery.js')!!}"></script>
<script src="{{url('/public/vendors/js/lightslider.js')}}"></script>

<link href="{{url('/public/vendors/css/lightslider.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript">
		 $(document).ready(function() {
            $("#lightSlider").lightSlider({
                item: 1,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 10,
 
        addClass: '',
        mode: "slide",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////
 
        speed: 400, //ms'
        auto: false,
        loop: false,
        slideEndAnimation: false,
        pause: 2000,
 
        keyPress: false,
        controls: true,
        prevHtml: '<i class="la la-angle-left" style="color:white;font-size: 30px;font-weight: 800;" ></i>',
        nextHtml: '<i class="la la-angle-right" style="color:white;font-size: 30px;font-weight: 800;" ></i>',
 
        rtl:false,
        adaptiveHeight:false,
 
        vertical:false,
        verticalHeight:500,
        vThumbWidth:100,
 
        thumbItem:10,
        pager: true,
        gallery: true,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',
 
        enableTouch:true,
        enableDrag:true,
        freeMove:true,
        swipeThreshold: 40,
 
        responsive : [],
 
        onBeforeStart: function (el) {},
        onSliderLoad: function (el) {},
        onBeforeSlide: function (el) {},
        onAfterSlide: function (el) {},
        onBeforeNextSlide: function (el) {},
        onBeforePrevSlide: function (el) {}
            }); 
        });

        $("#cartbtn").click(function() {
            var qty = $('#qty').val();
            if(qty > 0){
                $("#addcart").submit();
            }
        });
        
</script>


@endsection
