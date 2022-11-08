@extends('layouts.main')
@section('title', 'Orders')
@section('css')
<style type="text/css">

    @media screen and (min-width: 1200px){

        .profile-tabs-w-25 .nav-tabs .nav-link {
           width: auto !important; 
           text-align: center;
       }
   }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
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
                                <p class="font-16 text-gray font-GilroyMedium mb-0">{{trans('label.edit_profile')}}</p>
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
                            <a class="nav-item font-GilroySemiBold nav-link active" id="all-tab" data-toggle="tab"
                            href="#all" role="tab" aria-controls="all" aria-selected="true">{{trans('label.all')}}</a>

                            <a class="nav-item font-GilroySemiBold nav-link" id="topay-tab" data-toggle="tab"
                            href="#topay" role="tab" aria-controls="topay" aria-selected="false">{{trans('label.to_pay')}}</a>

                            <a class="nav-item font-GilroySemiBold nav-link" id="toship-tab" data-toggle="tab" 
                            href="#toship" role="tab" aria-controls="toship" aria-selected="false">{{trans('label.to_ship')}}</a>

                            <a class="nav-item font-GilroySemiBold nav-link" id="toreceived-tab" data-toggle="tab"
                            href="#toreceived" role="tab" aria-controls="toreceived" aria-selected="false">{{trans('label.to_received')}}</a>

                            <a class="nav-item font-GilroySemiBold nav-link" id="completed-tab" data-toggle="tab"
                            href="#completed" role="tab" aria-controls="completed" aria-selected="false">{{trans('label.Completed')}}</a>

                            <a class="nav-item font-GilroySemiBold nav-link" id="cancelled-tab" data-toggle="tab" 
                            href="#cancelled" role="tab" aria-controls="cancelled" aria-selected="false">{{trans('label.cancelled')}}</a>

                            <a class="nav-item font-GilroySemiBold nav-link" id="rejected-tab" data-toggle="tab" 
                            href="#rejected" role="tab" aria-controls="rejected" aria-selected="false">{{trans('label.rejected')}}</a>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row mx-0 mt-4">
                <div class="col-12 datas">
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel"
                        aria-labelledby="all-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="allorder">
                            @include('profile.orders.all')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="toship" role="tabpanel" aria-labelledby="toship-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="shiporder">
                            @include('profile.orders.toship')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="topay" role="tabpanel" aria-labelledby="topay-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="payorder">
                            @include('profile.orders.topay')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="toreceived" role="tabpanel" aria-labelledby="toreceived-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="receivedorder">
                            @include('profile.orders.toreceived')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="completedorder">
                            @include('profile.orders.completed')
                        </div>
                    </div>
                    <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="cancelledorder">
                            @include('profile.orders.cancelled')                            
                        </div>
                    </div>
                    <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                        <div class="row br-15 bg-white pt-4 pb-5 shadow overflow-hidden" id="rejectedorder">
                            @include('profile.orders.rejected')                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>

