@extends('layouts.main')
@section('title', 'Wallet')
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
                                <p class="font-16 text-gray font-GilroyMedium mb-0">{{trans('label.notification')}}</p>
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
                        <div class="nav nav-tabs border-0 flex-column flex-md-row flex-lg-column flex-xl-row"
                        id="nav-tab" role="tablist">
                        <a class="nav-item font-GilroySemiBold nav-link active" id="profile-tab"
                        data-toggle="tab" href="#wallet" role="tab" aria-controls="profile"
                        aria-selected="true">{{trans('label.notification')}}</a>

                    </div>
                </nav>
            </div>
        </div>

        <div class="row mx-0 mt-4">
            <div class="col-12 mt-2 table-responsive">
                <div class="row align-items-center bg-gray-light br-15 pb-3 shadow overflow-hidden mx-0">
                    <div class="col-12 bg-white py-3">
                        <h4 class="text-black font-GilroyBold font-20 pl-md-3">{{trans('label.all_notifications')}}</h4>
                    </div>
                    @foreach($notifications as $notification)
                        @foreach($notification as $order)
                            @if($order['type'] == 'OrderDelivered')
                                <div class="col-12 bg-white pb-3">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-9">
                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-3">
                                                    <div class="overflow-hidden br-15 text-center w-100px min-h-100px mx-auto">
                                                        <img src="{{ Helper::getSellerImage($order['orderId']) }}" class="img-fluid" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <p class="font-GilroySemiBold font-18 mb-1 text-black">Parcel Delivered</p>
                                                    <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">
                                                        Parcel for your order {{$order['orderId']}} has been delivered</p>
                                                    <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">{{date('d-m-Y h:i', strtotime($order['created_at']))}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-3 text-right">
                                            <a href="{{ route('user.orders.view',$order['orderId']) }}" target="_blank" class="btn bg-orange orange-btn text-white font-12 rounded px-3 font-GilroySemiBold">
                                                View Order Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($order['type'] == 'OrderShipped')
                                <div class="col-md-9 offset-md-1">
                                    <ul class="notification-timeline">
                                        <li class="notification-timeline-item mt-4 mb-5">
                                            <p class="font-GilroySemiBold font-18 mb-1 text-medium-gray">Shipped Out</p>
                                            <p class="font-GilroyRegular font-14 mb-0 text-medium-gray">
                                                Parcel for your order {{$order['orderId']}} has been shipped out. <br>
                                                <a href="{{ route('user.orders.view',$order['orderId']) }}" target="_blank" > Click here to see order details and track your parcel.</a>
                                            </p>
                                            <p class="font-GilroyRegular font-14 text-medium-gray">{{date('d-m-Y h:i', strtotime($order['created_at']))}}</p>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                        <div class="col-12 py-3 bg-white">
                            <hr />
                        </div>
                    @endforeach
                    <div class="col-12">
                        {{ $notifications->render('vendor.default_paginate') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('#nav-tab a[href="#{{ old('tab') }}"]').tab('show')
        $("#add-attribute-div").hide();
        $("#dynamic_option").hide();
        $("#set-variation-div").hide();
    });
    var id;

    $('.editAdddress').click(function() {
        id = $(this).data("id");
    });

    // on modal show
    $('#editModalAddressForm').on('show.bs.modal', function(e) {
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
                    $(this).find('#name').val(response.name);
                    $(this).find('#country_code').val(response.country_code);
                    $(this).find('#mobile').val(response.contact_number);
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
        $(this).find('form').trigger('reset');
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
        $("#addamount").validate({
            rules: {
                amount: {
                    required: true,
                    number:true
                }
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