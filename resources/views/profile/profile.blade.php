@extends('layouts.main')
@section('title', 'Profile')
@section('css')
<style>
    .pointer {
        cursor: pointer;
    }
</style>

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
                                <a class="nav-item font-GilroySemiBold nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">{{trans('label.profile')}}</a>
                                <a class="nav-item font-GilroySemiBold nav-link" id="addresses-tab" data-toggle="tab" href="#addresses" role="tab" aria-controls="addresses" aria-selected="false">{{trans('label.addresses')}}</a>
                                <a class="nav-item font-GilroySemiBold nav-link" id="changePassword-tab" data-toggle="tab" href="#changePassword" role="tab" aria-controls="changePassword" aria-selected="false">{{trans('label.change_password')}}</a>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="row mx-0 mt-4">
                    <div class="col-12">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row px-3 pl-md-0 br-15 bg-white py-5 shadow overflow-hidden">
                                    <div class="col-12 col-md-4 text-center pl-md-0">
                                        <div class="text-center" id="imgdiv">
                                            <img onerror="this.src='{{asset('assets/images/User.png')}}'" src="{{ $user->image }}"
                                            class="img-fluid rounded-circle" alt=""
                                            style="height:123px; width:123px">
                                        </div>
                                        <form method="post" id="upload-image-form" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <input type="file" id="user-img" class="d-none">
                                            <label class="bg-orange image-label-hover font-GilroyMedium text-white font-14 py-2 cursor-pointer mt-4 px-4" for="user-img">{{trans('label.change_image')}}</label>
                                        </form>
                                        <p class="font-12 text-gray font-GilroyMedium mb-0 mt-2">{{trans('label.file_size_validation')}}</p>
                                        <p class="font-12 text-gray font-GilroyMedium mb-0">{{trans('label.file_extension')}}: .JPEG, .PNG</p>
                                    </div>
                                    <div class="col-12 col-md-8 mt-4 mt-md-0">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.username')}}</label>
                                            <div class="col-sm-9">
                                                <h1 class="text-black font-16 font-GilroyBold mb-0">{{ $user->username}}</h1>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.name')}}</label>
                                            <div class="col-sm-9 position-relative">
                                                <input type="text" id="name" class="form-control text-black font-16 font-GilroyBold" placeholder="{{trans('label.enter_name')}}" value="{{ $user->name }}">
                                                <img src="assets/images/pencil.png" class="img-fluid edit-position" alt="">
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center" id="email-div">
                                            <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.email')}}</label>
                                            <div class="col-sm-9">
                                                <h1 class="text-black font-16 font-GilroySemiBold mb-0 emailText">
                                                    <?php
                                                        $stars = 1; // Min Stars to use
                                                        $at = strpos($user->email, '@');
                                                        if ($at - 2 > $stars) {
                                                            $stars = $at - 2;
                                                        }

                                                        $mail = substr($user->email, 0, 1) . str_repeat('*', $stars) . substr($user->email, $at - 1);
                                                        ?> 
                                                        {{$mail}}
                                                        <span class="cursor-pointer text-light-blue ml-2 changeEmail"><u>{{trans('label.change')}}</u></span>
                                                    </h1>
                                                    <div class="position-relative emailInput" style="display:none;">
                                                        <input type="email" name="email" class="form-control text-black font-16 font-GilroyBold profile-form" placeholder="{{trans('label.email')}}" value="{{$user->email}}">
                                                        <img src="assets/images/close.png" class="img-fluid edit-position closeEmailEdit" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-0" id="phone-div">
                                                <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.phone_number')}}</label>
                                                <div class="col-sm-9">
                                                    <h1 class="text-black font-16 font-GilroySemiBold mb-0 numberText">
                                                        <?php
                                                        $mobnum = $user->phone;
                                                        for ($i = 2; $i < 8; $i++) {
                                                            $mobnum = substr_replace($mobnum, "*", $i, 1);
                                                        }
                                                        ?> 
                                                        {{$mobnum}}
                                                        <span class="cursor-pointer text-light-blue ml-2 changeNumber"><u>{{trans('label.change')}}</u></span>
                                                    </h1>
                                                    <div class="position-relative numberInput" style="display:none;">
                                                        <input type="text"
                                                        class="form-control text-black font-16 font-GilroyBold profile-form"
                                                        placeholder="{{trans('label.email')}}" name="phone" value="{{$user->phone}}">
                                                        <img src="assets/images/close.png"
                                                        class="img-fluid edit-position closeNumberEdit" alt="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center">
                                                <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular mt-2">{{trans('label.gender')}}</label>
                                                <div class="col-sm-9">
                                                    <div class="d-flex flex-column flex-sm-row flex-wrap">
                                                        <div class="custom-control mt-2">
                                                            <input type="radio" class="custom-control-input" id="male"
                                                            name="gender" value="male" {{ ($user->gender=="male")? "checked" : "" }} >
                                                            <label class="custom-control-label text-black font-weight-bold font-16 pl-1"
                                                            for="male">{{trans('label.male')}}</label>
                                                        </div>
                                                        <div class="custom-control mt-2 ml-sm-4 ml-lg-3 ml-xl-4">
                                                            <input type="radio" class="custom-control-input" id="female"
                                                            name="gender" value="female" {{ ($user->gender=="female")? "checked" : "" }} >
                                                            <label class="custom-control-label text-black font-weight-bold font-16 pl-1"
                                                            for="female">{{trans('label.female')}}</label>
                                                        </div>
                                                        <div class="custom-control mt-2 ml-sm-4 ml-lg-3 ml-xl-4">
                                                            <input type="radio" class="custom-control-input" id="other"
                                                            name="gender" value="other" {{ ($user->gender=="other")? "checked" : "" }} >
                                                            <label class="custom-control-label text-black font-weight-bold font-16 pl-1"
                                                            for="other">{{trans('label.other')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row align-items-center mb-0" style="display:none">
                                                <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.date_of_birth')}}</label>
                                                <div class="col-sm-9">
                                                    <div class="d-flex flex-wrap flex-column flex-sm-row flex-lg-column flex-xl-row">
                                                        <select class="form-control text-black font-16 font-GilroyBold w-auto" id="day">
                                                            <option>23</option>
                                                        </select>
                                                        <select class="form-control text-black font-16 font-GilroyBold ml-sm-3 mt-2 mt-sm-0 ml-lg-0 ml-xl-3 mt-lg-2 mt-xl-0 w-auto" id="month">
                                                            <option>February</option>
                                                        </select>
                                                        <select class="form-control text-black font-16 font-GilroyBold ml-sm-3 mt-2 mt-sm-0 ml-lg-0 ml-xl-3 mt-lg-2 mt-xl-0 w-auto" id="year">
                                                            <option>1989</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                         <!--    <div class="form-group row align-items-center" id="race-div">
                                                <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.race')}}</label>
                                                <div class="col-sm-9">
                                                    @if($user->race != '' && $user->race != null)
                                                    <h1 class="text-black font-16 font-GilroyBold mb-0">{{ucfirst($user->race) }}</h1>
                                                    @else
                                                    <select class="form-control login-border text-light-gray" id="race" name="race" required>
                                                        <option value="">{{trans('label.select_race')}} </option>
                                                        <option value="malay">Malay</option>
                                                        <option value="chinese">Chinese</option>
                                                        <option value="indian">Indian</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    @endif
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="addresses" role="tabpanel" aria-labelledby="addresses-tab">
                                    <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="address-list">
                                        @if($addresses && count($addresses))
                                        @foreach($addresses as $key => $address)
                                        <div class="col-12">
                                            <div class="row px-3">
                                                <div class="col-12 col-md-8">
                                                    <div class="row align-items-center">
                                                        <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.full_name')}}</label>
                                                        <div class="col-sm-9">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <h1 class="text-black font-16 font-GilroySemiBold mb-0 mt-2">{{$address->name}}</h1>
                                                                <button class="btn btn-default-hover text-white font-GilroyMedium font-12 ml-2 py-1 px-3 mt-2 
                                                                @if($address->is_default == 'true') bg-gray @else bg-light-blue default-address @endif"
                                                                data-id="{{$address->id}}">{{trans('label.default')}}</button>
                                                                    <!-- <button class="btn orange-btn-outline bg-white font-GilroyMedium rounded-pill text-white font-12 py-1 px-4 ml-sm-2 mt-2">Pickup</button>
                                                                        <button class="btn orange-btn-outline bg-white font-GilroyMedium rounded-pill text-white font-12 py-1 px-4 ml-2 mt-2">Return Address</button> -->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if($key == 0)
                                                        <div class="col-12 col-md-4 text-md-right mt-2 mt-md-0">
                                                            <button class="btn bg-orange orange-btn font-GilroyMedium text-white font-12 px-4" data-toggle="modal" data-target="#modalAddressForm">+
                                                                {{trans('label.add_new_address')}}
                                                            </button>
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="row align-items-center px-3">
                                                        <div class="col-12 col-md-8">
                                                            <div class="row align-items-center mt-3">
                                                                <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.phone')}}</label>
                                                                <div class="col-sm-9">
                                                                    <div class="d-flex flex-wrap align-items-center">
                                                                        <h1 class="text-black font-16 font-GilroySemiBold mb-0">
                                                                            @if(auth()->user()->role_id == '7')
                                                                            ({{$address->country_code}})
                                                                            {{$address->contact_number}}
                                                                            @else
                                                                            ({{$address->countrycode}})
                                                                            {{$address->contact_no}}
                                                                            @endif
                                                                        </h1>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 mt-2 mt-md-0">
                                                            <div class="d-flex flex-wrap align-items-center justify-content-md-end">
                                                                <h1 class="text-black font-16 font-GilroyBold mb-0 editAdddress"
                                                                data-toggle="modal" name="editAdddress" data-target="#editModalAddressForm" 
                                                                data-id="{{$address->id}}"><u class="pointer">{{trans('label.edit')}}</u></h1>
                                                                <h1 class="text-black font-16 font-GilroyBold mb-0 ml-3">
                                                                    <u class="delete-address pointer" name="delete-address"
                                                                    data-id="{{$address->id}}">{{trans('label.delete')}}</u>
                                                                </h1>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row px-3">
                                                        <div class="col-12 col-md-8">
                                                            <div class="row align-items-center mt-3">
                                                                <label class="col-sm-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.address')}}</label>
                                                                <div class="col-sm-9">
                                                                    <div class="d-flex flex-wrap align-items-center">
                                                                        <?php
                                                                        $fulladdress = implode(", ", array_filter([$address->address_line1, $address->address_line2, $address->town, $address->state, $address->country, $address->postal_code]));
                                                                        ?>
                                                                        <h1 class="text-black font-16 font-GilroySemiBold mb-0">
                                                                            {{$fulladdress}}
                                                                        </h1>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-md-4 text-md-right">
                                                            <!-- @if(auth()->user()->role_id == '7') -->
                                                            <!-- @endif -->
                                                            <button class="btn btn-orange font-GilroyBold text-white font-12 px-4 @if($address->is_default == 'true') bg-gray mt-md-2 mt-xl-0 @else bg-orange default-address @endif"
                                                                data-id="{{$address->id}}">{{trans('label.set_as_default')}}</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($key < (count($addresses) - 1) ) 
                                                    <hr style="width:100%;height:2px;border-width:0;color:gray;background-color:gray">
                                                    @endif
                                                    @endforeach
                                                    @else
                                                    <div class="col-12">
                                                        <div class="row px-3">
                                                            <div class="col-12 col-md-8"></div>
                                                            <div class="col-12 col-md-4 text-md-right mt-2 mt-md-0">
                                                                <button class="btn bg-orange btn-orange font-GilroyBold text-white font-12 px-4"
                                                                data-toggle="modal" data-target="#modalAddressForm">+
                                                                {{trans('label.add_new_address')}}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="changePassword" role="tabpanel" aria-labelledby="changePassword-tab">
                                            <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden">
                                                <div class="col-12">
                                                    <div class="row px-3">
                                                        <div class="col-12">
                                                            <form method="post" action="{{route('user.change_password')}}" id="change-password">
                                                                {{ csrf_field() }}
                                                                <div class="row align-items-center">
                                                                    <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.current_password')}}</label>
                                                                    <div class="col-md-6">
                                                                        <input type="password" name="current_password"
                                                                        class="form-control h-auto py-2">
                                                                    </div>
                                                                </div>
                                                                <div class="row align-items-center mt-3">
                                                                    <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.new_password')}} </label>
                                                                    <div class="col-md-6">
                                                                        <input type="password" name="new_password" id="new_password"
                                                                        class="form-control h-auto py-2">
                                                                    </div>
                                                                </div>
                                                                <div class="row align-items-center mt-3">
                                                                    <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular"> {{trans('label.confirm_password')}}</label>
                                                                    <div class="col-md-6">
                                                                        <input type="password" name="new_confirm_password"
                                                                        class="form-control h-auto py-2">
                                                                    </div>
                                                                </div>
                                                                <div class="row align-items-center mt-3">
                                                                    <div class="col-md-6 offset-md-3">
                                                                        <button class="btn bg-orange btn-orange font-GilroySemiBold text-white font-12 px-4"> {{trans('label.save_changes')}}</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="orderHistory" role="tabpanel" aria-labelledby="orderHistory-tab">
                                            <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden">
                                                <div class="col-12 mt-2  table-responsive">
                                                    <table class="table history-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">ORDER #</th>
                                                                <th scope="col">ORDERED ON</th>
                                                                <th scope="col">COURIER COMPANY</th>
                                                                <th scope="col">TRACKING CODE</th>
                                                                <th scope="col">DISCOUNT</th>
                                                                <th scope="col">TOTAL AMOUNT</th>
                                                                <th scope="col">STATUS</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(isset($orders) && count($orders) > 0)
                                                            @foreach($orders as $order)
                                                            <tr data-toggle="collapse" data-target="#order{{$order->id}}"
                                                                class="accordion-toggle" id="main">
                                                                <td>{{ $order->order_id}}</td>
                                                                <td>{{ date('d/m/Y h:i:s',strtotime($order->created_at)) }}</td>
                                                                <td>
                                                                    @if($order->shippingCompany && $order->courier_company_name !=
                                                                    null && $order->courier_company_name != '' )
                                                                    {{ $order->shippingCompany->name }}({{
                                                                        $order->shippingCompany->slug }})
                                                                        @else
                                                                        @foreach($order->counriercompanies as $companyDetail)
                                                                        {{$companyDetail->shippingcomapny['name']}}<br>
                                                                        @endforeach
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        @if($order->tracking_number != null && $order->tracking_number!= '')
                                                                        {{ $order->tracking_number }}
                                                                        @else
                                                                        @if($order->tracking_no && count($order->tracking_no) > 0)
                                                                        @foreach($order->tracking_no as $track)
                                                                        @if($track->tracking_number != null && $track->tracking_number != '')
                                                                        {{ $track->tracking_number }}<br>
                                                                        @endif
                                                                        @endforeach
                                                                        @endif
                                                                        @endif
                                                                    </td>
                                                                    <td>RM {{ number_format(($order->discount + $order->product_discount),2) }}</td>
                                                                    <td>
                                                                        RM {{
                                                                            number_format($order->getorderpricebyidwithoutshipping($order->id),2)
                                                                        }}{{-- +$order->shipping_charge --}}
                                                                    </td>

                                                                    <td>
                                                                        {{ucfirst($order->status)}}
                                                                    </td>
                                                                </tr>
                                                                <tr id="sub">
                                                                    <td colspan="12" class="hiddenRow">
                                                                        <div class=" collapse" id="order{{$order->id}}">
                                                                            <table class="table">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="20%">Product</th>
                                                                                        <th width="5%">Qty</th>
                                                                                        <th width="7%">Price </th>
                                                                                        <th width="9%">Created</th>
                                                                                        @if($order->status == 'delivered')
                                                                                        <th width="59%">Rate</th>
                                                                                        @endif
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($order->orderProduct as $product)
                                                                                    @if($product->productdetail &&
                                                                                    $product->productdetail != null)
                                                                                    <tr>
                                                                                        <td>{{$product->productdetail->name}}</td>
                                                                                        <td>{{$product->qty}}</td>
                                                                                        <td>{{$product->price}}</td>
                                                                                        <td>{{date('d-m-Y H:i:s',
                                                                                            strtotime($product->created_at))}}</td>
                                                                                <!-- @if($order->status == 'delivered')
                                                                                <td id="product-rate-div">
                                                                                    <form id="rateProduct{{$product->id}}">
                                                                                        {{ csrf_field() }}
                                                                                        <div class="row">
                                                                                            <input type="hidden"
                                                                                                name="orderProductId"
                                                                                                value="{{$product->id}}"
                                                                                                id="orderProductId">
                                                                                            <input type="hidden"
                                                                                                name="productId"
                                                                                                value="{{$product->productdetail->id}}"
                                                                                                id="productId">
                                                                                            <div class="col-3">
                                                                                                <input type="number" name="rate"
                                                                                                    class="form-control login-border login-ph mt-2"
                                                                                                    min="1" max="5" value="5"
                                                                                                    id="rate">
                                                                                            </div>
                                                                                            <div class="col-9">
                                                                                                <textarea id="description"
                                                                                                    name="description" rows="4"
                                                                                                    cols="50"
                                                                                                    class="form-control login-border login-ph mt-2"> </textarea>
                                                                                            </div>
                                                                                            <div class="col-lg-3">
                                                                                                <br /><br /><br />
                                                                                                <label
                                                                                                    class="col-form-label">Product
                                                                                                    Images</label>
                                                                                            </div>
                                                                                            <div
                                                                                                class="col-lg-9 col-md-9 col-sm-12">
                                                                                                <div class="m-dropzone dropzone m-dropzone--primary productDropZonenew"
                                                                                                    id="productDropZonenew{{$product->id}}"
                                                                                                    action="/" method="post">
                                                                                                    <div
                                                                                                        class="m-dropzone__msg dz-message needsclick">
                                                                                                        <h3
                                                                                                            class="m-dropzone__msg-title">
                                                                                                            Drop image here</h3>
                                                                                                        <span
                                                                                                            class="m-dropzone__msg-desc">Allowed
                                                                                                            only image
                                                                                                            files</span>
                                                                                                    </div>
                                                                                                    <div id="image_data"></div>
                                                                                                    <div id="image-holder">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </form>
                                                                                    <button
                                                                                        class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 mt-3 submitreview"
                                                                                        data-id="{{$product->id}}"
                                                                                        id="submitreview{{$product->id}}">
                                                                                        Submit your review</button>
                                                                                </td>
                                                                                @endif -->
                                                                            </tr>
                                                                            @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
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

        <div class="modal fade" id="modalAddressForm" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.add_new_address')}}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" id="address-form">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-lg-12 form-group-sub">
                                    <div class="form-group">
                                        <div class="from-inner-space">
                                            <label class="mb-2 bmd-label-static">
                                                {{trans('label.full_name')}}: <span class="text-red">*</span>
                                            </label>
                                            <div class="form-element">
                                                <input class="form-control" type="text" placeholder="{{trans('label.enter_full_name')}}"
                                                name="name" id="name" title="{{trans('label.please_enter_full_name')}}" autofocus>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 form-group-sub">
                                    <div class="form-group">
                                        <div class="from-inner-space">
                                            <label class="mb-2 bmd-label-static">
                                                {{trans('label.phone_number')}}: <span class="text-red">*</span>
                                            </label>
                                            <div class="form-element row">
                                                <div class="col-lg-3">
                                                    <select name="country_code" class="form-control country_code" id="country_code">
                                                        <option value="+60"> &nbsp;+60 &nbsp;</option>
                                                        <option value="+65"> &nbsp;+65 &nbsp;</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-9">
                                                    <input class="phonenumber form-control" placeholder="{{trans('label.enter_phone_number')}}"
                                                    id="mobile" type="tel" class="" name="phone" minlength="9"
                                                    maxlength="10" title="{{trans('label.please_enter_valid_mobile_number')}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 form-group-sub">
                                    <div class="form-group">
                                        <div class="from-inner-space">
                                            <label class="mb-2 bmd-label-static">
                                                {{trans('label.address_line_1')}}: <span class="text-red">*</span>
                                            </label>
                                            <div class="form-element">
                                                <input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_1')}}"
                                                name="address_line1" id="address_line1" required
                                                title="{{trans('label.please_enter_address_line')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12 form-group-sub">
                                    <div class="form-group">
                                        <div class="from-inner-space">
                                            <label class="mb-2 bmd-label-static">
                                                {{trans('label.address_line_2')}}:
                                            </label>
                                            <div class="form-element">
                                              <input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_2')}}"
                                              name="address_line2" id="address_line2">
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group row">
                            <div class="col-lg-12 form-group-sub">
                                <div class="form-group">
                                    <div class="from-inner-space">
                                        <label class="mb-2 bmd-label-static">
                                            {{trans('label.postcode')}}: <span class="text-red">*</span>
                                        </label>
                                        <div class="form-element">
                                          <input class="form-control" type="tel" placeholder="{{trans('label.enter_postcode')}}"
                                          name="postal_code" id="postal_code" title="{{trans('label.please_enter_postcode')}}"
                                          minlength="5" maxlength="5">
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.city')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                      <input class="form-control" type="text" placeholder="{{trans('label.enter_city')}}" id="town"
                                      name="town" title="{{trans('label.please_enter_city')}}">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group row">
                    <div class="col-lg-12 form-group-sub">
                        <div class="form-group">
                            <div class="from-inner-space">
                                <label class="mb-2 bmd-label-static">
                                    {{trans('label.state')}}: <span class="text-red">*</span>
                                </label>
                                <div class="form-element">
                                  <select class=" m-select form-control" name="state" id="state" title="{{trans('label.please_select_any_one_state')}}">
                                     <option value="" label="{{trans('label.select_a_state_region')}}" class="ng-binding">{{trans('label.select_a_state_region')}}</option>
                                     <option value="Kuala Lumpur" label="Kuala Lumpur">Kuala Lumpur</option>
                                     <option value="Labuan" label="Labuan">Labuan</option>
                                     <option value="Putrajaya" label="Putrajaya">Putrajaya</option>
                                     <option value="Johor" label="Johor">Johor</option>
                                     <option value="Kedah" label="Kedah">Kedah</option>
                                     <option value="Kelantan" label="Kelantan">Kelantan</option>
                                     <option value="Melaka" label="Melaka">Melaka</option>
                                     <option value="Negeri Sembilan" label="Negeri Sembilan">Negeri Sembilan</option>
                                     <option value="Pahang" label="Pahang">Pahang</option>
                                     <option value="Perak" label="Perak">Perak</option>
                                     <option value="Perlis" label="Perlis">Perlis</option>
                                     <option value="Pulau Pinang" label="Pulau Pinang">Pulau Pinang</option>
                                     <option value="Sabah" label="Sabah">Sabah</option>
                                     <option value="Sarawak" label="Sarawak">Sarawak</option>
                                     <option value="Selangor" label="Selangor">Selangor</option>
                                     <option value="Terengganu" label="Terengganu">Terengganu</option>
                                 </select>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
             <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="mb-2 bmd-label-static">
                                {{trans('label.country')}}: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                              <input class="form-control" placeholder="{{trans('label.country')}}" type="text" class=""
                              name="country" value="Malaysia" disabled="disabled">
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <div class="form-group row">
            <div class="col-lg-12 form-group-sub">
                <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
                id="address-button">{{trans('label.save')}}</button>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="editModalAddressForm" tabindex="-1" role="dialog" aria-labelledby="editAddress"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.edit_address')}}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" id="edit-address-form">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-lg-12 form-group-sub">
                        <div class="form-group">
                            <div class="from-inner-space">
                                <label class="mb-2 bmd-label-static">
                                    {{trans('label.full_name')}}: <span class="text-red">*</span>
                                </label>
                                <div class="form-element">
                                    <input class="form-control" type="text" placeholder="{{trans('label.enter_full_name')}}"
                                    name="name" id="name" title="{{trans('label.please_enter_full_name')}}" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-12 form-group-sub">
                        <div class="form-group">
                            <div class="from-inner-space">
                                <label class="mb-2 bmd-label-static">
                                    {{trans('label.phone_number')}}: <span class="text-red">*</span>
                                </label>
                                <div class="form-element row">
                                    <div class="col-lg-3">
                                        <select name="country_code" class="form-control country_code"
                                        id="country_code">
                                        <option value="+60">+60</option>
                                        <option value="+65">+65</option>
                                    </select>
                                </div>
                                <div class="col-lg-9">
                                    <input class="phonenumber form-control" placeholder="{{trans('label.enter_phone_number')}}"
                                    id="mobile" type="tel" class="" name="phone" minlength="9"
                                    maxlength="10" title="{{trans('label.please_enter_valid_mobile_number')}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="mb-2 bmd-label-static">
                                {{trans('label.address_line_1')}}: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_1')}}"
                                name="address_line1" id="address_line1" required
                                title="{{trans('label.please_enter_address_line')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="mb-2 bmd-label-static">
                                {{trans('label.address_line_2')}}:
                            </label>
                            <div class="form-element">
                                <input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_2')}}"
                                name="address_line2" id="address_line2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="mb-2 bmd-label-static">
                                {{trans('label.postcode')}}: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control" type="tel" placeholder="{{trans('label.enter_postcode')}}"
                                name="postal_code" id="postal_code" title="{{trans('label.please_enter_postcode')}}"
                                minlength="5" maxlength="5">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="mb-2 bmd-label-static">
                                {{trans('label.city')}}: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control" type="text" placeholder="{{trans('label.enter_city')}}" id="town"
                                name="town" title="{{trans('label.please_enter_city')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="bmd-label-static">
                                {{trans('label.state')}}: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <select class=" m-select form-control" name="state" id="state" title="{{trans('label.please_select_any_one_state')}}">
                                    <option value="" label="{{trans('label.select_a_state_region')}}" class="ng-binding">{{trans('label.select_a_state_region')}}</option>
                                    <option value="Kuala Lumpur" label="Kuala Lumpur">Kuala Lumpur</option>
                                    <option value="Labuan" label="Labuan">Labuan</option>
                                    <option value="Putrajaya" label="Putrajaya">Putrajaya</option>
                                    <option value="Johor" label="Johor">Johor</option>
                                    <option value="Kedah" label="Kedah">Kedah</option>
                                    <option value="Kelantan" label="Kelantan">Kelantan</option>
                                    <option value="Melaka" label="Melaka">Melaka</option>
                                    <option value="Negeri Sembilan" label="Negeri Sembilan">Negeri Sembilan</option>
                                    <option value="Pahang" label="Pahang">Pahang</option>
                                    <option value="Perak" label="Perak">Perak</option>
                                    <option value="Perlis" label="Perlis">Perlis</option>
                                    <option value="Pulau Pinang" label="Pulau Pinang">Pulau Pinang</option>
                                    <option value="Sabah" label="Sabah">Sabah</option>
                                    <option value="Sarawak" label="Sarawak">Sarawak</option>
                                    <option value="Selangor" label="Selangor">Selangor</option>
                                    <option value="Terengganu" label="Terengganu">Terengganu</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="mb-2 bmd-label-static">
                                {{trans('label.country')}}: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control" placeholder="{{trans('label.country')}}" type="text" class=""
                                name="country" value="Malaysia" disabled="disabled">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="form-group row">
                <div class="col-lg-12 form-group-sub">
                    <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
                    id="address-button">{{trans('label.save')}}</button>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
</div>
@endsection
@section('script')
<script>
    // var url = document.URL;
    // var hash = url.substring(url.indexOf("#"));
    // if(url != hash){
    //     $(hash+'-tab').trigger('click');
    // }


    var id;

    // on modal show
    $('#editModalAddressForm').on('show.bs.modal', function(e) {
        var button = $(e.relatedTarget) // Button that triggered the modal
        id = button.data('id');

        var address_id = id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{route("user.get_address")}}',
            type: 'POST',
            data: {
                "addressId": address_id,
            },
            success: (response) => {
                if (response) {
                    var contactNumber =  response.contact_number ? response.contact_number : response.contact_no;
                    var countryCode =  response.country_code ? response.country_code : response.countrycode;
                    $(this).find('#name').val(response.name);
                    $(this).find('#country_code').val(countryCode);
                    $(this).find('#mobile').val(contactNumber);
                    $(this).find('#address_line1').val(response.address_line1);
                    $(this).find('#address_line2').val(response.address_line2);
                    $(this).find('#postal_code').val(response.postal_code);
                    $(this).find('#town').val(response.town);
                    $(this).find('#state').val(response.state);
                }
            },
            error: function (response) {

            }
        });
    });

    $('#editModalAddressForm').on('hidden.bs.modal', function () {
        // $(this).find('form').trigger('reset');
        $('#edit-address-form').trigger("reset");
    });

    $(document).on('click', '.default-address', function () {
        var addressId = $(this).data("id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{route("user.set_default_address")}}',
            type: 'POST',
            data: {
                "addressId": addressId,
            },
            success: (response) => {
                if (response) {
                    $("#address-list").load(location.href+" #address-list>*","");
                }
            },
            error: function (response) {
            }
        });
    });

    $("#user-img").change(function (e) {
        var formData = new FormData();

        var photo = $('#user-img').prop('files')[0];

        formData.append('image', photo);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '{{route("user.upload_image")}}',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                if (response) {
                    $("#imgdiv").load(location.href + " #imgdiv");

                }
            },
            error: function (response) {

            }
        });
    });

    $(function () {
        $("#address-form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 8
                },
                postal_code: {
                    required: true,
                    minlength: 4
                },
                state: {
                    required: true,
                },
                town: {
                    required: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 9,
                    maxlength: 15,
                }
            },
            messages: {
                name: {
                    required: "Please enter name",
                    minlength: "Minimum 8 characters required"
                },
                postal_code: {
                    required: "Please enter postal code",
                    minlength: "Minimum 4 characters required"
                },
                state: {
                    required: "Please select state",
                },
                town: {
                    required: "Please enter city",
                },
                phone: {
                    required: "Please enter phone",
                    digits: "Only digits are allowed",
                    minlength: "Minimum 9 characters required",
                    maxlength: "Maximun 15 characters are allowed",
                }
            },
            submitHandler: function (form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var postData = $(form).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('user.add_address')}}",
                    data: postData,
                    success: (response) => {
                        if (response) {
                            $("#address-list").load(location.href+" #address-list>*","");
                        }
                    },
                    error: function (data) {
                        $("#address-list").load(location.href+" #address-list>*","");
                    }
                });
                $('#modalAddressForm').modal('hide');

                $('#modalAddressForm').on('hidden.bs.modal', function () {
                    $(this).find('form').trigger('reset');
                })
            }
        });

        $("#change-password").validate({
            rules: {
                current_password: {
                    required: true,
                },
                new_password: {
                    required: true,
                    minlength: 5
                },
                new_confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#new_password"
                }
            }
        });

        $("#edit-address-form").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 8
                },
                postal_code: {
                    required: true,
                    minlength: 4
                },
                state: {
                    required: true,
                },
                town: {
                    required: true,
                },
                phone: {
                    required: true,
                    digits: true,
                    minlength: 9,
                    maxlength: 15,
                }
            },
            messages: {
                name: {
                    required: "Please enter name",
                    minlength: "Minimum 8 characters required"
                },
                postal_code: {
                    required: "Please enter postal code",
                    minlength: "Minimum 4 characters required"
                },
                state: {
                    required: "Please select state",
                },
                town: {
                    required: "Please enter city",
                },
                phone: {
                    required: "Please enter phone",
                    digits: "Only digits are allowed",
                    minlength: "Minimum 9 characters required",
                    maxlength: "Maximun 15 characters are allowed",
                }
            },
            submitHandler: function (form) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var postData = $(form).serializeArray();
                $.ajax({
                    type: "POST",
                    url: "{{route('user.update_address')}}",
                    data:{'postData':postData,'address_id':id},
                    success: (response) => {
                        if (response) {
                            $("#address-list").load(location.href+" #address-list>*","");
                        }
                    },
                    error: function (data) {
                        $("#address-list").load(location.href+" #address-list>*","");
                    }
                });
                $('#editModalAddressForm').modal('hide');

                $('#editModalAddressForm').on('hidden.bs.modal', function () {
                    $(this).find('form').trigger('reset');
                })
            }
        });
    });

