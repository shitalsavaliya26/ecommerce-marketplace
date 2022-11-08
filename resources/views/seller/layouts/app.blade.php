<!doctype html>
    <html lang="en">

    <head>
        <title>{{ config('app.name', 'Maxshop Seller') }}</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{  asset('assets/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{  asset('assets/bootstrap/css/slick.min.css') }}">

        <style>
            a:hover {
                text-decoration: none;
            }

            .error {
                color: red;
            }
        </style>
        <link rel="stylesheet" href="{{  asset('assets/css/style.css').'?v='.time() }}">
        <link rel="stylesheet" href="{{  asset('assets/css/seller.css').'?v='.time() }}">
    </head>

    <body>

    

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

    <section class="bg-dark-blue py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="text-white mb-0 font-14 font-GilroyMedium">© {{date('Y')}} Maxshop. All Rights Reserved.
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

    </script>
    @yield('script')

</body>

</html>