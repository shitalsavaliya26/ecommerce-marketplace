<section class="bg-orange">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse flex-lg-wrap" id="navbarSupportedContent">
            <ul class="navbar-nav align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link font-GilroyMedium text-white font-14 pl-lg-0" href="{{config('services.MERCHANT_PORTAL')}}" target="_blank">{{trans('label.merchant_centre')}}</a>
                </li>
                @if($sellers && count($sellers) > 0)
                <li class="nav-item text-white mx-3 d-none d-lg-block">|</li>
                @foreach($sellers as $seller)
                <li class="nav-item">
                    <a class="nav-link font-GilroyMedium text-white font-14" href="{{ route('seller.mall', ['seller' => $seller->name, 'id' => App\Helpers\Helper::encrypt($seller->id)]) }}">{{trans('label.maxshop_mall')}}</a>
                </li>
                @endforeach
                @endif
                <li class="nav-item text-white mx-3 d-none d-lg-block">|</li>
                <li class="nav-item">
                    <a class="nav-link font-GilroyMedium text-white font-14" href="#">{{trans('label.download')}}</a>
                </li>
                <li class="nav-item text-white mx-3 d-none d-lg-block">|</li>
                <li class="nav-item">
                    <a class="nav-link font-GilroyMedium text-white font-14" href="#">{{trans('label.follow_us_on')}}</a>
                </li>
            </ul>
            <ul class="navbar-nav align-items-lg-center flex-row">
                <li class="nav-item mr-2 mr-lg-0">
                    <a class="nav-link text-white font-14" href="#">
                        <img src="{{ asset('assets/images/facebook.png') }}" class="w-20px h-20px img-fluid" alt="">
                    </a>
                </li>
                <li class="nav-item mr-2 mr-lg-0">
                    <a class="nav-link text-white font-14" href="#">
                        <img src="{{ asset('assets/images/Instagram.png') }}" class="w-20px h-20px img-fluid"
                        alt="">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white font-14" href="#">
                        <img src="{{ asset('assets/images/Twitter.png') }}" class="w-20px h-20px img-fluid" alt="">
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav align-items-lg-center ml-xl-auto">
                @if($limitNotifications &&  count($limitNotifications) > 0)
                <li class="nav-item position-relative cus-notification">
                    <a class="nav-link font-GilroyMedium text-white font-14 pl-lg-0" href="">
                        <span class="position-relative mr-1">
                            <span class="notification-count">{{$notificationCount}}</span>
                            <img src="{{ asset('assets/images/Notification.png') }}" class="w-20px h-20px img-fluid"
                            alt="">
                        </span>
                        <span>{{trans('label.notification')}}</span>
                    </a>
                    <div class="cus-notification-popup bg-white shadow br-8 pb-4">
                        <div class="row mx-0">
                            <div class="col-12 py-2">
                                <h4 class="text-gray font-14 mb-1">{{trans('label.recentaly_received_notifications')}}</h4>
                            </div>
                            @foreach($limitNotifications as $notification)
                            <div class="col-12 px-0">
                                <div class="d-flex align-items-center cursor-pointer notification-single px-3">
                                    <div>
                                        <img src="assets/images/adidas-logo.png" class="img-fluid max-w-60px mr-2"
                                        alt="">
                                    </div>
                                    <div>
                                        <!-- <h4 class="text-black font-14 mb-1">What a new Phone</h4> -->
                                        <p class="text-black font-12 mb-0">{{$notification->message}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if($notificationCount > 5)
                            <div class="col-12 text-center mt-3">
                                <a href="{{ route('viewNotification') }}"
                                class="btn btn-block bg-orange orange-btn text-white font-14 rounded-1">{{trans('label.view_all')}}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link font-GilroyMedium text-white font-14 d-flex align-items-center" href="#">
                        <img src="{{ asset('assets/images/Help.png') }}" class="w-20px h-20px img-fluid mr-1"
                        alt="">
                        <span>{{trans('label.help')}}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link font-GilroyMedium text-white font-14 d-flex align-items-center dropdown-toggle cursor-pointer"
                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <img src="{{ asset('assets/images/globe.png') }}" class="w-20px h-20px img-fluid mr-1" alt="">
                        <span>{{$language}}</span>
                    </a>
                    @php
                    $local_url = url('locale');
                    @endphp
                    <div class="dropdown-menu w-auto" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo $local_url; ?>/en'">English</a>
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo $local_url; ?>/chi'">Chinese</a>
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo $local_url; ?>/my'">Malay</a>
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo $local_url; ?>/th'">Thai</a>
                        <a class="dropdown-item" href="#" onclick="javascript:window.location.href='<?php echo $local_url; ?>/vi'">Vietnamese</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
</div>
</section>
<section class="bg-white py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-lg-auto text-center">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/Logo.png') }}" class="img-fluid max-w-170px" alt="">
                </a>
            </div>

            <div class="col-12 col-lg-5">
                <form class="d-flex my-2 my-lg-0 shadow rounded-pill bg-white" method="get" action="{{route('searchfilter')}}">
                    <input class="form-control rounded-pill border-0 shadow-none cus-input-ph" type="search" name="search" id="searchKeyword" value="{{ app('request')->input('search') }}"
                    placeholder="{{trans('label.serach_placeholder')}}" aria-label="Search" autocomplete="off" onkeyup="showHints()" data-toggle="dropdown">
                    <ul class="dropdown-menu search-data" data-input="searchKeyword" style="width:80%"></ul>
                    <button class="btn bg-orange orange-btn text-white rounded-pill font-14 my-1 mr-1 px-4 font-GilroySemiBold search-data"
                    type="submit">{{trans('label.search')}}
                </button>
            </form>
        </div>
        <div class="col-8 col-md-6 col-lg-3">
            <div class="d-flex align-items-center profile-dropdown">
                @guest
                <div class="d-flex flex-column flex-sm-row align-items-sm-center">
                    <a href="{{ route('login') }}"
                    class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 ml-2 mt-2 mt-sm-0 font-GilroyMedium">{{trans('label.log_in')}}</a>
                    <a href="{{ route('register') }}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 ml-2 mt-2 mt-sm-0 font-GilroyMedium">{{trans('label.sign_up')}}</a>
                    <!-- <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 ml-2 mt-2">Logout</button> -->
                </div>
                @else
                <div class="d-flex align-items-center dropdown-toggle cursor-pointer" id="dropdownMenuButton"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div>
                    <img onerror="this.src='{{asset('assets/images/User.png')}}'"  src="{{ Auth::user()->image }}" class="img-fluid max-w-70px rounded-circle" alt="">
                </div>
                <div class="ml-2">
                    <h1 class="text-black font-16 font-GilroyBold mb-1">{{ Auth::user()->name }}</h1>
                    <div class="d-flex align-items-center">
                        <p class="font-14 text-black font-GilroyMedium mb-0">RM{{ Auth::user()->wallet_amount }}</p>
                        @if(Auth::user()->coin_balance > 0)
                        <p class="font-10 text-yellow mb-0 font-GilroyMedium ml-2"> {{number_format(Auth::user()->coin_balance,2) }} {{trans('label.coins')}}</p>
                        @else
                        <p class="font-10 text-yellow mb-0 font-GilroyMedium ml-2">0 {{trans('label.coin')}}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{route('user.profile')}}">{{trans('label.profile')}}</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{trans('label.logout')}}</a>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            @endguest
        </div>
    </div>
    <div class="col-4 col-md-6 col-lg-1 ml-lg-auto mr-lg-3">
        <div class="cus-cart position-relative">
            <a href="@if($cart != 0) {{route('viewcart')}} @else javascript:void(0) @endif" class="text-right text-lg-left">
                <span class="position-relative">
                    <span class="cart-count">{{$cart}}</span>
                    <img src="{{ asset('assets/images/Cart.png') }}" class="img-fluid w-35px" alt="">
                </span>
            </a>
            <div class="cus-cart-popup bg-white shadow br-8 pb-4">
                <div class="row mx-0">
                    <div class="col-12 py-2">
                        <h4 class="text-gray font-14 mb-1">{{trans('label.recentaly_added_products')}}</h4>
                    </div>
                    @foreach($cartitems as $item)
                    <?php $product = $item->productdetails;  ?>
                    <div class="col-12 px-0">
                        <div class="d-flex align-items-center justify-content-between notification-single px-3 py-1">
                            <div>
                                <img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{ $product->images[0]->thumb }}" class="img-fluid max-w-60px mr-2 prd-image"
                                alt="">
                                <span class="text-black font-14 mb-1">{{$product->name}}</span>
                            </div>
                            <div>
                                <h4 class="text-orange font-14 mb-1">RM{{($item->variation_id != 0) ? $item->variation->sell_price : $product->sell_price}}</h4>
                            </div>
                        </div>
                    </div>
                    @endforeach
                            <!--  <div class="col-12 px-0 mt-2">
                                    <div
                                        class="d-flex align-items-center justify-content-between notification-single px-3 py-1">
                                        <div>
                                            <img src="assets/images/adidas-logo.png" class="img-fluid max-w-60px mr-2"
                                                alt="">
                                            <span class="text-black font-14 mb-1">What a new Phone</span>
                                        </div>
                                        <div>
                                            <h4 class="text-orange font-14 mb-1">RM2,000</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 px-0 mt-2">
                                    <div
                                        class="d-flex align-items-center justify-content-between notification-single px-3 py-1">
                                        <div>
                                            <img src="assets/images/adidas-logo.png" class="img-fluid max-w-60px mr-2"
                                                alt="">
                                            <span class="text-black font-14 mb-1">What a new Phone</span>
                                        </div>
                                        <div>
                                            <h4 class="text-orange font-14 mb-1">RM2,000</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 px-0 mt-2">
                                    <div
                                        class="d-flex align-items-center justify-content-between notification-single px-3 py-1">
                                        <div>
                                            <img src="assets/images/adidas-logo.png" class="img-fluid max-w-60px mr-2"
                                                alt="">
                                            <span class="text-black font-14 mb-1">What a new Phone</span>
                                        </div>
                                        <div>
                                            <h4 class="text-orange font-14 mb-1">RM2,000</h4>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-12 text-right mt-2">
                                    <a href="{{route('viewcart')}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-2">
                                    {{trans('label.view_my_shopping_cart')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>