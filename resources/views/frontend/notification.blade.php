@extends('layouts.main')
@section('title', 'Notification')
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
                                <a href="" class="d-flex align-items-center">
                                    <img src="assets/images/location-orange.png" class="img-fluid max-w-20px" alt="">
                                    <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.shipping_address')}}</span>
                                </a>
                            </li>
                            <li class="mt-3">
                                <a href="" class="d-flex align-items-center">
                                    <img src="assets/images/Like-green.png" class="img-fluid max-w-20px" alt="">
                                    <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.wishlist')}}</span>
                                </a>
                            </li>
                            <li class="mt-3">
                                <a href="" class="d-flex align-items-center">
                                    <img src="assets/images/order-History.png" class="img-fluid max-w-20px" alt="">
                                    <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.order_history')}}</span>
                                </a>
                            </li>
                            <li class="mt-3">
                                <a href="" class="d-flex align-items-center">
                                    <img src="assets/images/Notification-violet.png" class="img-fluid max-w-20px"
                                        alt="">
                                    <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.notification')}}</span>
                                </a>
                            </li>
                            <li class="mt-3">
                                <a href="" class="d-flex align-items-center">
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
                <div class="row align-items-center bg-gray-light br-15 pb-3 shadow overflow-hidden mx-0">
                    <div class="col-12 bg-white py-3">
                        <h4 class="text-black font-GilroyBold font-20 pl-md-3">{{trans('label.all_notifications')}}</h4>
                    </div>

                    <div class="col-12 bg-white">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-9">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-3">
                                        <div class="bg-orange br-15 py-2 px-4 text-center w-100px min-h-100px mx-auto">
                                            <p class="font-GilroyRegular font-12 mb-0 text-white">{{trans('label.special_vouncher_just_for_you')}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9 mt-2">
                                        <p class="font-GilroySemiBold font-18 mb-1 text-black">Special Vouncher Just For
                                            You</p>
                                        <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">Hi johnsmith, here's
                                            a Free Shipping and RM7 OFF voucher just for you! Enjoy them now with RM0
                                            min spend. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 text-right">
                                <button
                                    class="btn bg-orange orange-btn text-white font-12 rounded px-3 font-GilroySemiBold">View
                                    Details</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 py-3 bg-white">
                        <hr />
                    </div>

                    <div class="col-12 bg-white">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-9">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-3">
                                        <div class="bg-orange br-15 py-2 px-4 text-center w-100px min-h-100px mx-auto">
                                            <p class="font-GilroyRegular font-12 mb-0 text-white">Special Vouncher Just
                                                For You</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9 mt-2">
                                        <p class="font-GilroySemiBold font-18 mb-1 text-black">Special Vouncher Just For
                                            You</p>
                                        <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">Hi johnsmith, here's
                                            a Free Shipping and RM7 OFF voucher just for you! Enjoy them now with RM0
                                            min spend. </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 text-right">
                                <button
                                    class="btn bg-orange orange-btn text-white font-12 rounded px-3 font-GilroySemiBold">View
                                    Details</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 py-3 bg-white">
                        <hr />
                    </div>


                    <div class="col-12 bg-white pb-3">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-9">
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-3">
                                        <div class="overflow-hidden br-15 text-center w-100px min-h-100px mx-auto">
                                            <img src="{{ asset('assets/images/product.png') }}" class="img-fluid" alt="">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-9">
                                        <p class="font-GilroySemiBold font-18 mb-1 text-black">Parcel Delivered</p>
                                        <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">Parcel for your
                                            order 1231343273457 has been delivered</p>
                                        <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">02-06-2022 18:14</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 text-right">
                                <button
                                    class="btn bg-orange orange-btn text-white font-12 rounded px-3 font-GilroySemiBold">View
                                    Order Details</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 offset-md-1">
                        <ul class="notification-timeline">
                            <li class="notification-timeline-item mt-4 mb-5">
                                <p class="font-GilroySemiBold font-18 mb-1 text-medium-gray">Shipped Out</p>
                                <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">Parcel for your order
                                    1231343273457 has been shipped out by <span
                                        class="font-GilroyBold">Glendarclas</span> via
                                    <span class="font-GilroyBold">Others (West Malaysia).</span> Click here to see order
                                    details and track your parcel.
                                </p>
                                <p class="font-GilroyRegular font-14 text-medium-gray">02-06-2022 18:14</p>
                            </li>
                            <li class="notification-timeline-item mb-5">
                                <p class="font-GilroySemiBold font-18 mb-1 text-medium-gray">Payment Confirmed</p>
                                <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">Payment for order
                                    1231343273457 has been confirmed and we’ve notified the seller.
                                    Kindly wait for your shipment.</p>
                                <p class="font-GilroyRegular font-14 text-medium-gray">02-06-2022 18:14</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection