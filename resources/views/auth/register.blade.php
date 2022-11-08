    @extends('layouts.app')

@section('content')
<section class="bg-gray py-5">
    <div class="container">
        <div class="row justify-content-center bg-white br-15 m-0 overflow-hidden shadow">
@if($errors->any())
    {!! implode('', $errors->all('<div>:message</div>')) !!}
@endif
            <div class="col-12 col-md-7">
                <form route="{{ route('register') }}" method="post" id="register">
                    {{ csrf_field() }}
                    <div class="row py-5 px-sm-4">
                        <div class="col-12">
                            <h2 class="text-black mb-0 pb-3 font-GilroyMedium">{{trans('label.sign_up')}}</h2>
                        </div>
                        <div class="col-12 my-2">
                            <h4 class="text-black font-GilroyBold font-16">{{trans('label.verify_sponsor')}}</h4>
                        </div>
                        <div class="col-12">
                            <div class="d-block align-items-center">
                                <div class="row mx-0">
                                    <!-- <select name="sponsor_country_code" id="sponsor_country_code"
                                        class="col-1 px-0 form-control login-border text-light-gray">
                                        <option value="+60" @if(old('country_code')=='+60' ) selected @endif>+60
                                        </option>
                                        <option value="+65" @if(old('country_code')=='+65' ) selected @endif>+65
                                        </option>
                                    </select> -->
                                    <input class="col-8 pr-0 form-control login-border login-ph"
                                        placeholder="{{trans('label.agent_referral')}}" name="sponsor" id="sponsor" minlength="6" maxlength="11"
                                        value="{{ old('sponsor') }}" required autofocus>
                                    <a type="button"
                                        class="btn bg-orange col-2 orange-btn text-white font-14 rounded-1 verify-sponser ml-3 font-GilroySemiBold">{{trans('label.verify')}}</a>
                                </div>
                            </div>
                            <input type="hidden" name="sponsor_check" id="sponsor_check">
                            <label class="cus-error-sponsor error text-danger" style="display:none;">{{trans('label.sponsor_not_found')}}</label>
                            <label class="cus-success-sponsor sucess text-success" style="display:none;">{{trans('label.sponsor_verified')}}</label>
                            <label id="sponsor-error" class="error mt-2 text-danger" for="sponsor">
                                @if ($errors->has('sponsor'))
                                {{ $errors->first('sponsor') }}
                                @endif
                            </label>
                        </div>
                        <div class="col-12 mt-2">
                            <hr />
                        </div>
                        <div class="col-12">
                            <h4 class="text-black font-GilroyBold font-16">{{trans('label.personal_details')}}</h4>
                        </div>
                        <div class="col-12 col-md-6 mt-2">
                            <input type="text" name="name" class="form-control login-border login-ph" placeholder="{{trans('label.name')}}"
                                minlength="3" maxlength="40" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('name') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-12 col-md-6 mt-3 mt-md-2">
                            <div class="row mx-0">
                                <select name="country_code"
                                    class="col-3 px-0 form-control login-border text-light-gray">
                                    <option value="+60" @if(old('country_code')=='+60' ) selected @endif>+60</option>
                                    <option value="+65" @if(old('country_code')=='+65' ) selected @endif>+65</option>
                                </select>
                                <input class="col-9 pr-0 form-control login-border login-ph" placeholder="{{trans('label.phone_number')}}"
                                    minlength="9" maxlength="11" name="phone" value="{{ old('phone') }}" required autofocus>
                                @if ($errors->has('phone'))
                                <span class="help-block error text-danger">
                                    {{ $errors->first('phone') }}
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <input type="email" name="email" class="form-control login-border login-ph"
                                placeholder="{{trans('label.email_address')}}" minlength="6" maxlength="40">
                            @if ($errors->has('email'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('email') }}
                            </span>
                            @endif
                        </div>
                        <div class="col-6 mt-3">
                            <select class="form-control login-border text-light-gray" id="state" name="state" required>
                                <option value="">{{trans('label.select_state')}} </option>
                                @foreach($states as $state)
                                <option value="{{$state->name}}" @if(old('state')==$state->name) selected
                                    @endif>{{$state->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 mt-3">
                            <div class="d-flex flex-column flex-sm-row flex-wrap">
                                <div class="custom-control mt-2">
                                    <input type="radio" class="custom-control-input" id="male" name="gender" value="male" checked="checked">
                                    <label class="custom-control-label"
                                        for="male">{{trans('label.male')}}</label>
                                </div>
                                <div class="custom-control mt-2 ml-sm-4 ml-lg-3 ml-xl-4">
                                    <input type="radio" class="custom-control-input" id="female" name="gender" value="female">
                                    <label class="custom-control-label "
                                        for="female">{{trans('label.female')}}</label>
                                </div>
                                <div class="custom-control mt-2 ml-sm-4 ml-lg-3 ml-xl-4">
                                    <input type="radio" class="custom-control-input" id="other" name="gender" value="other">
                                    <label class="custom-control-label "
                                        for="other">{{trans('label.other')}}</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mt-3">
                            <input type="password" name="password" class="form-control login-border login-ph mt-2" placeholder="{{trans('label.password')}}" required minlength="6" maxlength="30">
                            @if ($errors->has('password'))
                            <span class="help-block error text-danger">
                                {{ $errors->first('password') }}
                            </span>
                            @endif
                        </div>
                      <!--   <div class="col-6 mt-3">
                            <select class="form-control login-border text-light-gray" id="race" name="race" required>
                                <option value="">{{trans('label.select_race')}} </option>
                                <option value="malay">Malay</option>
                                <option value="chinese">Chinese</option>
                                <option value="indian">Indian</option>
                                <option value="other">Other</option>
                            </select>
                        </div> -->
                        <div class="col-12 mt-3">
                            <button type="submit"
                                class="btn bg-orange orange-btn text-white font-14 rounded-1 px-5 font-GilroySemiBold">{{trans('label.sign_up')}} </button>
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