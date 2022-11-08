@extends('layouts.main')
@section('title', 'Checkout')
@section('content')

<section class="bg-gray pt-4 pb-5">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<form method="post" action="{{route('placeorder')}}">
					<div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden">
						<div class="col-12 col-md-4">
							<div class="d-flex align-items-center">
								<img src="assets/images/location-orange.png" class="img-fluid max-w-14px" alt="">
								<h3 class="font-18 font-GilroySemiBold text-orange ml-2 mb-0">{{trans('label.delivery_address')}}</h3>
							</div>
						</div>
						<div class="col-12 col-md-8 text-md-right cus-add-btn">
							<button class="btn bg-orange orange-btn text-white font-14 rounded px-4 font-GilroySemiBold mr-sm-2 mt-3 mt-md-0"
							data-toggle="modal" data-target="#modalAddressForm">+ {{trans('label.add_new_address')}}</button>
							<!-- <button class="btn bg-orange orange-btn text-white font-14 rounded px-4 font-GilroySemiBold mt-3 mt-md-0"> Manage Addresses</button> -->
						</div>

						<div class="col-12 mt-4">
							<div class="row align-items-center cus-add-change-btn">
								<input type="hidden" name="voucher_id" id="voucher_id" value="{{$voucherId}}">
								{{ csrf_field() }}
								@if($orderFor == 'customer')
								<div class="col-12 col-md-auto" id="orderaddress">
									<h1 class="text-black font-16 font-GilroySemiBold mb-0">{{$customerCurrentAddress->name}} ({{$customerCurrentAddress->country_code ? $customerCurrentAddress->country_code : $customerCurrentAddress->countrycode}}) {{$customerCurrentAddress->contact_number ? $customerCurrentAddress->contact_number : $customerCurrentAddress->contact_no}}</h1>
									<?php $fulladdress = implode(", ", array_filter([$customerCurrentAddress->address_line1, $customerCurrentAddress->address_line2, $customerCurrentAddress->town, $customerCurrentAddress->state, $customerCurrentAddress->country, $customerCurrentAddress->postal_code])) ; ?>
									<span class="text-gray font-14 font-GilroyMedium mb-0 ml-3">{{$fulladdress}}</span>
								</div>
								<div class="col-12 col-md-auto">
									<span class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold cus-change-address"><u>{{trans('label.change_capital')}}</u></span>
								</div>
								@else
								<div class="col-12 col-md-auto" id="orderaddress">
									<h1 class="text-black font-16 font-GilroySemiBold mb-0">{{$current_address->name}} ({{$current_address->country_code ? $current_address->country_code : $current_address->countrycode}}) {{$current_address->contact_number ? $current_address->contact_number : $current_address->contact_no}}</h1>
									<?php $fulladdress = implode(", ", array_filter([$current_address->current_address_line1, $current_address->current_address_line2, $current_address->town, $current_address->state, $current_address->country, $current_address->postal_code])) ; ?>
									<span class="text-gray font-14 font-GilroyMedium mb-0 ml-3">{{$fulladdress}}</span>
								</div>
								@if($orderFor != 'self')
								<div class="col-12 col-md-auto">
									<span class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold cus-change-address"><u>{{trans('label.change_capital')}}</u></span>
								</div>
								@endif
								@endif
							</div>
							<div class="row cus-add-btn" id="address-list">
								@if($orderFor == 'self')
								<div class="col-12">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="address[]"
										id="{{App\Helpers\Helper::encrypt($current_address->id)}}" value="{{App\Helpers\Helper::encrypt($current_address->id)}}" @if($current_address->id == $current_address->id) checked @endif>
										<label class="form-check-label text-black font-16 font-GilroySemiBold" for="{{App\Helpers\Helper::encrypt($current_address->id)}}">
											{{$current_address->name}} ({{$current_address->country_code ? $current_address->country_code : $current_address->countrycode }}) {{$current_address->contact_number ? $current_address->contact_number : $current_address->contact_no}}
											<?php
											$fulladdress = implode(", ", array_filter([$current_address->address_line1, $current_address->address_line2, $current_address->town, $current_address->state, $current_address->country, $current_address->postal_code])) ;
											?>
											<span class="text-gray font-14 font-GilroyMedium mb-0 ml-3">{{$fulladdress}}</span>
										</label>
									</div>
								</div>
								@elseif($orderFor == 'customer')
								@foreach($customerAddresses as $address)
								<div class="col-12">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="address[]"
										id="{{App\Helpers\Helper::encrypt($address->id)}}" value="{{App\Helpers\Helper::encrypt($address->id)}}" @if($customerCurrentAddress->id == $address->id) checked @endif>
										<label class="form-check-label text-black font-16 font-GilroySemiBold" for="{{App\Helpers\Helper::encrypt($address->id)}}">
											{{$address->name}} ({{$address->country_code ? $address->country_code : $address->countrycode}}) {{$address->contact_number ? $address->contact_number : $address->contact_no}}
											<?php
											$fulladdress = implode(", ", array_filter([$address->address_line1, $address->address_line2, $address->town, $address->state, $address->country, $address->postal_code])) ;
											?>
											<span class="text-gray font-14 font-GilroyMedium mb-0 ml-3">{{$fulladdress}}</span>
										</label>
									</div>
								</div>
								@endforeach
								@else
								@foreach($addresses as $address)
								<div class="col-12">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="address[]"
										id="{{App\Helpers\Helper::encrypt($address->id)}}" value="{{App\Helpers\Helper::encrypt($address->id)}}" @if($current_address->id == $address->id) checked @endif>
										<label class="form-check-label text-black font-16 font-GilroySemiBold" for="{{App\Helpers\Helper::encrypt($address->id)}}">
											{{$address->name}} ({{$address->country_code ? $address->country_code : $address->countrycode}}) {{$address->contact_number ? $address->contact_number : $address->contact_no}}
											<?php
											$fulladdress = implode(", ", array_filter([$address->address_line1, $address->address_line2, $address->town, $address->state, $address->country, $address->postal_code])) ;
											?>
											<span class="text-gray font-14 font-GilroyMedium mb-0 ml-3">{{$fulladdress}}</span>
										</label>
									</div>
								</div>
								@endforeach
								@endif
								<div class="col-12 mt-4">
									<label id="changeaddress" class="btn btn-success font-14 rounded px-4 font-GilroySemiBold mr-sm-2 mt-3 mt-md-0">{{trans('label.submit')}}</label>
									<label class="btn btn-danger font-14 rounded px-4 font-GilroySemiBold cus-add-close-btn" >{{trans('label.cancel')}}</label>
								</div>
							</div>
						</div>
					</div>
					<div id="productsection">
						<?php $shipping_fees = 0;?>
						@foreach($cartitem as $item)
						<div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
							<div class="col-12 table-responsive">
								<table class="table voucher-table">
									<thead>
										<tr>
											<th width="50%" class="font-16 text-black font-GilroySemiBold">{{trans('label.products_ordered')}}</th>
											<th width="15%"></th>
											<th width="15%" class="font-14 text-gray font-GilroyMedium text-center text-nowrap">
												{{trans('label.unit_price')}}
											</th>
											<th width="10%" class="font-14 text-gray font-GilroyMedium text-center text-nowrap">
												{{trans('label.qty')}}
											</th>
											<th width="10%" class="font-14 text-gray font-GilroyMedium text-right text-nowrap">
												{{trans('label.item_subtotal')}}
											</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td colspan="5">
												<div class="d-flex align-items-center">
													<img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{  $item['image'] }}" class="img-fluid max-w-35px mr-2"
													alt="">
													<span>{{$item['seller_name']}}</span>
												</div>
											</td>
										</tr>
										@foreach($item['products'] as $productitem)
										<?php $product = $productitem->productdetails;?>
										<tr>
											<td class="font-14 align-middle">
												<div  class="d-flex align-items-center">
													<a  href="{{ route('productDetail',$product->slug) }}">
														<img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $product->images[0]->thumb }}" class="img-fluid max-w-70px mr-3 prd-image"
														alt="">
														<span>{{$product->name}}</span>
													</a>
												</div>
												
											</td>
											@if($productitem->variation_id != 0)
											<?php $variation = implode(', ', $productitem->variation->variation);?>
											<td class="text-gray font-14 align-middle">{{trans('label.variation')}}: {{$variation}}</td>
											@else
											<td class="text-gray font-14 align-middle"></td>
											@endif
											<td class="font-14 text-center align-middle">RM{{number_format(($productitem->variation_id != 0) ? $productitem->variation->sell_price : $product->sell_price,2)}}</td>
											<td class="font-14 text-center align-middle">{{$productitem->qty}}</td>
											<td class="text-right font-14 align-middle">RM{{number_format(($productitem->variation_id != 0) ? $productitem->variation->sell_price * $productitem->qty : $product->sell_price * $productitem->qty,2)}}</td>
										</tr>
										@endforeach

										@if($item['vouchers'] && count($item['vouchers']) > 0)
										<tr class="border-top border-bottom border-secondary">
											<td class="font-14 align-middle text-right font-GilroyMedium" colspan="2">{{trans('label.shop_voucher')}}</td>
											<input type="hidden" name="voucherId[]" id="voucher_{{$item['seller_id']}}">
											<td class="text-right font-16 align-middle voucher-button-main" id="seller_voucher_{{$item['seller_id']}}" colspan="3">
												<span class="cursor-pointer text-light-blue font-GilroySemiBold" id="shop-voucher" data-id="{{$item['seller_id']}}"
												data-value="{{$item['seller_total']}}" data-toggle="modal" data-target="#modalVoucher">{{trans('label.select_voucher')}}</span>
											</td>
											<td class="text-right font-16 align-middle discount voucher-button-toggle" style="display:none" id="seller_voucher_change_{{$item['seller_id']}}">
												<span class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold" data-id="{{$item['seller_id']}}"
												data-value="{{$item['seller_total']}}" data-toggle="modal" data-target="#modalVoucher">{{trans('label.change_coupon')}}</span>
											</td>

											<td class="text-right font-16 align-middle discount seller-discount-div" id="discount_{{$item['seller_id']}}" colspan="2" style="display:none">
												<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap">{{trans('label.discount')}} : </span>
												<input type="hidden" name="discountData[]" id="discount_data_{{$item['seller_id']}}">
												<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap" name="discount[]" id="discount_value_{{$item['seller_id']}}"></span>
											</td>
											<td class="text-right font-16 align-middle cashback seller-cashback-div" id="cashback_{{$item['seller_id']}}" colspan="2" style="display:none">
												<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap">{{trans('label.cashback')}} : </span>
												<input type="hidden" name="cashbackData[]" id="cashback_data_{{$item['seller_id']}}">
												<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap" name="cashback[]" id="cashback_value_{{$item['seller_id']}}"></span>
											</td>
										</tr>
										@endif

										<tr class="border-bottom border-secondary shipping_div" id="shipping_div{{App\Helpers\Helper::encrypt($item['seller_id'])}}">
											<td class="border-right border-secondary">
												<div class="row align-items-center">
													<div class="col-auto pr-0">
														<span class="text-black font-14 font-GilroyMedium">{{trans('label.message')}}:</span>
													</div>
													<div class="col-8 col-sm-9">
														<div class="form-group mb-0">
															<div class="from-inner-space">
																<input class="form-control" name="message[{{$item['seller_id']}}]" type="text"
																placeholder="{{trans('label.optional_leave_a_message_to_seller')}}">
															</div>
														</div>
													</div>
												</div>
											</td>
											<td class="font-14 text-slate-green align-middle font-GilroyMedium">{{trans('label.shipping_option')}}:
											</td>
											<td class="font-14 align-middle">
												<input type="hidden" name="shipping_company[]" value="{{($item['shipping_companies']->count() > 0) ? $item['shipping_company']->id : ''}}">
												<div class="font-GilroySemiBold text-black">{{($item['shipping_companies']->count() > 0) ? $item['shipping_company']->name : trans('label.no_shipping_available')}}</div>
												<!-- <div class="text-gray font-10 font-GilroyMedium">Receive by 29 Jul - 3 Aug</div> -->
											</td>
											<td class="text-right font-14 align-middle">
												@if($item['shipping_companies']->count() > 0)
												<div class="modal fade" id="modalShippingOption{{$item['seller_id']}}" tabindex="-1" role="dialog" aria-labelledby="shippingOption"
												aria-hidden="true">
												<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
													<div class="modal-content">
														<div class="modal-header px-4">
															<h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.select_shipping_option')}}</h4>
														</div>
														<div class="modal-body px-4 min-h-300px">
															<div class="row">
																<div class="col-12" id="frm{{$item['seller_id']}}">
																	<?php $i = 0;?>

																	@foreach($item['shipping_companies'] as $shipping_company)
																	<div class="voucher-radio mt-2">
																		<input class="form-check-input d-none" type="radio" name="shipping{{$item['seller_id']}}" id="test{{$item['seller_id']}}{{$i}}" value="{{App\Helpers\Helper::encrypt($shipping_company->id)}}" data-seller="{{App\Helpers\Helper::encrypt($item['seller_id'])}}" @if($item['shipping_company']->id == $shipping_company->id) checked @endif>
																		<label class="py-3 border-left-orange cursor-pointer d-flex justify-content-between align-items-center" for="test{{$item['seller_id']}}{{$i}}">
																			<div class="pl-4">
																				<div class="font-GilroySemiBold font-16 text-black">{{$shipping_company->name}} <span class="ml-4 text-orange font-GilroyMedium">RM{{$shipping_company->price}}</span></div>
																				<!-- <div class="text-gray font-12 font-GilroyMedium">Receive by 29 Jul - 3 Aug</div> -->
																			</div>
																			<div class="pr-4">
																				<img src="assets/images/red-mark.png" class="img-fluid max-w-20px d-none" alt="">
																			</div>
																		</label>
																	</div>
																	<?php $i++;?>

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
																			<button type="button" class="btn btn-danger px-3 mr-2" data-dismiss="modal">{{trans('label.cancel')}}</button>
																			<button type="button" class="btn btn-success px-3 changeshipping" id="{{$item['seller_id']}}">{{trans('label.submit')}}</button>
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<span class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold" data-toggle="modal" data-target="#modalShippingOption{{$item['seller_id']}}">{{trans('label.change_capital')}}</span>
													@endif
												</td>
												<td class="text-right font-14 align-middle">RM{{($item['shipping_companies']->count() > 0) ? $item['shipping_company']->price : ''}}</td>
											</tr>
											<tr class="reload-data">
												<?php 
												$seller_shipping = ($item['shipping_companies']->count() > 0) ? $item['shipping_company']->price : 0;
												$shipping_fees += $seller_shipping;
												?>
											</tr>
											<tr>
												<td class="font-14 align-middle text-right font-GilroyMedium seller-total" id="seller-total{{App\Helpers\Helper::encrypt($item['seller_id'])}}" colspan="5">
													<div class="d-flex align-items-center justify-content-end">
														<p class="text-gray font-14 font-GilroyMedium mb-0">{{trans('label.order_total')}} ({{$item['totalitems']}} @if($item['totalitems'] <= 1) {{trans('label.item')}} @else {{trans('label.items')}} @endif):
														</p>
														<span class="text-orange font-22 font-GilroyBold ml-3" id="order_total_{{$item['seller_id']}}" data-id="{{$item['seller_total'] + $seller_shipping}}">RM{{number_format($item['seller_total'] + $seller_shipping,2)}}</span>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							@endforeach
							@if($vouchersOfProducts && count($vouchersOfProducts) > 0)
							<div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
								<div class="col-12 col-sm-6">
									<h4 class="text-black font-GilroyBold font-18 mb-sm-0">{{trans('label.voucher')}}</h4>
								</div>
								<div class="col-12 col-sm-6 text-sm-right product-voucher-button">
									<span class="cursor-pointer text-light-blue font-GilroySemiBold" data-toggle="modal"
									data-target="#modalProductVoucher">{{trans('label.select_voucher')}}</span>
								</div>

								<div class="col-12 col-sm-3 text-right font-16 discount product-voucher-button-toggle" style="display:none" id="seller_voucher_change_{{$item['seller_id']}}">
									<span class="cursor-pointer text-light-blue ml-2 font-GilroySemiBold" data-id="{{$item['seller_id']}}"
									data-value="{{$item['seller_total']}}" data-toggle="modal" data-target="#modalProductVoucher">{{trans('label.change_coupon')}}</span>
								</div>
								<div class="col-12 col-sm-3 text-right font-16 discount product-discount-div" style="display:none">
									<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap">{{trans('label.discount')}} : </span>
									<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap" name="discount[]" id="product_discount_value"></span>
								</div>
								<div class="col-12 col-sm-3 text-right font-16 cashback product-cashback-div" style="display:none">
									<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap">{{trans('label.cashback')}} : </span>
									<span class="font-14 text-gray font-GilroyMedium text-center text-nowrap" name="cashback[]" id="product_cashback_value"></span>
								</div>

								<!-- <div class="col-12 my-2">
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
								</div> -->
							</div>
							@endif
							<div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4" id="amount-div">
								<div class="col-12 col-lg-3">
									<h4 class="text-black font-GilroyBold font-22 mb-lg-0">{{trans('label.payment_method')}}</h4>
								</div>
								<div class="col-12 col-lg-9">
									<div class="payment_radio_container">
										<input class="d-none" type="radio" name="payment_method" value="3" id="wallet" checked>
										<label for="wallet">{{trans('label.wallet')}}</label>
									<!-- <input class="d-none" type="radio" name="payment_method" value="2" id="Online" >
										<label for="Online">Ipay</label> -->
									<!-- 	<input class="d-none" type="radio" name="radio" id="Maybank2u">
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
								<div class="col-12 col-lg-3">
									<h4 class="text-black font-GilroyBold font-22 mb-lg-0">{{trans('label.credit_balance')}}</h4>
								</div>
								<div class="col-12 col-lg-9">
									RM{{ Auth::user()->wallet_amount }}
								</div>
								<div class="col-12 mt-3" id="total-payment-div">
									<div class="row justify-content-end">
										<div class="col-12 col-md-6 col-lg-4 col-xl-3">
										<!-- <div class="d-flex align-items-center justify-content-between">
											<span class="text-gray font-14 font-GilroyMedium">Merchandise Subtotal:</span>
											<span class="text-gray font-14 font-GilroyMedium">RM28.99</span>
										</div> -->
										<div class="d-flex align-items-center justify-content-between mt-3 shipping-total-div">
											<span class="text-gray font-14 font-GilroyMedium">{{trans('label.shipping_total')}}:</span>
											<input type="hidden" name="setShippingFees" value="{{$shipping_fees}}">
											<span class="text-gray font-14 font-GilroyMedium">RM{{number_format($shipping_fees,2)}}</span>
										</div>
										@if($cartContainBundleProduct == 'true' && $bundleDiscount > 0)
										<div class="d-flex align-items-center justify-content-between mt-3">
											<span class="text-gray font-14 font-GilroyMedium">{{trans('label.bundle_discount')}}:</span>
											<span class="text-gray font-14 font-GilroyMedium">- RM{{number_format($bundleDiscount,2)}}</span>
										</div>
										@endif
										<input type="hidden" name="finalDiscount" id="finalDiscount" value="{{$voucherDiscount && $voucherDiscount > 0 ? $voucherDiscount : ''}}">
										<input type="hidden" name="finalCashback" id="finalCashback" value="{{$voucherCashback && $voucherCashback > 0 ? $voucherCashback : ''}}">
										<input type="hidden" name="finalDeduction" id="finalDeduction" value="">
										<input type="hidden" name="finalDeductionId" id="finalDeductionId" value="{{$voucherId}}" data-discounttype="{{ Helper::getVoucherType($voucherId) }}" >
										<input type="hidden" name="finalDeductionType" id="finalDeductionType" value="{{$voucherDiscount ? 'discount' : 'cashback'}}">
										<input type="hidden" name="referenceId" id="referenceId" >
										@if($voucherDiscount && $voucherDiscount > 0)
										<div class="d-flex align-items-center justify-content-between mt-3" id="voucherDiscount">
											<span class="text-gray font-14 font-GilroyMedium"> {{trans('label.discount')}}:</span>
											<span class="text-gray font-14 font-GilroyMedium">({{ Helper::getVoucherName($voucherId) }}) - RM{{number_format($voucherDiscount,2)}}</span>
										</div>
										@endif
										@if($voucherCashback && $voucherCashback > 0)
										<div class="d-flex align-items-center justify-content-between mt-3" id="voucherCashback">
											<span class="text-gray font-14 font-GilroyMedium"> {{trans('label.cashback')}}:</span>
											<span class="text-gray font-14 font-GilroyMedium">({{ Helper::getVoucherName($voucherId) }}) RM{{number_format($voucherCashback,2)}}</span>
										</div>
										@endif
										<div class="align-items-center justify-content-between mt-3 shopDiscount" style="display:none">
											<span class="text-gray font-14 font-GilroyMedium">{{trans('label.discount')}}:</span>
											<span class="text-gray font-14 font-GilroyMedium" id="shopDiscount"></span>
										</div>
										<div class="align-items-center justify-content-between mt-3 shopCashback" style="display:none">
											<span class="text-gray font-14 font-GilroyMedium">{{trans('label.cashback')}}:</span>
											<span class="text-gray font-14 font-GilroyMedium" id="shopCashback"></span>
										</div>
										<?php $usedCoins = 0;?>
										<?php $usedCoinsRM = 0;?>
										@if($coinsData && count($coinsData) > 0 && isset($coinsData['usedRM']) && isset($coinsData['usedCoins']) && $coinsData['usedCoins'] > 0 && $coinsData['usedRM'] > 0)
										<?php $usedCoins = $coinsData['usedCoins']?>
										<?php $usedCoinsRM = $coinsData['usedRM']?>
										<div class="d-flex align-items-center justify-content-between mt-3">
											<span class="text-gray font-14 font-GilroyMedium">{{trans('label.used_coins')}}:</span>
											<input type="hidden" name="used_coins" id="used_coins" value="{{round($coinsData['usedCoins'])}}">
											<input type="hidden" name="used_coins_in_rm" id="used_coins_in_rm" value="{{number_format($coinsData['usedRM'],2)}}">
											<span class="text-gray font-14 font-GilroyMedium" id="setCoins">-RM{{number_format($coinsData['usedRM'],2)}} ({{round($coinsData['usedCoins'])}} {{trans('label.coins')}})</span>
										</div>
										@endif
										<div id="total-payment">
											<input type="hidden" name="totalWithoutDiscount" id="totalWithoutDiscount" value="{{$sub_total+$shipping_fees - $bundleDiscount,2}}">
											<div class="d-flex align-items-center justify-content-between mt-3">
												<span class="text-gray font-14 font-GilroyMedium">{{trans('label.total_payment')}}</span>
												<input type="hidden" name="totalWithDiscount" id="totalWithDiscount" value="{{$sub_total+$shipping_fees - $bundleDiscount - $usedCoinsRM,2}}">
												<span class="text-orange font-22 font-GilroyBold" id="totalPayment">RM{{number_format($sub_total + $shipping_fees - $bundleDiscount - $voucherDiscount - $usedCoinsRM,2)}}</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 mt-2">
								<hr>
							</div>
							<div class="col-12 mt-2 text-right">
								<button type="submit"
								class="btn bg-orange orange-btn text-white font-16 rounded px-5 font-GilroySemiBold" >{{trans('label.place_order')}}</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="modalAddressForm" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
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
					<div class="row">
						<div class="col-12 form-group-sub">
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
						<div class="col-12 form-group-sub">
							<div class="form-group">
								<div class="from-inner-space">
									<label class="bmd-label-static">
										{{trans('label.phone_number')}}: <span class="text-red">*</span>
									</label>
									<div class="form-element row">
										<div class="col-4 col-sm-3">
											<select name="country_code" class="form-control country_code" id="country_code">
												<option value="+60"> &nbsp;+60 &nbsp;</option>
												<option value="+65"> &nbsp;+65 &nbsp;</option>
											</select>
										</div>
										<div class="col-8 col-sm-9">
											<input class="phonenumber form-control" placeholder="{{trans('label.enter_phone_number')}}"
											id="mobile" type="tel" class="" name="phone" minlength="9"
											maxlength="10" title="{{trans('label.please_enter_valid_mobile_number')}}">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 form-group-sub">
							<div class="form-group">
								<div class="from-inner-space">
									<label class="bmd-label-static">
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
						<div class="col-12 form-group-sub">
							<div class="form-group">
								<div class="from-inner-space">
									<label class="bmd-label-static">
										{{trans('label.address_line_2')}}:
									</label>
									<div class="form-element">
										<input class="form-control m-input" type="text" placeholder="{{trans('label.address_line_2')}}"
										name="address_line2" id="address_line2">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 form-group-sub">
							<div class="form-group">
								<div class="from-inner-space">
									<label class="bmd-label-static">
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
						<div class="col-12 col-sm-6 form-group-sub">
							<div class="form-group">
								<div class="from-inner-space">
									<label class="bmd-label-static">
										{{trans('label.city')}}: <span class="text-red">*</span>
									</label>
									<div class="form-element">
										<input class="form-control" type="text" placeholder="{{trans('label.enter_city')}}" id="town"
										name="town" title="{{trans('label.please_enter_city')}}">
									</div>
								</div>
							</div>
						</div>
						<div class="col-12 col-sm-6 form-group-sub">
							<div class="form-group">
								<div class="from-inner-space">
									<label class="bmd-label-static">
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
											<option value="Negeri Sembilan" label="Negeri Sembilan">Negeri Sembilan </option>
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
					<div class="row">
						<div class="col-lg-12">
							<button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
							id="address-button">{{trans('label.save')}}</button>
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
				<h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.select_voucher')}}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="voucher-form" >
				{{ csrf_field() }}
				<div class="modal-body">
					<input type="hidden" name="subTotal" id="subTotal">
					<!-- <div class="row">
						<div class="col-8 col-sm-9">
							<div class="form-group mb-0">
								<div class="from-inner-space">
									<input class="form-control" type="text" placeholder="Shopee voucher code">
								</div>
							</div>
						</div>
						<div class="col-4 col-sm-3 pl-0">
							<button type="button" class="btn btn-block btn-primary px-3">Apply</button>
						</div>
					</div> -->
					<div class="row mt-4 max-h-300px overflow-auto append-voucher">

					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-12">
							<button type="button" class="btn btn-danger px-3 mr-2" data-dismiss="modal">{{trans('label.cancel')}}</button>
							<button type="button" class="btn btn-success px-3" id="apply-voucher">{{trans('label.ok')}}</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="modalProductVoucher" tabindex="-1" role="dialog" aria-labelledby="newVoucher" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.select_product_voucher')}}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="product-voucher-form" >
				{{ csrf_field() }}
				<div class="modal-body">
					<input type="hidden" name="subTotal" id="subTotal">
					<div class="row mt-4 max-h-300px overflow-auto append-product-voucher">

					</div>
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-12">
							<button type="button" class="btn btn-danger px-3 mr-2" data-dismiss="modal">{{trans('label.cancel')}}</button>
							<button type="button" class="btn btn-success px-3" id="apply-product-voucher">{{trans('label.ok')}}</button>
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
	var getaddresshtml 		    	= "{{ route('getaddresshtml') }}";
	var checkcheckoutshipping 		= "{{ route('checkcheckoutshipping') }}";
	var addaddressurl           	= "{{route('user.add_address')}}";
	var shippingmethodchange    	= "{{route('changeShippingMethod')}}";
	var getsellervoucher        	= "{{route('getSellerVoucher')}}";
	var setsellervoucher        	= "{{route('setSellerVoucher')}}";
	var voucherDiscount         	= "{{isset($voucherDiscount) ? $voucherDiscount : ''}}";
	var voucherCashback         	= "{{isset($voucherCashback) ? $voucherCashback : ''}}";
	var usedCoins               	= "{{isset($usedCoins) ? $usedCoins : ''}}";
	var usedCoinsRM             	= "{{isset($usedCoinsRM) ? $usedCoinsRM : ''}}";
	var subtotalwithoutshipping 	= "{{isset($sub_total) ? $sub_total : ''}}";
	var shipping_fees 				= "{{isset($shipping_fees) ? $shipping_fees : ''}}";
	var getvouchername 		    	= "{{ route('getvoucherdata') }}";
	var getproductvoucherincheckout = "{{ route('getproductvoucherincheckout') }}";
	var productArray 			 	= <?php echo json_encode($productDataArray); ?>;
	var addvoucherurl    	 		= "{{ route('addvoucherurl') }}";
	var cartVoucherId             	= "{{isset($voucherId) ? $voucherId : ''}}";
	var promotionVoucherId          = "{{isset($setPromotionVoucherId) ? $setPromotionVoucherId : ''}}";
	var promotionSellerTotal        = "{{isset($setPromotionSellerTotal) ? $setPromotionSellerTotal : ''}}";
	var promotionSellerId           = "{{isset($setPromotionSellerId) ? $setPromotionSellerId : ''}}";
	var sellerIDs 			 		= <?php echo json_encode($sellerIDs); ?>;

	$(document).on('click','.changeshipping',function(e){
		var id = $(this).attr('id');
		var ele = $('#frm'+id).children().children('input[name="shipping'+id+'"]:checked');
		var shippingmethod = ele.val();
		var seller = ele.data('seller');

		$.ajax({
			type:'PUT',
			url: shippingmethodchange,
			data:{
				'shippingmethod': shippingmethod,
				'seller': seller
			},
			success: function(response){
				$(".reload-data").load(location.href+" .reload-data>*","");

				// update shippinf fees of seller
				var sellerShippingDiv = 'shipping_div'+seller;
				$("#"+sellerShippingDiv).load(location.href+" #"+sellerShippingDiv+">*",""); 

				// update seller total
				var sellerTotal = 'seller-total'+seller;					
				$("#"+sellerTotal).load(location.href+" #"+sellerTotal+">*",""); 

				$("#total-payment").load(location.href+" #total-payment>*","")
				// update final shipping
				$(".shipping-total-div").load(location.href+" .shipping-total-div>*","")
				
				$('#modalShippingOption'+id).modal('hide');
				// var checkVoucherType = $("#finalDeductionType").val();
			}
		});
	});

	$("body").on('DOMSubtreeModified', ".shipping-total-div", function() {
		var discountTypeLoad = $('#finalDeductionId').attr('data-discounttype');
		if(discountTypeLoad == 'seller'){
			reload_voucher();
		}
		if(discountTypeLoad == 'product'){
			reload_product_voucher();
		}
	});

	$( document ).ready(function() {
		if(promotionVoucherId != undefined && promotionVoucherId > 0){
			$("#apply-voucher").click();
		}
		if(cartVoucherId != undefined && cartVoucherId > 0){
			$("#apply-product-voucher").click();
		}
	});

	$('#modalVoucher').on('hidden.bs.modal', function(e) {
		$(this).find('#voucher-form')[0].reset();
	});

	$('#modalVoucher').on('show.bs.modal', function (e) {
		var sellerId = $(e.relatedTarget).data('id');
		var subTotal = $(e.relatedTarget).data('value');

		var voucherId = $('#finalDeductionId').val();
		if(voucherId && voucherId > 0 && voucherId != '' && voucherId != undefined){
			voucherId = voucherId;
		}else{
			voucherId = 0;
		}
		$.ajax({
			type : 'PUT',
			url : getsellervoucher,
			data: {
				sellerId : sellerId,
				voucherId : voucherId,
				subTotal : subTotal,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success : function(response){
				$('.append-voucher').html(response.html);
				$("#subTotal").val(subTotal);
			}
		});
	});

	$('#modalProductVoucher').on('hidden.bs.modal', function(e) {
		$(this).find('#product-voucher-form')[0].reset();
	});

	$('#modalProductVoucher').on('show.bs.modal', function (e) {
		var voucherId = $('#finalDeductionId').val();
		if(voucherId && voucherId > 0 && voucherId != '' && voucherId != undefined){
			voucherId = voucherId;
		}else{
			voucherId = 0;
		}
		$.ajax({
			type: 'PUT',
			url: getproductvoucherincheckout,
			data: {
				'productArray': productArray,
				'voucherId' : voucherId,
			},
			success : function(response){
				$('.append-product-voucher').html(response.html);
				$("#subTotal").val(subTotal);
			}
		});
	});
</script>
<script src="{{ asset('assets/js/order.js').'?v='.time() }}"></script>
@endsection