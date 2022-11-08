@extends('layouts.main')
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12">

                <div id="productsection">
                    <?php $shipping_fees = 0; ?>
                    @foreach($result as $item)
                    <div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
                        <div class="col-12 table-responsive">
                            <table class="table voucher-table">
                                <thead>
                                    <tr>
                                        <th width="50%" class="font-16 text-black font-GilroySemiBold">Products Ordered</th>
                                        <th width="15%"></th>
                                        <th width="15%" class="font-14 text-gray font-GilroyMedium text-center text-nowrap">
                                            Unit Price
                                        </th>
                                        <th width="10%" class="font-14 text-gray font-GilroyMedium text-center text-nowrap">
                                        Amount</th>
                                        <th width="10%" class="font-14 text-gray font-GilroyMedium text-right text-nowrap">
                                            Item Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5">
                                            <div class="d-flex align-items-center">
                                                <img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{ $item['image'] }}" class="img-fluid max-w-35px mr-2"
                                                alt="">
                                                <span>{{$item['seller_name']}}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($item['products'] as $product)
                                            <?php //$product = $productitem->productdetails;
                                            $productitem = $product;  ?>
                                            <tr>
                                                <td class="font-14 align-middle">
                                                    <div class="d-flex align-items-center">
                                                        <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $product->images[0]->thumb }}" class="img-fluid max-w-70px mr-3 prd-image"
                                                        alt="">
                                                        <span>{{$product->name}}</span>
                                                    </div>
                                                </td>
                                                @if($productitem->variation_id != 0)
                                                <?php $variation = implode(', ', $productitem->variation->variation); ?> 
                                                <td class="text-gray font-14 align-middle">Variation: {{$variation}}</td>
                                                @else
                                                <td class="text-gray font-14 align-middle"></td>
                                                @endif
                                                <td class="font-14 text-center align-middle">RM{{number_format(($productitem->variation_id != 0) ? $productitem->variation->sell_price : $product->sell_price,2)}}</td>
                                                <td class="font-14 text-center align-middle">
                                                <div class="d-flex align-items-center mt-4 mt-md-0">
                                                    <div
                                                    class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer minus" data-id="{{ Helper::encrypt($productitem->id) }}">
                                                    <span class="text-gray fw-600 font-16 ">-</span>
                                                </div>
                                                <div class="text-gray font-16 mx-4 increment" id="{{ Helper::encrypt($productitem->id) }}">
                                                    <input type="hidden" name="product_id" class="product_id" value="{{ Helper::encrypt($productitem->id) }}">
                                                    <input type="hidden" name="qty" class="qty" value="{{$productitem->updated_qty}}">
                                                    <span>{{$productitem->updated_qty}}</span>
                                                </div>

                                                <div
                                                class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer plus" data-id="{{ Helper::encrypt($productitem->id) }}">
                                                <span class="text-gray fw-600 font-16">+</span>
                                            </div>
                                        </div></td>
                                        <td class="text-right font-14 align-middle">RM{{number_format(($productitem->variation_id != 0) ? $productitem->variation->sell_price * $productitem->updated_qty : $product->sell_price * $productitem->updated_qty,2)}}</td>
                                    </tr>
                                    @endforeach

                                    <tr class="border-top border-bottom border-secondary">
                                        <td class="font-14 align-middle text-right font-GilroyMedium" colspan="2">Shop
                                        Voucher</td>
                                        <td class="text-right font-16 align-middle" colspan="3">
                                            <span class="cursor-pointer text-light-blue font-GilroySemiBold"
                                            data-toggle="modal" data-target="#modalVoucher">Select Voucher</span>
                                        </td>
                                    </tr>

                                    <tr class="border-bottom border-secondary">
                                        <td class="border-right border-secondary">
                                            <div class="row align-items-center">
                                                <div class="col-auto pr-0">
                                                    <span class="text-black font-14 font-GilroyMedium">Message:</span>
                                                </div>
                                                <div class="col-8 col-sm-9">
                                                    <div class="form-group mb-0">
                                                        <div class="from-inner-space">
                                                            <input class="form-control" type="text"
                                                            placeholder="(Optional) Leave a message to seller">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="font-14 text-slate-green align-middle font-GilroyMedium">Shipping Option:
                                        </td>
                                        <td class="font-14 align-middle">
                                            <input type="hidden" name="shipping_company[]" value="{{($item['shipping_companies']->count() > 0) ? $item['shipping_company']->id : ''}}">
                                            <div class="font-GilroySemiBold text-black">{{($item['shipping_companies']->count() > 0) ? $item['shipping_company']->name : 'No shipping available'}}</div>
                                            <!-- <div class="text-gray font-10 font-GilroyMedium">Receive by 29 Jul - 3 Aug</div> -->
                                        </td>
                                        <td class="text-right font-14 align-middle">
                                            @if($item['shipping_companies']->count() > 0)
                                            <div class="modal fade" id="modalShippingOption{{$item['seller_id']}}" tabindex="-1" role="dialog" aria-labelledby="shippingOption"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header px-4">
                                                        <h4 class="modal-title inline" id="exampleModalLabel">Select Shipping Option</h4>
                                                    </div>
                                                    <div class="modal-body px-4 min-h-300px">
                                                        <div class="row">
                                                            <div class="col-12" id="frm{{$item['seller_id']}}">
                                                                <?php $i = 0; ?>

                                                                @foreach($item['shipping_companies'] as $shipping_company)
                                                                <div class="voucher-radio mt-2">
                                                                    <input class="form-check-input d-none" type="radio" name="shipping{{$item['seller_id']}}" id="test{{$i}}" value="{{App\Helpers\Helper::encrypt($shipping_company->id)}}" data-seller="{{App\Helpers\Helper::encrypt($item['seller_id'])}}" @if($item['shipping_company']->id == $shipping_company->id) checked @endif> 
                                                                    <label class="py-3 border-left-orange cursor-pointer d-flex justify-content-between align-items-center" for="test{{$i}}">
                                                                        <div class="pl-4">
                                                                            <div class="font-GilroySemiBold font-16 text-black">{{$shipping_company->name}} <span class="ml-4 text-orange font-GilroyMedium">RM{{$shipping_company->price}}</span></div>
                                                                            <!-- <div class="text-gray font-12 font-GilroyMedium">Receive by 29 Jul - 3 Aug</div> -->
                                                                        </div>
                                                                        <div class="pr-4">
                                                                            <img src="assets/images/red-mark.png" class="img-fluid max-w-20px d-none" alt="">
                                                                        </div>
                                                                    </label>
                                                                </div>
                                                                <?php $i++; ?>

                                                                @endforeach
                                                                            <!-- <div class="voucher-radio mt-2">
                                                                                <input class="form-check-input d-none" type="radio" name="inlineRadioOptions"
                                                                                id="inlineRadio2" value="option2">
                                                                                <label
                                                                                class="py-3 border-left-orange cursor-pointer d-flex justify-content-between align-items-center"
                                                                                for="inlineRadio2">
                                                                                <div class="pl-4">
                                                                                    <div class="font-GilroySemiBold font-16 text-black">Standard Delivery <span
                                                                                        class="ml-4 text-orange font-GilroyMedium">RM4.90</span></div>
                                                                                        <div class="text-gray font-12 font-GilroyMedium">Receive by 29 Jul - 3 Aug</div>
                                                                                    </div>
                                                                                    <div class="pr-4">
                                                                                        <img src="assets/images/red-mark.png" class="img-fluid max-w-20px d-none" alt="">
                                                                                    </div>
                                                                                </label>
                                                                            </div> -->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <button type="button" class="btn btn-danger px-3 mr-2" data-dismiss="modal">Cancel</button>
                                                                            <button type="button" class="btn btn-success px-3 changeshipping" id="{{$item['seller_id']}}">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span
                                                    class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold"
                                                    data-toggle="modal" data-target="#modalShippingOption{{$item['seller_id']}}">CHANGE</span>
                                                    @endif
                                                </td>
                                                <?php 
                                                $seller_shipping = ($item['shipping_companies']->count() > 0) ? $item['shipping_companies'][0]->price : 0;
                                                $shipping_fees += $seller_shipping; ?>
                                                <td class="text-right font-14 align-middle">RM{{($item['shipping_companies']->count() > 0) ? $item['shipping_companies'][0]->price : ''}}</td>
                                            </tr>

                                            <tr>
                                                <td class="font-14 align-middle text-right font-GilroyMedium" colspan="5">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <p class="text-gray font-14 font-GilroyMedium mb-0">Order Total ({{$item['totalitems']}} Item):
                                                        </p>
                                                        <span class="text-orange font-22 font-GilroyBold ml-3">RM{{number_format($item['seller_total'] + $seller_shipping,2)}}</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endforeach

                            <!-- <div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
                                <div class="col-12 col-sm-6">
                                    <h4 class="text-black font-GilroyBold font-18 mb-sm-0">Shopee Voucher</h4>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span class="cursor-pointer text-light-blue font-GilroySemiBold" data-toggle="modal"
                                    data-target="#modalVoucher">Select Voucher</span>
                                </div>

                                <div class="col-12 my-2">
                                    <hr>
                                </div>

                                <div class="col-12 col-md-6">
                                    <h4 class="text-black font-GilroyBold font-18 mb-lg-0"><img
                                        src="assets/images/dollor-orange.png" class="img-fluid max-w-20px mr-2" alt=""> Shopee
                                        Coins <span class="text-gray font-14 ml-3">Coins cannot be redeemed</span></h4>
                                    </div>
                                    <div class="col-12 col-md-6 text-md-right">
                                        <div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
                                            <input type="checkbox" class="custom-control-input" id="All" disabled>
                                            <label class="custom-control-label text-medium-gray font-GilroySemiBold font-16 pl-2"
                                            for="All">[-RM0.00]</label>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
                                    <div class="col-12 col-lg-3">
                                        <h4 class="text-black font-GilroyBold font-22 mb-lg-0">Payment Method</h4>
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <div class="payment_radio_container">
                                    <!-- <input class="d-none" type="radio" name="radio" id="Cash" disabled>
                                        <label for="Cash">Cash on Delivery</label> -->
                                        <input class="d-none" type="radio" name="payment_method" value="2" id="Online" checked>
                                        <label for="Online">Ipay</label>
                        <!--    <input class="d-none" type="radio" name="radio" id="Maybank2u">
                            <label for="Maybank2u">Maybank2u</label>
                            <input class="d-none" type="radio" name="radio" id="Maxshop">
                            <label for="Maxshop">Maxshop Pay</label>
                            <input class="d-none" type="radio" name="radio" id="Credit">
                            <label for="Credit">Credit/Debit Card</label> -->
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <hr>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="row justify-content-end">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                <!-- <div class="d-flex align-items-center justify-content-between">
                                    <span class="text-gray font-14 font-GilroyMedium">Merchandise Subtotal:</span>
                                    <span class="text-gray font-14 font-GilroyMedium">RM28.99</span>
                                </div> -->
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="text-gray font-14 font-GilroyMedium">Shipping Total:</span>
                                    <span class="text-gray font-14 font-GilroyMedium">RM{{number_format($shipping_fees,2)}}</span>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-3">
                                    <span class="text-gray font-14 font-GilroyMedium">Total Payment</span>
                                    <span class="text-orange font-22 font-GilroyBold">RM{{number_format($sub_total+$shipping_fees,2)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <hr>
                    </div>
                    <div class="col-12 mt-2 text-right">
                        <button type="submit" 
                        class="btn bg-orange orange-btn text-white font-16 rounded px-5 font-GilroySemiBold">Place
                    Order</button>
                </div>
            </div>
        </div>
    </form>

</div>
</div>
</div>
</section>

<div class="modal fade" id="modalAddressForm" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title inline" id="exampleModalLabel">Add New Address</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form method="post" id="address-form">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 form-group-sub">
                        <div class="form-group">
                            <div class="from-inner-space">
                                <label class="mb-2 bmd-label-static">
                                    Full name: <span class="text-red">*</span>
                                </label>
                                <div class="form-element">
                                    <input class="form-control" type="text" placeholder="Enter full name"
                                    name="name" id="name" title="Please enter full name" autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 form-group-sub">
                        <div class="form-group">
                            <div class="from-inner-space">
                                <label class="bmd-label-static">
                                    Phone number: <span class="text-red">*</span>
                                </label>
                                <div class="form-element row">
                                    <div class="col-4 col-sm-3">
                                        <select name="country_code" class="form-control country_code"
                                        id="country_code">
                                        <option value="+60"> &nbsp;+60 &nbsp;</option>
                                        <option value="+65"> &nbsp;+65 &nbsp;</option>
                                    </select>
                                </div>
                                <div class="col-8 col-sm-9">
                                    <input class="phonenumber form-control" placeholder="Enter phone number"
                                    id="mobile" type="tel" class="" name="phone" minlength="9"
                                    maxlength="10" title="Please enter valid mobile number">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="bmd-label-static">
                                Address Line 1: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control m-input" type="text" placeholder="Address line 1"
                                name="address_line1" id="address_line1" required
                                title="Please enter address line">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="bmd-label-static">
                                Address Line 2:
                            </label>
                            <div class="form-element">
                                <input class="form-control m-input" type="text" placeholder="Address line 2"
                                name="address_line2" id="address_line2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="bmd-label-static">
                                Postcode: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control" type="tel" placeholder="Enter postcode "
                                name="postal_code" id="postal_code" title="Please enter postcode"
                                minlength="5" maxlength="5">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="bmd-label-static">
                                City: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <input class="form-control" type="text" placeholder="Enter city" id="town"
                                name="town" title="Please enter city">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 form-group-sub">
                    <div class="form-group">
                        <div class="from-inner-space">
                            <label class="bmd-label-static">
                                State: <span class="text-red">*</span>
                            </label>
                            <div class="form-element">
                                <select class=" m-select form-control" name="state" id="state"
                                title="Please select any one state">
                                <option value="" label="Select a state | region" class="ng-binding">Select a
                                State | Region</option>
                                <option value="Kuala Lumpur" label="Kuala Lumpur">Kuala Lumpur</option>
                                <option value="Labuan" label="Labuan">Labuan</option>
                                <option value="Putrajaya" label="Putrajaya">Putrajaya</option>
                                <option value="Johor" label="Johor">Johor</option>
                                <option value="Kedah" label="Kedah">Kedah</option>
                                <option value="Kelantan" label="Kelantan">Kelantan</option>
                                <option value="Melaka" label="Melaka">Melaka</option>
                                <option value="Negeri Sembilan" label="Negeri Sembilan">Negeri Sembilan
                                </option>
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
            <div class="col-12 col-sm-6 form-group-sub">
                <div class="form-group">
                    <div class="from-inner-space">
                        <label class="bmd-label-static">
                            Country: <span class="text-red">*</span>
                        </label>
                        <div class="form-element">
                            <input class="form-control" placeholder="country" type="text" class=""
                            name="country" value="Malaysia" disabled="disabled">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row">
            <div class="col-lg-12">
                <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
                id="address-button">Save</button>
            </div>
        </div>
    </div>
</form>
</div>
</div>
</div>

<div class="modal fade" id="modalVoucher" tabindex="-1" role="dialog" aria-labelledby="newVoucher" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title inline" id="exampleModalLabel">Select Voucher</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="address-form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8 col-sm-9">
                            <div class="form-group mb-0">
                                <div class="from-inner-space">
                                    <input class="form-control" type="text" placeholder="Shopee voucher code">
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-sm-3 pl-0">
                            <button type="submit" class="btn btn-block btn-primary px-3">Apply</button>
                        </div>
                    </div>
                    <div class="row mt-4 max-h-300px overflow-auto">
                        <div class="col-12">
                            <p class="font-GilroyMedium text-black font-16">Free Shipping</p>
                        </div>

                        <div class="col-12">
                            <div class="d-flex flex-column flex-md-row align-items-md-center border-voucher shadow-sm">
                                <div class="bg-light-blue py-3 w-100 w-md-25 h-100">
                                    <p class="font-GilroyBold text-white text-center font-20 text-uppercase mb-0">Free
                                    Shipping</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-3 w-md-75">
                                    <div>
                                        <p class="font-GilroyMedium text-black font-14 mb-0">All
                                        Sellers</p>
                                        <button class="btn local-seller-btn p-1 font-GilroyMedium rounded-0">No Min.
                                        Spend</button>
                                        <p class="font-GilroyMedium text-gray font-12 mb-0">Valid
                                        Till: 02.08.2022</p>
                                    </div>
                                    <div>
                                        <input class="form-control cursor-pointer shadow-none" type="radio" name="voucher" value="option1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                            <div class="d-flex flex-column flex-md-row align-items-md-center border-voucher shadow-sm">
                                <div class="bg-light-blue py-3 w-100 w-md-25 h-100">
                                    <p class="font-GilroyBold text-white text-center font-20 text-uppercase mb-0">Free
                                    Shipping</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-3 w-md-75">
                                    <div>
                                        <p class="font-GilroyMedium text-black font-14 mb-0">All
                                        Sellers</p>
                                        <button class="btn local-seller-btn p-1 font-GilroyMedium rounded-0">No Min.
                                        Spend</button>
                                        <p class="font-GilroyMedium text-gray font-12 mb-0">Valid
                                        Till: 02.08.2022</p>
                                    </div>
                                    <div>
                                        <input class="form-control cursor-pointer shadow-none" type="radio" name="voucher" value="option2">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="d-flex flex-column flex-md-row align-items-md-center border-voucher shadow-sm">
                                <div class="bg-light-blue py-3 w-100 w-md-25 h-100">
                                    <p class="font-GilroyBold text-white text-center font-20 text-uppercase mb-0">Free
                                    Shipping</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center p-3 w-md-75">
                                    <div>
                                        <p class="font-GilroyMedium text-black font-14 mb-0">All
                                        Sellers</p>
                                        <button class="btn local-seller-btn p-1 font-GilroyMedium rounded-0">No Min.
                                        Spend</button>
                                        <p class="font-GilroyMedium text-gray font-12 mb-0">Valid
                                        Till: 02.08.2022</p>
                                    </div>
                                    <div>
                                        <input class="form-control cursor-pointer shadow-none" type="radio" name="voucher" value="option3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-danger px-3 mr-2" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success px-3">Ok</button>
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
    var updateOrderQty = "{{route('user.order.updateqty')}}";
    $(document).on('click','.plus', function(e){
        var currentvalue = parseInt($(this).prev('.increment').children('span').text());
        var value = currentvalue + 1;
        $(this).prev('.increment').children('span').text(value);
        var order_product_id = $(this).data('id');
        // alert(order_product_id+' '+value);
        $('#qty').val(value);
        $.ajax({
            type:'PUT',
            url:updateOrderQty,
            data:{
                'order_product_id': order_product_id,
                'qty': value
            },
            success: function(response){
                if(response.success == true){
                    $("#productsection").load(location.href+'/1' + " #productsection");
                    // location.reload();
                }
            }
        });
    });
    $(document).on('click','.minus', function(e){
        var currentvalue = parseInt($(this).next('.increment').children('span').text());
        if(currentvalue > 1){
            var value = currentvalue - 1;
            var order_product_id = $(this).data('id');

            $(this).next('.increment').children('span').text(value);
            $('#qty').val(value);
            $.ajax({
                type:'PUT',
                url:updateOrderQty,
                data:{
                    'order_product_id': order_product_id,
                    'qty': value
                },
                success: function(response){
                    if(response.success == true){
                        $("#productsection").load(location.href + " #productsection");
                        // location.reload();
                    }
                }
            });
        }
    })
</script>
@endsection