<div class="modal fade" id="modalAddressForm" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.add_new_address')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="address-form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.full_name')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control" type="text" placeholder="{{trans('label.enter_full_name')}}"
                                        name="name" id="name" title="{{trans('label.please_enter_full_name')}}" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.phone_number')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element row">
                                        <div class="col-lg-3">
                                            <select name="country_code" class="form-control country_code" id="country_code">
                                                <option value="+60"> &nbsp;+60 &nbsp;</option>
                                                <option value="+65"> &nbsp;+65 &nbsp;</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-9">
                                            <input class="phonenumber form-control" placeholder="{{trans('label.enter_phone_number')}}"
                                            id="mobile" type="tel" class="" name="phone" minlength="9"
                                            maxlength="10" title="{{trans('label.please_enter_valid_mobile_number')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.address_line_1')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_1')}}"
                                        name="address_line1" id="address_line1" required
                                        title="{{trans('label.please_enter_address_line')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.address_line_2')}}:
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_2')}}"
                                        name="address_line2" id="address_line2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.postcode')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control" type="tel" placeholder="{{trans('label.enter_postcode')}}"
                                        name="postal_code" id="postal_code" title="{{trans('label.please_enter_postcode')}}"
                                        minlength="5" maxlength="5">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.city')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control" type="text" placeholder="{{trans('label.enter_city')}}" id="town"
                                        name="town" title="{{trans('label.please_enter_city')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.state')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <select class=" m-select form-control" name="state" id="state" title="{{trans('label.please_select_any_one_state')}}">
                                            <option value="" label="{{trans('label.select_a_state_region')}}" class="ng-binding">{{trans('label.select_a_state_region')}}</option>
                                            <option value="Kuala Lumpur" label="Kuala Lumpur">Kuala Lumpur</option>
                                            <option value="Labuan" label="Labuan">Labuan</option>
                                            <option value="Putrajaya" label="Putrajaya">Putrajaya</option>
                                            <option value="Johor" label="Johor">Johor</option>
                                            <option value="Kedah" label="Kedah">Kedah</option>
                                            <option value="Kelantan" label="Kelantan">Kelantan</option>
                                            <option value="Melaka" label="Melaka">Melaka</option>
                                            <option value="Negeri Sembilan" label="Negeri Sembilan">Negeri Sembilan</option>
                                            <option value="Pahang" label="Pahang">Pahang</option>
                                            <option value="Perak" label="Perak">Perak</option>
                                            <option value="Perlis" label="Perlis">Perlis</option>
                                            <option value="Pulau Pinang" label="Pulau Pinang">Pulau Pinang</option>
                                            <option value="Sabah" label="Sabah">Sabah</option>
                                            <option value="Sarawak" label="Sarawak">Sarawak</option>
                                            <option value="Selangor" label="Selangor">Selangor</option>
                                            <option value="Terengganu" label="Terengganu">Terengganu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.country')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control" placeholder="{{trans('label.country')}}" type="text" class=""
                                        name="country" value="Malaysia" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
                            id="address-button">{{trans('label.save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var deleteurl      = "{{ route('removecartproduct') }}";
    var movetowishlist = "{{ route('movetowishlist') }}";
    var updatecarturl  = "{{ route('updatecart') }}";
</script>
<script src="{{ asset('assets/js/cart.js').'?v='.time() }}"></script>
<script>
   $('.accordion-toggle').click(function() {
    $(this).find('.select-arrow').toggleClass('d-none');
});
   $(".nav-link").click(function (e) {
    e.preventDefault();
    $('.nav-link').removeClass('active');
    $(this).addClass('active')
    var tab = $(this).attr('href');
    $('.tab-pane').removeClass('show');
    $('.tab-pane').removeClass('active');
    $(tab).addClass('show');
    $(tab).addClass('active');
});
   $(document).on('click', '.pagination a',function(event)
   {
    event.preventDefault();
    var container = $(this).parent().parent().parent().parent('.table-responsive');
    console.log(container);
    $('.datas').append('<div class="cus-spinner-full"><div class="sk-spinner sk-spinner-three-bounce"><div class="sk-bounce1"></div><div class="sk-bounce2"></div><div class="sk-bounce3"></div></div></div>');
    $(this).parent('li').removeClass('active');
    $(this).parent('li').addClass('active');
    var myurl = $(this).attr('href');
    var page=$(this).attr('href').split('page=')[1];
    getData(page,container);
});

   function getData(page,container = null){
    var htype = container.attr('id');
    $.ajax({
        url: '?page=' + page,
        type: "get",
        datatype: "html",
        data:{
            htype: htype,
        },
    }).done(function(data){
        $("#"+htype+"order").empty().html(data);
        location.hash = page;
    }).fail(function(jqXHR, ajaxOptions, thrownError){
        alert('No response from server');   
        $('.cus-spinner-full').hide(200);
    });
}

$(document).on('click','#all-tab',function(e) {
    document.title = "MaxShop | Orders";
})

$(document).on('click','#topay-tab',function(e) {
    document.title = "MaxShop | To Pay";
})
$(document).on('click','#toship-tab',function(e) {
    document.title = "MaxShop | To Ship";
})
$(document).on('click','#toreceived-tab',function(e) {
    document.title = "MaxShop | To Received";
})
$(document).on('click','#completed-tab',function(e) {
    document.title = "MaxShop | Completed";
})
$(document).on('click','#cancelled-tab',function(e) {
    document.title = "MaxShop | Cancelled";
})
$(document).on('click','#rejected-tab',function(e) {
    document.title = "MaxShop | Rejected";
});

$(document).on('click','.reviewRating',function(e) {
    var productId = $(this).attr('data-productId');
    var orderId = $(this).attr('data-orderProductId');
    var completedParam = $(this).attr('data-param');

    $.ajax({
        type: 'PUT',
        url: "{{ route('getproduct') }}",
        data: {
            'productId': productId,
        }
    }).done(function(data){ 
        $('#product_image').attr('src', data.product.image);
        $('#product_name').text(data.product.name);
        $('#product_id').val(productId);
        $('#order_id').val(orderId);
        if(completedParam == 'completed'){
            $('#completedReviewRatingModal').modal('show');
        }else{
            $('#reviewRatingModal').modal('show');
        }
    });
});

$(document).on('click','#submitReview',function(e) {
    $( "#submitReview" ).prop( "disabled", true );
    var orderId = $('#order_id').val();
    var productId =$('#product_id').val();
    var form_data = new FormData($('#reviewForm')[0]);
    $.ajax({
        type: 'POST',
        url: "{{route('submitReview')}}",
        data: form_data,
        processData: false,
        contentType: false,
        success: function(response) {
            if(response.success == true){
                var tdId = 'product_'+productId+'_'+orderId;
                var tdCompletedId = 'completed_'+productId+'_'+orderId;
                $("#reviewForm")[0].reset();
                $('#completedReviewRatingModal').modal('hide');
                $('#reviewRatingModal').modal('hide');
                $("#"+tdId).load(location.href+" #"+tdId+">*",""); 
                $("#"+tdCompletedId).load(location.href+" #"+tdCompletedId+">*",""); 
            }
        }
    });
});

</script>
@endsection