@extends('layouts.main')
@section('title', 'Help Center')

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
                                <span class="font-16 font-GilroyMedium text-gray ml-2 nav-item nav-link">
                                    {{trans('label.order_history')}}
                                </span>
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
                            <a href="{{ route('user.my_vouchers') }}" class="d-flex align-items-center">
                                <img src="assets/images/voucher.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.my_vouchers')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="{{ route('help-support.index') }}" class="d-flex align-items-center">
                                <img src="assets/images/technical-support.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.support_tickets')}}</span>
                            </a>
                        </li>
                        <li class="mt-3">
                            <a href="" class="d-flex align-items-center">
                                <img src="assets/images/settings.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.help_center')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-9 mt-4 mt-lg-0">
            <div class="row align-items-center bg-white br-15 pt-4 pb-5 shadow overflow-hidden mx-0">
                <div class="col-12">
                    <h4 class="text-black font-GilroyBold font-20 ml-3 mb-0">{{trans('label.categories')}}</h4>
                </div>

                <div class="col-12">
                    <div class="row mx-0">
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image1.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.shop_with_maxshop')}}</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image2.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.payments')}}</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image3.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.returns_and_refund')}}</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image4.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.general')}}</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image5.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.deals_and_report')}}</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image6.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.order_and_shipping')}}</h4>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-xl-3 mt-4">
                            <div class="bg-gray-light br-8 text-center p-3">
                                <img src="assets/images/image7.png" class="img-fluid max-w-70px" alt="">
                                <h4 class="text-black font-GilroyBold font-14 mt-2">{{trans('label.seller_and_partners')}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="row align-items-center bg-white px-3 br-15 py-4 shadow overflow-hidden mx-0 mt-4">
                <div class="col-12">
                    <h4 class="text-black font-GilroyBold font-20 mb-0">Hot Questions</h4>
                </div>

                <div class="col-12 mt-3">
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                    <p class="text-black font-GilroySemiBold font-16 mb-2"><span class="text-orange">[Maxshop Coins]</span> I’ve made my purchases. When will I receive my Shopee Coins?</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection