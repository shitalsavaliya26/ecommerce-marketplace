@extends('layouts.main')
@section('title', 'Wishlist')
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4 col-xl-3">
                <div class="row bg-white mx-0 br-15 p-4 shadow overflow-hidden">
                    <div class="col-12 px-xl-0">
                        <div class="d-flex flex-column flex-sm-row align-items-center">
                            <div>
                                <img onerror="this.src='{{asset('assets/images/User.png')}}'" src="{{ $user->image }}"
                                class="img-fluid max-w-70px rounded-circle" alt="">
                            </div>
                            <div class="ml-sm-4 text-center text-sm-left">
                                <h1 class="text-black font-20 font-GilroySemiBold mb-0">{{ $user->name }}</h1>
                                <p class="font-16 text-gray font-GilroyMedium mb-0">{{trans('label.edit_profile')}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4 pt-3">
                        <ul class="list-unstyled mb-0">
                         <li class="">
                            <a href="{{route('user.profile')}}" class="d-flex align-items-center">
                                <img src="assets/images/location-orange.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4"
                                id="shipping-address">{{trans('label.shipping_address')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{route('user.wishlist')}}" class="d-flex align-items-center">
                                <img src="assets/images/Like-green.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.wishlist')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{route('user.orders')}}" class="d-flex align-items-center">
                                <img src="assets/images/order-History.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-2 nav-item nav-link">{{trans('label.order_history')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{route('viewNotification')}}" class="d-flex align-items-center">
                                <img src="assets/images/Notification-violet.png" class="img-fluid max-w-20px"
                                alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.notification')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('user.wallet') }}" class="d-flex align-items-center">
                                <img src="assets/images/wallet.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.wallet')}}</span>
                            </a>
                        </li>
                        @if($user->role_id != '7')
                        <li class="mt-3">
                            <a href="{{ route('user.pv_point_withdraw') }}" class="d-flex align-items-center">
                                <img src="assets/images/withdraw.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.withdraw_history')}}</span>
                            </a>
                        </li>
                        @endif
                        <li class="mt-3">
                            <a href="{{ route('user.coin_history') }}" class="d-flex align-items-center">
                                <img src="assets/images/money-transfer-icon.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.coin_history')}}</span>
                            </a>
                        </li>
                        @if($user->role_id != '7')
                        <li class="mt-3">
                            <a href="{{ route('user.commission') }}" class="d-flex align-items-center">
                                <img src="assets/images/reward.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.pv_point_history')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('user.network') }}" class="d-flex align-items-center">
                                <img src="assets/images/network.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.network')}}</span>
                            </a>
                        </li>
                        @endif
                        <li class="mt-3">
                            <a href="{{ route('help-support.index') }}" class="d-flex align-items-center">
                                <img src="assets/images/technical-support.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.support_tickets')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{route('helpCenter')}}" class="d-flex align-items-center">
                                <img src="assets/images/settings.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.help_center')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-9 mt-4 mt-lg-0" id="wishlist">
            <div class="row mx-0">
                <div class="col-12 pl-xl-0">
                    <h4 class="text-black font-GilroyBold font-22">{{trans('label.wishlist')}}</h4>
                </div>
            </div>

            @if($mylist->count() > 0)
            <form action="{{route('moveToCart')}}" method="post" id="addtocart">
                <div class="row align-items-center bg-white br-15 py-3 shadow overflow-hidden mt-2 mx-0">
                    <div class="col-12">
                        <h4 class="text-black font-GilroySemiBold font-20 pl-md-4">{{trans('label.wishlist')}}</h4>
                    </div>
                    {{ csrf_field() }}
                    <div class="col-12 bg-gray-light py-4 my-2">
                        @foreach($mylist as $product)
                        <div class="row align-items-center mb-4">
                            <div class="col-12 col-md-8 col-xl-7">
                                <div class="d-flex flex-column flex-sm-row align-items-center pl-md-4">
                                    <div class="mr-sm-3">
                                        <a href="javascript:void(0)" class="remove" data-id="{{ Helper::encrypt($product->product_id) }}" data-variation="{{ (!is_null($product->variation_id) && $product->variation_id != 0) ? Helper::encrypt($product->variation_id) : '' }}">
                                            <input type="hidden" name="product_id" value="{{ Helper::encrypt($product->product_id) }}">
                                            @if(!is_null($product->variation_id) && $product->variation_id != 0)
                                            <input type="hidden" name="variation_id" value="{{ Helper::encrypt($product->variation_id) }}">
                                            @endif
                                            <input type="hidden" name="qty" value="1">

                                            <img src="assets/images/Cancel-icon.png"
                                            class="img-fluid mr-3" alt="">
                                        </a>
                                        <a href="{{ route('productDetail',$product->productdetails->slug) }}">
                                            <img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{ $product->productdetails->images[0]->thumb }}" class="img-fluid max-w-90px br-15 prd-image" alt="">
                                        </a>
                                    </div>
                                    <div class="mt-3 mt-sm-0">
                                        <h4 class="text-black font-GilroyBold font-18">
                                            {{$product->name}}
                                        </h4>
                                        @if($product->variation_id != 0)
                                        <p class="text-black font-GilroyMedium font-14 mb-0">
                                            {{trans('label.variation')}}: <span class="pl-3">{{str_replace('_', ', ', $product->variation->variation_value_text)}}</span></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4 col-xl-5 mt-3 mt-md-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h1 class="text-black font-18 font-GilroyBold ml-md-3">x1</h1>
                                        <h1 class="text-orange font-22 font-GilroyBold mr-md-3">RM{{((!is_null($product->variation_id) && $product->variation_id != 0) && $product->variation) ? number_format($product->variation->sell_price,2) : number_format($product->productdetails->sell_price, 2) }}
                                        </h1>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="col-12 text-right">
                            <button id="addtocart" 
                            class="btn bg-orange orange-btn text-white font-14 rounded px-5 mt-2 font-GilroySemiBold mr-md-3">{{trans('label.add_to_cart')}}</button>
                        </div>
                    </div>
                </form>
                @else
                <div class="row align-items-center bg-white br-15 py-3 shadow overflow-hidden mt-2 mx-0" id="wishlist">

                    <div class="col-12">
                        <h4 class="text-black font-GilroySemiBold font-20 pl-md-4">{{trans('label.no_products_found')}}</h4>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var deleteurl      = "{{ route('removewishlistproduct') }}";
    var moveToCart = "{{ route('moveToCart') }}";
</script>
<script src="{{ asset('assets/js/wishlist.js').'?v='.time() }}"></script>

@endsection
