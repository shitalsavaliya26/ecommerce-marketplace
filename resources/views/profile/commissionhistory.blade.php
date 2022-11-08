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
                                <p class="font-16 text-gray font-GilroyMedium mb-0">{{trans('label.pv_point_history')}}</p>
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
                            <a class="nav-item font-GilroySemiBold nav-link active" id="profile-tab"
                            data-toggle="tab" href="#withdraw" role="tab" aria-controls="profile"
                            aria-selected="true">{{trans('label.pv_point_history')}}</a>
                        </div>
                    </nav>
                </div>
            </div>
            <div class="row mx-0 mt-4">
                <div class="col-12">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="withdraw" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden">
                                <div class="col-12">
                                    <div class="row px-3">
                                        <div class="col-12">
                                            @if($user->pv_point != null && $user->pv_point > 1)
                                            <h4 class="text-black font-16 font-GilroyBold">{{trans('label.you_have')}} {{$user->pv_point}} {{trans('label.pv_point')}}!</h4>
                                            <form method="post" action="{{route('user.convert_pv_point')}}" id="withdraw_pv_point">
                                                {{ csrf_field() }}
                                                <div class="row align-items-center">
                                                    <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.pv_points')}}</label>
                                                    <div class="col-md-6">
                                                        <input type="text" name="pv_point" class="form-control h-auto py-2" placeholder="{{trans('label.enter_pv_points')}}">
                                                        @if ($errors->has('pv_point'))
                                                        <span class="helpBlock">
                                                            <strong>{{ $errors->first('pv_point') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row align-items-center mt-3">
                                                    <div class="col-md-6 offset-md-3">
                                                        <button class="btn bg-orange btn-orange font-GilroySemiBold text-white font-12 px-4">{{trans('label.convert_to_rm')}}</button>
                                                    </div>
                                                </div>
                                            </form>
                                            @else
                                                <h4 class="text-black font-16 font-GilroyBold">{{trans('label.you_have')}} {{ number_format($user->pv_point,2) }} {{trans('label.pv_point')}}! ({{trans('label.minimum_1_required')}})</h4>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 mt-2  table-responsive" id="withdraws">
                                        <table class="table history-table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>{{trans('label.user')}}</th>
                                                    <th>{{trans('label.order')}}</th>
                                                    <th>{{trans('label.pv_point')}}</th>
                                                    <th>{{trans('label.transaction_for')}}</th>
                                                    <th>{{trans('label.created_at')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @if(count($comissionhistory) == 0)
                                              <tr>
                                                <td colspan="8" style="text-align:center;">No record found</td>
                                            </tr>
                                            @endif
                                            @foreach($comissionhistory as $history)

                                            <tr>
                                                <td></td>
                                                <td>
                                                    {{ ucfirst($history->user->name) }} </br>({{ $history->user->email }})
                                                </td>
                                                <td>
                                                    @if(isset($history->order->order_id))
                                                    {{ $history->order->order_id }}
                                                    @else
                                                    -
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $history->amount }}
                                                </td>
                                                <td>
                                                    {{ $history->printtransaction_for($history) }}
                                                </td>
                                                <td>
                                                    {{ date('d/m/Y',strtotime($history->created_at)) }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if(count($comissionhistory) > 0)
                                    <div class="col-12">
                                        {{ $comissionhistory->render('vendor.default_paginate') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
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