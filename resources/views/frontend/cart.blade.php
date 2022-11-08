<?php 
use App\Helpers\Helper;
?>
@extends('layouts.main')
@section('title', 'Cart')
@section('css')
<style>
	.coupon-list{
		display:none;
	}
	.bg-filter {
		background-color: #f3f3f3 !important;
	}
</style>

@endsection
@section('content')
<section class="bg-gray pt-4 pb-5">
	<div class="container">
		<form action="{{route('changecart') }}" method="post" id="checkoutfrm">
			<div class="row">
				{{ csrf_field() }}
				<div class="col-12 col-xl-8">
					<div class="row align-items-center bg-white mx-0 br-15 py-3 shadow overflow-hidden">
						<div class="col-12 col-md-8">
							<div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
								<input type="checkbox" class="custom-control-input" id="All">
								<label class="custom-control-label text-medium-gray font-GilroySemiBold font-16 pl-2"
								for="All">{{trans('label.select_all_items')}} ({{$totalitems}} @if($totalitems <= 1) {{trans('label.item')}} @else {{trans('label.items')}} @endif)</label>
								</div>
							</div>
							<div class="col-12 col-md-4 mt-3 mt-md-0 position-relative">
								<img src="assets/images/down arrow 24_24.png" class="select-arrow" alt="">
								<select name="action" class="form-control cus-filter font-GilroyBold text-gray bg-filter border-0" id="action">
									<option value="actionOption">{{trans('label.select_action')}}</option>
									<option value="delete">{{trans('label.delete')}}</option>
									<option value="wishlist">{{trans('label.move_to_wishlist')}}</option>
								</select>
							</div>
						</div>
						@if(count($cartitem) == 0)
						<div class="row align-items-center bg-white mx-0 br-15 py-3 mt-4 shadow overflow-hidden">
							<div class="col-12 col-md-4">
								{{trans('label.your_cart_is_empty')}}
							</div>
						</div>

						@endif
						@foreach($cartitem as $item)
						<div class="row align-items-center bg-white mx-0 br-15 py-3 mt-4 shadow overflow-hidden">
							<div class="col-12 col-md-4">
								<div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
									<input type="checkbox" class="custom-control-input seller" id="{{ Helper::encrypt($item['seller_id']) }}">
									<label
									class="custom-control-label text-black font-GilroyBold font-22 pl-2 cart-checkbox-label"
									for="{{ Helper::encrypt($item['seller_id']) }}">{{$item['seller_name']}}</label>
								</div>
							</div>
							<div class="col-12 col-md-8 mt-3 mt-md-0 position-relative">
								<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-end pr-md-2">
									<!-- <div>
										<img src="assets/images/sale.png" class="img-fluid max-w-14px" alt="">
										<span class="text-black font-GilroySemiBold font-12 pl-2">Up to 12% of voucher
										available</span>
									</div>
									<div class="ml-md-4">
										<img src="assets/images/dollor-orange.png" class="img-fluid max-w-14px" alt="">
										<span class="text-black font-GilroySemiBold font-12 pl-2">Coins Redeemable</span>
									</div> -->
								</div>
							</div>

							<div class="col-12 bg-gray-light pb-4 pt-2 my-2">
								@foreach($item['products'] as $productitem)
								<?php $product = $productitem->productdetails;  ?>
								<div class="row align-items-center mt-4">
									<div class="col-12 col-md-6">
										<div class="d-flex align-items-center">
											<div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
												<input type="checkbox" name="prd[]" class="custom-control-input selleritem {{ Helper::encrypt($item['seller_id']) }}" value="{{ Helper::encrypt($productitem->id) }}" 
												id="chx{{ Helper::encrypt($productitem->id) }}" data-id="{{ Helper::encrypt($item['seller_id']) }}"  data-productId="{{ $productitem->product->id}}"
												data-price="{{(($productitem->product->is_variation == '1' && $productitem->product->variation) ? $productitem->variation->sell_price : $productitem->product->sell_price)  * $productitem->qty }}" 
												data-originprice="{{($productitem->product->is_variation == '1' && $productitem->product->variation) ? number_format($productitem->variation->sell_price,2) : number_format($productitem->product->sell_price, 2) }}">
												<label
												class="custom-control-label text-black font-GilroyBold font-22 pl-2 cart-checkbox-label"
												for="chx{{ Helper::encrypt($productitem->id) }}"></label>
											</div>
											<div class="d-flex flex-column flex-sm-row align-items-center prddetail">
												<div class="mr-sm-3">
													<a href="{{ route('productDetail',$product->slug) }}" >
														<img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{ $product->images[0]->thumb }}" class="img-fluid max-w-90px br-15 prd-image" alt="">
													</a>
												</div>
												
												<div class="mt-3 mt-sm-0">
													<h4 class="text-black font-GilroyBold font-18">{{$product->name}}</h4>
													@if($productitem->variation_id != 0)
													<div class="position-relative mt-2">
														<img src="{{ asset('assets/images/down arrow 24_24.png') }}" class="select-arrow"
														alt="">
														<select name="variation" class="form-control cus-filter font-GilroyMedium text-black-2 bg-filter2 border-0 variation" data-id="{{ Helper::encrypt($productitem->id) }}">
															@foreach($product->attributevariationprice as $variation)
															<option value="{{$variation->id}}" @if($productitem->variation_id == $variation->id) selected @endif @if(in_array($variation->id, $usedvariations)) disabled @endif>{{implode(' - ', $variation->variation) }}</option>
															@endforeach
														</select>
													</div>
													@endif
														<!-- <div class="mt-2">
															<img src="assets/images/ordering.png" class="img-fluid max-w-20px"
															alt="">
															<span class="text-black font-GilroySemiBold font-12 pl-2">Up to
																RM6.00
															of shipping for orders over RM40.00</span>
														</div> -->
													</div>
												</div>
											</div>
										</div>
										<div class="col-12 col-md-6 mt-3 mt-md-0">
											<div class="d-flex flex-column flex-md-row flex-wrap align-items-md-center justify-content-md-between pr-md-2 ml-4 pl-2 ml-md-0 pl-md-0">
												<div>
													<del class="text-light-gray font-16">RM{{($productitem->product->is_variation == '1' && $productitem->variation) ? number_format($productitem->variation->customer_price,2) : number_format($productitem->product->customer_price, 2) }}</del>
													<h1 class="text-orange font-22 font-GilroyBold">RM{{($productitem->product->is_variation == '1' && $productitem->variation) ? number_format($productitem->variation->sell_price,2) : number_format($productitem->product->sell_price, 2) }}</h1>
												</div>
												<div class="d-flex align-items-center mt-4 mt-md-0">
													<div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer minus" data-id="{{ Helper::encrypt($productitem->id) }}">
														<span class="text-gray fw-600 font-16 ">-</span>
													</div>
													<div class="text-gray font-16 mx-4 increment" id="{{ Helper::encrypt($productitem->id) }}">
														<input type="hidden" name="product_id" class="product_id" value="{{ Helper::encrypt($productitem->product_id) }}">
														<input type="hidden" name="qty" class="qty" value="{{$productitem->qty}}" data-id="{{ Helper::encrypt($productitem->product_id) }}">
														<span>{{$productitem->qty}}</span>
													</div>
													<div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer plus" data-id="{{ Helper::encrypt($productitem->id) }}">
														<span class="text-gray fw-600 font-16">+</span>
													</div>
												</div>
												<div class="mt-4 mt-md-0">
													<input type="hidden" name="cart_item[]" class="cartitem" value="{{ Helper::encrypt($productitem->id) }}">

													<a href="javascript:void(0)" class="text-gray font-14 font-GilroyMedium remove">{{trans('label.delete')}}</a>
													<a href="{{ route('searchfilter').'?search='.$product->name }}" class="text-orange font-12 font-GilroyMedium d-block"><u>{{trans('label.find_similar')}}</u></a>
												</div>
											</div>
										</div>
									</div>
									@endforeach
								</div>

								<div class="col-12 text-right pt-2">
									<a class="btn btn-green-seller font-GilroyMedium text-white font-14 py-1 rounded px-4 mr-md-2 contactseller" onclick="contactsell(this);"  data-id="{{App\Helpers\Helper::encrypt($item['seller_id'])}}">{{trans('label.contact_seller')}}</a>
								</div>
							</div>
							@endforeach
						</div>
						<div class="col-12 col-xl-4 mt-4 mt-xl-0">
							<div class="row mx-0 br-15 bg-white p-3 py-4 p-xl-4 shadow overflow-hidden">
								<div class="col-12 py-2">
									<div class="row">
										<div class="col-12 shippingData">
											<h4 class="text-medium-gray font-GilroyBold font-18">{{trans('label.shipping')}}</h4>

											<div class="mt-3">
												<?php 
												$fulladdress = '';
												if(Auth::user()->role_id == '7'){
													$fulladdress = ($defaultaddress) ? implode(", ", array_filter([$defaultaddress->defaultaddress_line1, $defaultaddress->defaultaddress_line2, $defaultaddress->town, $defaultaddress->state, $defaultaddress->country, $defaultaddress->postal_code])) : '' ;
												}
												?>
												<p class="text-medium-gray font-GilroyMedium font-14 mb-0">{{trans('label.shipping_to')}}</p>
												<h4 class="text-black font-GilroyBold font-14" id="default-address">{{$fulladdress}}</h4>
											</div>

											<hr class="mt-4" />

											<h4 class="text-medium-gray font-GilroyBold font-18 mt-3">{{trans('label.order_summary')}}</h4>

											<div class="d-flex align-items-center justify-content-between">
												<div>
													<p class="text-medium-gray font-GilroyMedium font-14 mb-0">{{trans('label.subtotal')}}</p>
													<h4 class="text-black font-GilroyBold font-14" id="totalitems">0 {{trans('label.item')}}</h4>
												</div>
												<h4 class="text-black font-GilroyBold font-14 subtotal">RM{{number_format($sub_total,2) }}</h4>
											</div>
											<input type="hidden" name="voucher_id" id="voucher_id">
											<div class="d-flex align-items-center justify-content-between discount-div" >
												<div class="discount-div" id="discount-div" style="display:none">
													<p class="text-medium-gray font-GilroyMedium font-14 mb-0">{{trans('label.discount')}}</p>
												</div>
												<input type="hidden" name="discount-data" id="discount-data">
												<h4 class="text-black font-GilroyBold font-14 discount-div discount-value" id="discount-value"></h4>
											</div>
											<div class="d-flex align-items-center justify-content-between cashback-div" >
												<div class="cashback-div" id="cashback-div" style="display:none">
													<p class="text-medium-gray font-GilroyMedium font-14 mb-0">{{trans('label.coins_cashback')}}</p>
												</div>
												<h4 class="text-black font-GilroyBold font-14 cashback-div cashback-value" id="cashback-value"></h4>
											</div>
											@if($cartContainBundleProduct == 'true')
											<div class="d-flex align-items-center justify-content-between">
												<div>
													<p class="text-medium-gray font-GilroyMedium font-14 mb-0">{{trans('label.bundle_discount')}}</p>
												</div>
												<h4 class="text-black font-GilroyBold font-14" id="bundleDiscount">{{$bundleDiscount}}</h4>
											</div>
											@endif
											<div class="d-flex custom-control custom-checkbox searchFilter-checkbox">
												<input type="checkbox" class="custom-control-input" id="Maxshop">
												<label class="custom-control-label text-medium-gray font-GilroyMedium font-14 pl-2" for="Maxshop"> 
													<img src="assets/images/dollor-orange.png" class="img-fluid max-w-14px mr-2" alt=""> {{trans('label.maxshop_coins')}}
												</label>
												<input type="hidden" name="usedCoins" id="usedCoins">
												<input type="hidden" name="usedRM" id="usedRM">
												<input type="hidden" name="coins" id="coins">
												<input type="hidden" name="coinsToRM" id="coinsToRM">
												<h4 class="text-black font-GilroyBold font-14 ml-auto" id="maxshop-coins"></h4>
											</div>
									<!-- <div class="text-right">
										<a href="#"
										class="text-light-blue ml-2 font-GilroyMedium font-14"><u>Change</u></a>
									</div> -->

									<hr class="mt-0" />

									<div class="d-flex align-items-center justify-content-between">
										<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Total</p>
										<input type="hidden" value="{{ $cartContainBundleProduct == 'true' ? number_format(($sub_total - $bundleDiscount), 2) : number_format($sub_total,2) }}" id="total">
										<h4 class="text-orange font-GilroyBold font-18 subtotal" id="total-text">RM{{ $cartContainBundleProduct == 'true' ? number_format(($sub_total - $bundleDiscount), 2) : number_format($sub_total,2) }}</h4>
									</div>
									@if(Auth::user()->role_id != '7')
									<div class="d-flex align-items-center justify-content-between">
										<p class="text-medium-gray font-GilroyMedium font-14 mb-0">{{trans('label.order_for')}}</p>
										<select required name="orderFor" class="form-control font-GilroyBold text-gray bg-filter border-0" id="orderFor" style="width: auto;">
											<option value="">Select</option>
											<option value="customer">{{trans('label.customer')}}</option>
											<option value="self">{{trans('label.self')}}</option>
										</select>
									</div>
									@endif
									<div class="mt-4">
										<button id="checkout" class="btn btn-block bg-orange orange-btn text-white font-14 rounded px-5 mt-3 font-GilroySemiBold" disabled>{{trans('label.proceed_to_checkout')}}</button>
									</div>
									<div id="product-voucher">

									</div>
									<!-- @if($productVouchers && count($productVouchers) > 0)
										<div class="text-center mt-3">
											<div class="col-12 text-left pt-2">
												@if(count($cartitem) > 0)
													<a href="javascript:void(0)" class="btn-coupon text-light-blue ml-2 font-GilroyMedium font-14 toggle" data-id="{{$item['seller_id']}}" style="color: #007bff">Select Code</a>
													<br>
													<div class="coupon-list{{$item['seller_id']}}" style="display:none">
														<div class ="row">
															@foreach($productVouchers as $voucher)
															<div class="col-xl-12 mt-4">
																<div class="row align-items-center h-100 mx-0">
																	<div
																	class="col-3 col-xl-4 bg-orange p-3 h-100 d-flex align-items-center justify-content-center vouncher-galore1">
																	<p class="font-GilroyBold text-white text-center font-16 text-uppercase mb-0">{{substr($voucher->code, 0, 10)}}<br>{{substr($voucher->code, 10)}}</p>
																</div>
																<div class="col-9 col-xl-8 border-vouncher-galore vouncher-galore2">
																	<div class="p-3 vouncher-galore3">
																		<p class="font-GilroyBold text-black font-14 mb-0">{{$voucher->name}}</p>
																		<p class="font-GilroyMedium text-gray font-8 mb-0">Valid Till {{date("d M", strtotime($voucher->to_date))}}</p>
																		<p class="font-GilroyBold text-black font-14 mb-0">Min. Spend RM{{$voucher->min_basket_price}}</p>
																		<div class="d-flex justify-content-between align-items-end">
																			<a href="javascript:void(0)" data-id="{{$voucher->id}}" class="btn bg-orange orange-btn text-white font-14 rounded-1 px-4 py-1 font-GilroyMedium mt-2 redeem redeem-button">Redeem</a>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														@endforeach
													</div>
												@endif
											</div>
										</div>
										@endif -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</form>
			@if(count($sameSellerProducts) > 0 || count($categoryProducts) > 0)
			<div class="row mt-4 bg-white br-15 p-3 pt-md-5 mx-0 shadow">
				@if(count($sameSellerProducts) > 0)
				<div class="col-12">
					<p class="text-gray font-GilroySemiBold">{{trans('label.from_the_same_shop')}}</p>
				</div>
				@include('frontend.categoryproducts',['categoryProducts'=>$sameSellerProducts])
				@endif
				@if(count($categoryProducts) > 0)
				<div class="col-12 mt-4">
					<p class="text-gray font-GilroySemiBold">{{trans('label.you_may_also_like')}}</p>
				</div>
				@include('frontend.categoryproducts')
				@endif
			</div>
			@endif
		</div>
	</div>
</section>
@endsection
@section('script')
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var deleteurl         = "{{ route('removecartproduct') }}";
	var movetowishlist    = "{{ route('movetowishlist') }}";
	var updatecarturl     = "{{ route('updatecart') }}";
	var addvoucherurl     = "{{ route('addvoucherurl') }}";
	var checkcoin  	      = "{{ route('checkcoin') }}";
	var getproductvoucher = "{{ route('getproductvoucher') }}";

	$(document).on('click', '.toggle', function (e) {
		$('.coupon-list').toggle('slow');
	});	
	$(document).on('change', '#orderFor', function() {
		var type = $('#orderFor').find(":selected").val();

		$.ajax({
			type: 'PUT',
			url: "{{ route('getuseraddress') }}",
			data: {
				'type': type,
			},
			success: function (response) {
				if(response.address && response.address != ''){
					address = (response.address.address_line1) + ', ' + (response.address.address_line2) + ', ' + (response.address.town) + ', ' + (response.address.state) + ', ' + (response.address.country) + ', ' + (response.address.postal_code);
					$('#default-address').html(address);
				}
			}
		});
	});	
</script>
<script src="{{ asset('assets/js/cart.js').'?v='.time() }}"></script>


@endsection
