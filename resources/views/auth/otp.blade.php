@extends('layouts.app')

@section('content')
<section class="bg-gray py-5">
    <div class="container">
        <div class="row justify-content-center bg-white br-15 m-0 overflow-hidden shadow">
            <div class="col-12 col-md-7">
                <form action="{{ route('confirmOtp') }}" method="post" id="confirmOtp">
                    <input type="hidden" name="userId" value="{{$id}}">
                    {{ csrf_field() }}
                    <div class="row py-5 px-sm-4">
                        <div class="col-12">
                            <h2 class="text-black mb-0 pb-3 font-GilroyMedium">{{trans('label.sign_up')}}</h2>
                        </div>
                        <div class="col-12 my-2">
                            <h4 class="text-black font-GilroyBold font-16">{{trans('label.verify_otp')}}</h4>
                        </div>
                        <div class="col-12">
                            <div class="d-block align-items-center">
                                <div class="row mx-0">
                                    <input class="col-7 pr-0 form-control login-border login-ph"
                                        placeholder="{{trans('label.otp')}}" name="otp" id="otp"
                                        value="{{ old('otp') }}" required autofocus>
                                    <button type="submit" class="btn bg-orange col-2 orange-btn text-white font-14 rounded-1 ml-3 font-GilroySemiBold">
                                        {{trans('label.verify')}}
                                    </button>
                                </div>
                            </div>
                            <label id="otp-error" class="error mt-2 text-danger" for="otp">
                                @if ($errors->has('otp'))
                                    {{ $errors->first('otp') }}
                                @endif
                            </label>
                        </div>
                        <div class="col-12 mt-2">
                            <hr />
                        </div>

                        <div class="col-12 mt-3">
                            <p class="text-light-gray font-14 mb-0">{{trans('label.by_signing_up_you_agree_to_maxshop’s')}}
                                <a class="text-orange font-GilroyBold" target="_blank" href="{{route('page', ['slug' => 'terms-of-service'])}}">{{trans('label.terms_of_service')}}</a> &
                                <a class="text-orange font-GilroyBold" target="_blank" href="{{route('page', ['slug' => 'privacy-policy'])}}">{{trans('label.privacy_policy')}}</a>
                            </p>
                            <p class="text-light-gray font-16 mb-0">{{trans('label.have_an_account')}}
                                <a class="text-orange font-GilroyBold" href="{{ route('login') }}">{{trans('label.log_in')}}</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-12 col-md-5 bg-signup">
            </div>
        </div>
    </div>
</section>
@endsection