$('#modalAddressForm').on('hidden.bs.modal', function () {
    $(this).find('form').trigger('reset');
});

$(document).on("keyup", ".profile-form", function (e) {
    if (e.keyCode == 13) {
        $('.emailText').show();
        $('.emailInput').hide();
        var name = $(this).attr('name');
        var value = $(this).val();
        var divName = '#' + name + '-div';
        var type = (name == 'email') ? 'email' : 'phone';
            //    var close = $(this).attr("data-name");
            var data;

            if (type == 'email') {
                data = {
                    'type': type,
                    'email': value
                }
            } else {
                data = {
                    'type': type,
                    'phone': value
                }
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '{{route("user.edit_profile")}}',
                type: 'POST',
                data: data,
                success: (response) => {
                    if (response) {
                        $("#email-div").load(" #email-div > *");
                        $("#phone-div").load(" #phone-div > *");
                    }
                },
                error: function (response) {

                },
                complete: function () {
                    //Hide the loader over here
                    $(".closeEmailEdit").trigger("click");
                    $(".closeNumberEdit").trigger("click");
                }

            });
        }
    });
$("#shipping-address").click(function (e) {
    $('.nav li.active').removeClass('active');
    var $parent = $(this).parent();
    $parent.addClass('active');
    e.preventDefault();
    $("#addresses-tab").click();
});
$(document).on("click", ".delete-address", function(){
    var addressId = $(this).data("id");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '{{route("user.delete_address")}}',
        type: 'POST',
        data: {
            "addressId": addressId,
        },
        success: (response) => {
            if (response) {
                $("#address-list").load(location.href+" #address-list>*","");
            }
        },
        error: function (response) {
        }
    });
});

$('input[type=radio][name=gender]').change(function () {
    var value = $(this).val();
    data = {
        'gender': value,
    }
    updateProfile(data);
});
function updateProfile(data) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '{{route("user.edit_profile")}}',
        type: 'POST',
        data: data,
        success: (response) => {

        }
    });
}

$("#name").keyup(function () {
    var value = $(this).val();
    data = {
        'name': value,
    }
    updateProfile(data);
    $("#name").load(location.href + " #name");
});

$(".submitreview").click(function () {
    var name = $(this).data("id")
    var data = $('#rateProduct' + name).serialize();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '{{route("user.submit_review")}}',
        type: 'POST',
        data: data,
        success: function (response) {
            location.reload(true);
        },
        error: function (response) {

        }
    });
});

$("#race").change(function () {
    var value = $(this).val();
    if (value != '' && value != null) {
        data = {
            'race': value,
        }
        updateProfile(data);
        $("#race-div").load(location.href + " #race-div>*", "");
    }
});

</script>
@endsection