@extends('layouts.main')
@section('title', 'Contact Us')
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row" style="display: flex;justify-content: center;">
            <div class="col-9" >
                <div class="row bg-white mx-0 br-15 py-5 shadow overflow-hidden" style="display: flex;justify-content: center;">
                    <div class="col-12 col-lg-8 mt-4 mt-lg-0">
                        <h1 class="text-black font-20 font-GilroySemiBold mb-0">{{trans('label.contact_us')}}</h1>

                        <form method="post" action="{{route('contactUs.send')}}" id="contact-us">
                            {{ csrf_field() }}
                            <div class="row align-items-center">
                                <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular"> {{trans('label.name')}}</label>
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control h-auto py-2">
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular"> {{trans('label.hp')}}</label>
                                <div class="col-md-6">
                                    <input type="text" name="hp" id="hp"class="form-control h-auto py-2">
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.email')}} </label>
                                <div class="col-md-6">
                                    <input type="email" name="email" class="form-control h-auto py-2">
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular"> {{trans('label.state')}}</label>
                                <div class="col-md-6">
                                    <select name="state" id="state" class="form-control h-auto py-2">
                                        @foreach($states as $state)
                                            <option>{{$state->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <label class="col-md-3 col-lg-4 col-xl-3 col-form-label text-gray font-16 font-GilroyRegular">{{trans('label.message')}} </label>
                                <div class="col-md-6">
                                    <textarea class="form-control h-auto py-2" name="message" id="message"></textarea>
                                </div>
                            </div>
                            <div class="row align-items-center mt-3">
                                <div class="col-md-6 offset-md-3">
                                    <button class="btn bg-orange btn-orange font-GilroySemiBold text-white font-12 px-4">{{trans('label.send_message')}}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $.validator.addMethod("regx", function(value, element, regexpr) {          
                return regexpr.test(value);
            }, "Please enter a valid hp.");

            $( "#contact-us" ).validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 200
                    },
                    hp: {
                        required: true,
                        regx: /^\+[1-9]{1}[0-9]{3,14}$/,
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    state: {
                        required: true,
                    },
                    message: {
                        required: true,
                    },
                }, messages: {
                    "name" :{
                        required: "Enter your name, please.",
                        maxlength: "Max length is 200."
                    },
                    "hp" :{
                        required: "Enter hp, please.",
                        regx: "Enter valid hp, please.",
                    },
                    "email" :{
                        required: "Enter your email, please.",
                        email: "Please enter valid email."
                    },
                    "message" :{
                        required: "Enter message, please.",
                    }
                }
            });
        });
    </script>
@endsection
