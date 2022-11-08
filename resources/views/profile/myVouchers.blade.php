@extends('layouts.main')
@section('title', 'Wallet')
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
                                <p class="font-16 text-gray font-GilroyMedium mb-0">{{trans('label.my_vouchers')}}</p>
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
                            <a href="{{route('helpCenter')}}" class="d-flex align-items-center">
                                <img src="assets/images/settings.png" class="img-fluid max-w-20px" alt="">
                                <span class="font-16 font-GilroyMedium text-gray ml-4">{{trans('label.help_center')}}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-9 mt-4 mt-lg-0">
            <div class="row mx-0 br-15 bg-dark-blue shadow overflow-hidden">
                <div class="col-12 px-0">
                    <nav class="profile-tabs profile-tabs-w-25">
                        <div class="nav nav-tabs border-0 flex-column flex-md-row flex-lg-column flex-xl-row" id="nav-tab" role="tablist">
                            <a class="nav-item font-GilroySemiBold nav-link active" id="myVouchers-tab"
                            data-toggle="tab" href="#myVouchers" role="tab" aria-controls="profile"
                            aria-selected="true">{{trans('label.my_vouchers')}}</a>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row mx-0 mt-4">
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="myVouchers" role="tabpanel" aria-labelledby="myVouchers-tab">
                            <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden">
                                @foreach($myVouchers as $voucher)
                                <div class="col-12 col-md-6 col-xl-4 mt-4">
                                    <div class="row align-items-center h-100 mx-0">
                                        @if($voucher->redeemed)
                                        <img src="{{ asset('assets/images/stamp.png') }}" class="img-fluid redeemed-stamp-img" alt="">
                                        @endif
                                        @if($voucher->expired)
                                        <img src="{{ asset('assets/images/Expired.png') }}" class="img-fluid redeemed-stamp-img" alt="">
                                        @endif
                                        <div
                                        class="col-3 col-xl-4 bg-orange p-3 h-100 d-flex align-items-center justify-content-center vouncher-galore1">
                                        <p class="font-GilroyBold text-white text-center font-16 text-uppercase mb-0 text-break">{{substr($voucher->voucher->code, 0, 10)}}<br>{{substr($voucher->voucher->code, 10)}}</p>
                                    </div>
                                    <div class="col-9 col-xl-8 border-vouncher-galore vouncher-galore2">
                                        <div class="p-3 vouncher-galore3">
                                            <p class="font-GilroyBold text-black font-14 mb-0">{{$voucher->voucher->name}}</p>
                                            <p class="font-GilroyMedium text-gray font-8 mb-0">{{trans('label.valid_till')}} {{date("d M", strtotime($voucher->voucher->to_date))}}</p>
                                            <p class="font-GilroyBold text-black font-14 mb-0">{{trans('label.min_spend')}} RM{{$voucher->voucher->min_basket_price}}</p>
                                            <div class="d-flex justify-content-between align-items-end">
                                                <a href="@if(!auth()->check()) {{route('login')}} @else javascript:void(0) @endif" data-p="{{$voucher->promotion_id}}" data-id="{{App\Helpers\Helper::encrypt($voucher->voucher->id)}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 py-1 font-GilroyMedium mt-2 redeem redeem-button">{{trans('label.use')}}</a>
                                            </div>
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
</section>
@endsection
@section('script')
<script src="{{ asset('vendors/dropzone/dist/dropzone.js') }}"></script>
<script type="text/javascript">
    var redeemurl    = "{{ route('redeemVoucher') }}";
    var checkouturl  = "{{ route('checkout') }}";
</script>
<script src="{{ asset('assets/js/promotion.js').'?v='.time() }}"></script>

<script>
    $(document).ready(function () {
        $('#nav-tab a[href="#{{ old('tab') }}"]').tab('show');
    });

    $(function () {
        var pvPoint = "{{isset($user->pv_point) ? $user->pv_point : ''}}";

        $("#withdraw_pv_point").validate({
            rules: {
                pv_point: {
                    required: true,
                    number:true,
                    max: function() {
                        return parseInt(pvPoint);
                    }
                }
            }
        });

    });
</script>
@endsection
