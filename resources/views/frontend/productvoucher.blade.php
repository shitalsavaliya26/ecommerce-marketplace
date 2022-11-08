@if($productVouchers && count($productVouchers) > 0)
    <div class="text-center mt-3">
        <div class="col-12 text-left pt-2">
            <a href="javascript:void(0)" class="btn-coupon text-light-blue ml-2 font-GilroyMedium font-14 toggle" style="color: #007bff">{{trans('label.select_code')}}</a>
            <br>
            <div class="coupon-list" >
                <div class ="row">
                    @foreach($productVouchers as $voucher)
                    <div class="col-xl-12 mt-4">
                        <div class="row align-items-center h-100 mx-0">
                            <div
                            class="col-3 col-xl-4 bg-orange p-3 h-100 d-flex align-items-center justify-content-center vouncher-galore1">
                            <p class="font-GilroyBold text-white text-center font-16 text-uppercase mb-0 text-break">{{substr($voucher->code, 0, 10)}}<br>{{substr($voucher->code, 10)}}</p>
                        </div>
                        <div class="col-9 col-xl-8 border-vouncher-galore vouncher-galore2">
                            <div class="p-3 vouncher-galore3">
                                <p class="font-GilroyBold text-black font-14 mb-0">{{$voucher->name}}</p>
                                <p class="font-GilroyMedium text-gray font-8 mb-0">{{trans('label.valid_till')}} {{date("d M", strtotime($voucher->to_date))}}</p>
                                <p class="font-GilroyBold text-black font-14 mb-0">{{trans('label.min_spend')}} RM{{$voucher->min_basket_price}}</p>
                                <div class="d-flex justify-content-between align-items-end">
                                    <a href="javascript:void(0)" data-id="{{$voucher->id}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 py-1 font-GilroyMedium mt-2 redeem redeem-button">{{trans('label.redeem')}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endif