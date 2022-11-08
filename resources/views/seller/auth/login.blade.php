@extends('seller.layouts.app')

@section('content')
<section class="bg-login d-flex align-items-center justify-content-center py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                <div class="bg-white br-15 py-4 px-3 px-sm-5 shadow">
                    <img src="{{ asset('assets/images/Logo.png') }}" class="img-fluid max-w-150px mx-auto d-block"
                        alt="">
                    <h2 class="text-black mb-0 py-3 font-GilroyMedium">Log In</h2>
                    <form id="signin" action="{{ route('seller.login') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-12 mb-3">
                                <input class="form-control login-border login-ph" placeholder="Email Address"
                                    name="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
                                <span class="help-block error text-danger">
                                    {{ $errors->first('email') }}
                                </span>
                                @endif
                                <input type="password" name="password" class="form-control login-border login-ph mt-2"
                                    placeholder="Password" required>
                                @if ($errors->has('password'))
                                <span class="help-block error text-danger">
                                    {{ $errors->first('password') }}
                                </span>
                                @endif
                                <div class="row col-sm-12">
                                    <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 mt-3 font-GilroySemiBold">Seller Log In</button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <a class="text-light-blue mb-0 font-14 font-GilroyBold"
                                    href="{{ route('seller.password.request') }}">Forgot Password</a>
                            </div>
                            <div class="col-12 col-sm-6 text-sm-right">
                                <a class="text-light-blue mb-0 font-14 font-GilroyBold"
                                    href="{{ route('seller.login.phone') }}">Log In with Phone Number</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection