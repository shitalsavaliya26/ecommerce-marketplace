@foreach($productVouchers as $voucher)
    <div class="col-12 mt-2">
        <input type="hidden" name="voucher" id="voucher{{$voucher->id}}" value="{{$voucher->id}}">
        <div class="d-flex flex-column flex-md-row align-items-md-center border-voucher shadow-sm">
            <div class="bg-light-blue py-3 w-100 w-md-25 h-100">
                <p class="font-GilroyBold text-white text-center font-16 text-uppercase mb-0">{{substr($voucher->code, 0, 10)}}<br>{{substr($voucher->code, 10)}}</p>
            </div>
            <div class="d-flex justify-content-between align-items-center p-3 w-md-75">
                <div>
                    <p class="font-GilroyMedium text-black font-14 mb-0">{{$voucher->name}}</p>
                    <label class="btn local-seller-btn p-1 font-GilroyMedium rounded-0">{{trans('label.min_spend')}} RM{{$voucher->min_basket_price}}</label>
                    <p class="font-GilroyMedium text-gray font-12 mb-0">{{trans('label.valid_till')}}:  {{date("d.m.Y", strtotime($voucher->to_date))}}</p>                  
                </div>
                <div>
                    <input class="cursor-pointer shadow-none" type="radio" name="provoucher" value="{{$voucher->id}}" @if($voucherID == $voucher->id ) checked @endif>
                </div>
            </div>
        </div>
    </div>
@endforeach