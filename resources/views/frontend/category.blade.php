@extends('layouts.main')
@section('title', $products->name)
@section('css')
<style>
    .append-product{ 
        display:none;
    }
</style>
@endsection
@section('content')
<section class="bg-gray pt-2 pb-5">
    <div class="container">
        <div class="mt-4 bg-white br-15 py-3 px-sm-3 shadow">
            <h1 class="ml-2">{{$products->name}}</h1>
            <div class="row mx-0 category-product" id="category-product">
                @if($products->allproducts && count($products->allproducts) > 0)
                @foreach($products->allproducts as $product)
                <?php $product = $product->product; ?>
                
                <div class="col-12 col-md-6 col-xl-3 mt-3" >
                    <div class="overflow-hidden">
                        <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $product->images[0]->thumb }}"
                        class="img-fluid prd-image" alt="">
                        <div class="py-2">
                            <h4 class="text-black font-16 font-GilroyBold">{{$product->name}}</h4>
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
                            <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM{{number_format($product->sell_price, 2) }} (CP)
                                <span class="text-light-gray font-10 font-GilroyMedium">RM{{number_format($product->customer_price, 2) }} (RSP) </span>
                            </h4>
                            <h4 class="text-light-gray font-12 font-GilroyMedium"><span
                                class="text-black mr-1 font-GilroySemiBold"><img src="{{asset('assets/images/Review.png')}}"
                                class="img-fluid w-7px mb-1" alt=""> 0</span>
                                (162) @if($product->sold > 0). {{($product->sold > 1000) ? ceil($product->sold/1000).'K' : $product->sold}} sold @endif </h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h4 class="text-black font-16 font-GilroyBold">{{trans('label.no_records_found')}}</h4>
                    @endif
                </div>
            </div>
        </div>
    </section>


    @endsection
    @section('script')
    <script>

    </script>
    @endsection
