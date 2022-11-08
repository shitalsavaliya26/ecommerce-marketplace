<!doctype html>
<html lang="en">
    <head>
        <title>{{ config('app.name', 'Maxshop') }}</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{  asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{  asset('assets/bootstrap/css/slick.min.css') }}">
        <link rel="stylesheet" href="{{  asset('assets/css/toastr.min.css') }}">

        <style>
            a:hover {
                text-decoration: none;
            }

            .error {
                color: red;
            }
        </style>
        <link rel="stylesheet" href="{{  asset('assets/css/style.css').'?v='.time() }}">
    </head>

    <body>
        <!---------------------------------Header start-------------------------------->
        <section class="bg-orange">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav align-items-lg-center">
                            <li class="nav-item">
                                <a class="nav-link font-GilroyMedium text-white font-14 pl-lg-0" href="{{config('services.MERCHANT_PORTAL')}}" target="_blank">{{trans('label.merchant_centre')}}</a>
                            </li>
                            <li class="nav-item text-white mx-3 d-none d-lg-block">|</li>
                            <li class="nav-item">
                                <a class="nav-link font-GilroyMedium text-white font-14" href="#">{{trans('label.maxshop_mall')}}</a>
                            </li>
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
                                    <img src="{{ asset('assets/images/facebook.png') }}" class="w-20px h-20px img-fluid"
                                    alt="">
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
                                    <img src="{{ asset('assets/images/Twitter.png') }}" class="w-20px h-20px img-fluid"
                                    alt="">
                                </a>
                            </li>
                        </ul>
                        <ul class="navbar-nav align-items-lg-center ml-xl-auto">
                            <li class="nav-item position-relative cus-notification">
                                <a class="nav-link font-GilroyMedium text-white font-14 pl-lg-0" href="">
                                    <span class="position-relative mr-1">
                                        <span class="notification-count">12</span>
                                        <img src="{{ asset('assets/images/Notification.png') }}"
                                        class="w-20px h-20px img-fluid" alt="">
                                    </span>
                                    <span>{{trans('label.notification')}}</span>
                                </a>
                                <div class="cus-notification-popup bg-white shadow br-8 pb-4">
                                    <div class="row mx-0">
                                        <div class="col-12 py-2">
                                            <h4 class="text-gray font-14 mb-1">{{trans('label.recentaly_received_notifications')}}</h4>
                                        </div>
                                        <div class="col-12 px-0">
                                            <div class="d-flex align-items-center cursor-pointer notification-single px-3">
                                                <div>
                                                    <img src="assets/images/adidas-logo.png" class="img-fluid max-w-60px mr-2" alt="">
                                                </div>
                                                <div>
                                                    <h4 class="text-black font-14 mb-1">What a new Phone</h4>
                                                    <p class="text-black font-12 mb-0">DANS Ladies Flat Shoes - Black/Camel
                                                    12200339144 (NN1,2,</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0 mt-2">
                                            <div class="d-flex align-items-center cursor-pointer notification-single px-3">
                                                <div>
                                                    <img src="assets/images/adidas-logo.png" class="img-fluid max-w-60px mr-2" alt="">
                                                </div>
                                                <div>
                                                    <h4 class="text-black font-14 mb-1">What a new Phone</h4>
                                                    <p class="text-black font-12 mb-0">DANS Ladies Flat Shoes - Black/Camel
                                                    12200339144 (NN1,2,</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0 mt-2">
                                            <div class="d-flex align-items-center cursor-pointer notification-single px-3">
                                                <div>
                                                    <img src="assets/images/adidas-logo.png"
                                                    class="img-fluid max-w-60px mr-2" alt="">
                                                </div>
                                                <div>
                                                    <h4 class="text-black font-14 mb-1">What a new Phone</h4>
                                                    <p class="text-black font-12 mb-0">DANS Ladies Flat Shoes - Black/Camel
                                                    12200339144 (NN1,2,</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0 mt-2">
                                            <div class="d-flex align-items-center cursor-pointer notification-single px-3">
                                                <div>
                                                    <img src="assets/images/adidas-logo.png"
                                                    class="img-fluid max-w-60px mr-2" alt="">
                                                </div>
                                                <div>
                                                    <h4 class="text-black font-14 mb-1">What a new Phone</h4>
                                                    <p class="text-black font-12 mb-0">DANS Ladies Flat Shoes - Black/Camel
                                                    12200339144 (NN1,2,</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 px-0 mt-2">
                                            <div class="d-flex align-items-center cursor-pointer notification-single px-3">
                                                <div>
                                                    <img src="assets/images/adidas-logo.png"
                                                    class="img-fluid max-w-60px mr-2" alt="">
                                                </div>
                                                <div>
                                                    <h4 class="text-black font-14 mb-1">What a new Phone</h4>
                                                    <p class="text-black font-12 mb-0">DANS Ladies Flat Shoes - Black/Camel
                                                    12200339144 (NN1,2,</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 text-center mt-3">
                                            <a href="#" class="btn btn-block bg-orange orange-btn text-white font-14 rounded-1">{{trans('label.view_all')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </li>
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
                                        <span>{{trans('label.language')}}</span>
                                    </a>
                                    <div class="dropdown-menu w-auto" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">English</a>
                                        <a class="dropdown-item" href="#">Chinese</a>
                                        <a class="dropdown-item" href="#">Spanish</a>
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
                            <input class="form-control rounded-pill border-0 shadow-none cus-input-ph" type="search"
                                name="search" id="searchKeyword" value="{{ app('request')->input('search') }}"
                                placeholder="{{trans('label.serach_placeholder')}}" aria-label="Search" autocomplete="off">
                            <button class="btn bg-orange orange-btn text-white rounded-pill font-14 my-1 mr-1 px-4 font-GilroySemiBold search-data"
                                type="submit">{{trans('label.search')}}</button>
                        </form>
                    </div>
                    <div class="col-8 col-md-6 col-lg-3">
                        <div class="dropdown profile-dropdown">
                            @guest
                                <div class="d-flex align-items-center">
                                    <div class="d-flex flex-column flex-sm-row align-items-sm-center">
                                        <a href="{{ route('login') }}"
                                            class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 ml-2 mt-2 mt-sm-0 font-GilroyMedium">{{trans('label.log_in')}}</a>
                                        <a href="{{ route('register') }}"
                                            class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 ml-2 mt-2 mt-sm-0 font-GilroyMedium">{{trans('label.sign_up')}}</a>
                                        <!-- <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 ml-2 mt-2">Logout</button> -->
                                    </div>
                                </div>
                            @else
                                <div class="d-flex align-items-center dropdown-toggle cursor-pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div>
                                        <img src="{{ asset('assets/images/User.png') }}"
                                        class="img-fluid max-w-70px rounded-circle" alt="">
                                    </div>
                                    <div class="ml-2">
                                        <h1 class="text-black font-16 font-GilroyBold mb-1">{{ Auth::user()->name }}</h1>
                                        <p class="font-14 text-black font-GilroyMedium mb-0">RM{{ Auth::user()->wallet_amount }}</p>
                                        @if(Auth::user()->coin_balance > 0)
                                            <p class="font-10 text-yellow mb-0 font-GilroyMedium ml-2"> {{number_format(Auth::user()->coin_balance,2) }} {{trans('label.coins')}}</p>
                                        @else
                                            <p class="font-10 text-yellow mb-0 font-GilroyMedium ml-2">0 {{trans('label.coin')}}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{route('user.profile')}}">{{trans('label.action')}}</a>
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
                        <div class="text-right text-lg-left">
                            <span class="position-relative">
                                <span class="cart-count font-GilroyExtraBold">0</span>
                                <img src="assets/images/Cart.png" class="img-fluid w-35px" alt="">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!---------------------------------Header end-------------------------------->
        @yield('content')
        <!-- <section class="bg-login d-flex align-items-center justify-content-center py-5">
            <div class="container py-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                        <div class="bg-white br-15 py-4 px-3 px-sm-5 shadow">
                            <img src="{{ asset('assets/images/Logo.png') }}" class="img-fluid max-w-150px mx-auto d-block" alt="">
                            <h2 class="text-black mb-0 py-3 font-GilroyBold">Log In</h2>
                            <form>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input class="form-control login-border login-ph"
                                        placeholder="Phone Number/Username/Email Address">
                                        <input class="form-control login-border login-ph mt-2" placeholder="Password">
                                        <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 mt-3">Log
                                        In</button>
                                    </div>  
                                    <div class="col-12 col-sm-6">
                                        <a class="text-light-blue mb-0 font-14 font-GilroyBold" href="">Forgot Password</a>
                                    </div>
                                    <div class="col-12 col-sm-6 text-sm-right">
                                        <a class="text-light-blue mb-0 font-14 font-GilroyBold" href="">Log In with Phone Number</a>
                                    </div>
                                    <div class="col-12 text-center mt-3">
                                        <p class="text-light-gray font-16 mb-0">New to Maxshop? <a
                                            class="text-orange font-GilroyBold" href="#">Sign up</a></p>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <!---------------------------------Footer start-------------------------------->

        <section class="bg-white py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <h4 class="text-black font-18 font-GilroyBold">{{trans('label.customer_services')}}</h4>
                        <ul class="list-unstyled">
                            @if($customerService && count($customerService) > 0)
                            @foreach($customerService as $service)
                            <li class="mt-2">
                                <a href="{{ route('page', ['slug' => $service->cmsPage->slug]) }}" class="text-gray font-GilroyMedium font-16 text-decoration-none">{{$service->cmsPage->title}}</a>
                            </li>
                            @endforeach
                            @endif
                            <li class="mt-2">
                                <a href="{{ route('contactUs') }}" class="text-gray font-GilroyMedium font-16 text-decoration-none">{{trans('label.contact_us')}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <h4 class="text-black font-18 font-GilroyBold">{{trans('label.about_maxshop')}}</h4>
                        <ul class="list-unstyled">
                            @if($aboutMaxshop && count($aboutMaxshop) > 0)
                            @foreach($aboutMaxshop as $maxshop)
                            <li class="mt-2">
                                <a href="{{ route('page', ['slug' => $maxshop->cmsPage->slug]) }}" class="text-gray font-GilroyMedium font-16 text-decoration-none">{{$maxshop->cmsPage->title}}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div>
                            <h4 class="text-black font-18 font-GilroyBold mb-0">{{trans('label.payment')}}</h4>
                            <img src="assets/images/Payment-options.png" class="img-fluid" alt="">
                        </div>
                        <div>
                            <h4 class="text-black font-18 font-GilroyBold mb-0">{{trans('label.logistic')}}</h4>
                            <img src="assets/images/Logistics-Logo.png" class="img-fluid" alt="">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <h4 class="text-black font-18 font-GilroyBold mb-0">{{trans('label.maxshop_app_download')}}</h4>
                        <div class="d-flex align-items-center mt-2">
                            <div>
                                <img src="assets/images/QR-Code.png" class="img-fluid max-w-100px" alt="">
                            </div>
                            <div class="ml-2">
                                <img src="assets/images/appStore.png" class="img-fluid d-block max-w-90px" alt="">
                                <img src="assets/images/googlePlay.png" class="img-fluid d-block max-w-90px mt-2 pt-1"
                                alt="">
                                <img src="assets/images/appGallery.png" class="img-fluid d-block max-w-90px mt-2 pt-1"
                                alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="bg-dark-blue py-3">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <p class="text-white mb-0 font-14 font-GilroyMedium">© {{date('Y')}} {{trans('label.maxshop')}}. {{trans('label.all_rights_reserved')}}.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!---------------------------------Footer end-------------------------------->

        <script src="{{ asset('assets/bootstrap/js/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap/js/slick.min.js') }}"></script>
        <script src="{{ asset('assets/js/custom.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/js/toastr.min.js')}}"></script>
        <script src="{{ asset('assets/js/form-controlller.js').'?v='.time() }}"></script>
        <script type="text/javascript">
            var sponsorUserExits = "{{route('sponsorUserExits')}}";
        </script>
         <script>
            @if (Session::has('success'))
            toastr.success("{{Session::get('success')}}");
            @endif
            @if (Session::has('error'))
            toastr.error("{{Session::get('error')}}");
            @endif
        </script>
        @yield('script')
    </body>
</html>