@extends('layouts.app')

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
                <h2 class="text-black mb-0 py-3 font-GilroyMedium">{{trans('label.reset_password')}}</h2>
                <form  id="resetpassword" action="{{ route('password.request') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="row">
                        <div class="col-12 mb-3">
                            <input class="form-control login-border login-ph"
                            placeholder="{{trans('label.email_address')}}" name="email" value="{{ $email or old('email') }}" readonly required autofocus>
                            @if ($errors->has('email'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                            <input name="password" id="password" class="form-control login-border login-ph mt-2" placeholder="{{trans('label.password')}}" required>
                            @if ($errors->has('password'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                            <input name="password_confirmation" class="form-control login-border login-ph mt-2" placeholder="{{trans('label.confirm_password')}}"  required>
                            @if ($errors->has('password_confirmation'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('password_confirmation') }}
                            </span>
                            @endif
                            <div class="row col-sm-12">
                                <button class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 mt-3 font-GilroySemiBold"> {{trans('label.reset_password')}}</button>
                            </div>
                        </div>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection


