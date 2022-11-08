@extends('layouts.main')
@section('title', 'Notifications')

@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-2 mt-4 mt-lg-0"></div>
            <div class="col-8 mt-4 mt-lg-0">
                <div class="row align-items-center bg-gray-light br-15 pb-3 shadow overflow-hidden mx-0">
                    <div class="col-12 bg-white py-3">
                        <h4 class="text-black font-GilroyBold font-20 pl-md-3">{{trans('label.all_notifications')}}</h4>
                    </div>

                    @foreach($notifications as $notification)
                        <div class="col-12 bg-white">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-9">
                                    <div class="row align-items-center">

                                        <div class="col-12 col-md-9 mt-2">
                                            <p class="font-GilroySemiBold font-18 mb-1 text-black">{{$notification->type}}</p>
                                            <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">{{$notification->message}}</p>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="col-12 col-md-3 text-right">
                                    <button
                                        class="btn bg-orange orange-btn text-white font-12 rounded px-3 font-GilroySemiBold">View
                                        Details</button>
                                </div> -->
                            </div>
                        </div>
                        <div class="col-12 py-3 bg-white">
                            <hr />
                        </div>
                    @endforeach

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