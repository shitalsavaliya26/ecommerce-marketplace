@extends('seller.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7 col-xl-6">
            @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <div class="bg-white br-15 py-4 px-3 px-sm-5 shadow">
                <img src="{{ asset('assets/images/Logo.png') }}" class="img-fluid max-w-150px mx-auto d-block" alt="">
                <h2 class="text-black mb-0 py-3 font-GilroyMedium">Reset Password</h2>
                <form  id="forgotpassword" action="{{ route('seller.password.email') }}" method="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-12 mb-3">
                            <input class="form-control login-border login-ph"
                            placeholder="Email Address" name="email" value="{{ old('email') }}" required autofocus>
                            @if ($errors->has('email'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                            <div class="row col-sm-12">
                                <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 mt-3 font-GilroySemiBold"> Send Password Reset Link</button>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
