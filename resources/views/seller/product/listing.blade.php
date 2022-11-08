@extends('layouts.front.main')

@section('content')

<div class="shop-area pt-15 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-12">
                <!-- <div class="shop-top-bar">
                    <div class="select-shoing-wrap">
                        <div class="shop-select">
                            <select>
                                <option value="">Sort by newness</option>
                                <option value="">A to Z</option>
                                <option value=""> Z to A</option>
                                <option value="">In stock</option>
                            </select>
                        </div>
                        <p>Showing 1–12 of 20 result</p>
                    </div>
                   
                </div> -->
                <div class="shop-bottom-area mt-35">
                    <div class="tab-content jump">
                        <div id="shop-1" class="tab-pane active">
                            <div class="row">
                                
                            @foreach($products as $product)
                                <div class="col-xl-3 col-md-3 col-lg-3 col-sm-6">
                                    <div class="product-wrap mb-25 scroll-zoom">
                                        <div class="product-img">
                                            <a href="{{ route('product_detail', [$product->id])  }}" >
                                                <img class="default-img" src="{{ $product->images[0]->image }}" alt="">
                                                <img class="hover-img"  src="@if(isset($product->images[1]) ) {{ $product->images[1]->image  }} @else {{ $product->images[0]->image  }} @endif" alt="">
                                            </a>
                                         
                                            <div class="product-action">
                                                <div class="pro-same-action pro-cart" style="width:calc(100% - 60px);" >
                                                    <a title="Add To Cart" href="{{route('customer_add_to_cart', [$product->id])}}"  ><i class="pe-7s-cart"></i> Add to cart</a>
                                                </div>
                                                <div class="pro-same-action pro-quickview" style="width:60px;" >
                                                    <a title="Quick View" href="{{ route('product_detail', [$product->id])  }}"  ><i class="pe-7s-look"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content text-center">
                                            <h3><a href="{{ route('product_detail', [$product->id])  }}">{{$product->name}}</a></h3>
                                            <div class="product-price">
                                                <span> RM {{ number_format($product->sell_price,2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
