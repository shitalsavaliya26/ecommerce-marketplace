<form action="{{route('changecart') }}" method="post" id="checkoutfrm">
	<div class="row">
		{{ csrf_field() }}
		<div class="col-12 col-xl-12">
			@if($cartitem && count($cartitem) > 0)
				<div class="row align-items-center bg-white mx-0 br-15 py-3 shadow overflow-hidden">
					<div class="col-12 col-md-8">
						<div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
							<input type="checkbox" class="custom-control-input" id="All">
							<label class="custom-control-label text-medium-gray font-GilroySemiBold font-16 pl-2"
							for="All">Select All Items ({{$totalitems}} Items)</label>
						</div>
					</div>
					<div class="col-12 col-md-4 mt-3 mt-md-0 position-relative">
						<img src="assets/images/down arrow 24_24.png" class="select-arrow" alt="">
						<select name="action" class="form-control cus-filter font-GilroyBold text-gray bg-filter border-0" id="action">
							<option>Select Action</option>
							<option value="delete">Delete</option>
							<option value="wishlist">Move to Wishlist</option>
						</select>
					</div>
				</div>
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
								<div>
									<img src="assets/images/sale.png" class="img-fluid max-w-14px" alt="">
									<span class="text-black font-GilroySemiBold font-12 pl-2">Up to 12% of voucher
									available</span>
								</div>
								<div class="ml-md-4">
									<img src="assets/images/dollor-orange.png" class="img-fluid max-w-14px" alt="">
									<span class="text-black font-GilroySemiBold font-12 pl-2">Coins Redeemable</span>
								</div>
							</div>
						</div>
						<div class="col-12 bg-gray-light pb-4 pt-2 my-2">
							@foreach($item['products'] as $productitem)
								<?php $product = $productitem->productdetails;  ?>
								<div class="row align-items-center mt-4">
									<div class="col-12 col-md-6">
										<div class="d-flex align-items-center">
											<div class="custom-control custom-checkbox searchFilter-checkbox pl-md-5">
												<input type="checkbox" name="prd[]" class="custom-control-input selleritem {{ Helper::encrypt($item['seller_id']) }}" value="{{ Helper::encrypt($productitem->id) }}" id="{{ Helper::encrypt($productitem->id) }}">
												<label
												class="custom-control-label text-black font-GilroyBold font-22 pl-2 cart-checkbox-label"
												for="{{ Helper::encrypt($productitem->id) }}"></label>
											</div>
											<div class="d-flex flex-column flex-sm-row align-items-center">
												<a href="{{ route('productDetail',$product->slug) }}" class="mr-sm-3">
													<img onerror="this.src='{{asset('images/product/product-placeholder.png') }}'" src="{{ $product->images[0]->thumb }}" class="img-fluid max-w-90px br-15 prd-image" alt="">
												</a>
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
													<div class="mt-2">
														<img src="assets/images/ordering.png" class="img-fluid max-w-20px"
														alt="">
														<span class="text-black font-GilroySemiBold font-12 pl-2">Up to
															RM6.00
														of shipping for orders over RM40.00</span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-6 mt-3 mt-md-0">
										<div class="d-flex flex-column flex-md-row flex-wrap align-items-md-center justify-content-md-between pr-md-2 ml-4 pl-2 ml-md-0 pl-md-0">
											<div>
												<del class="text-light-gray font-16">RM{{($productitem->variation_id != 0) ? $productitem->variation->sell_price : $product->sell_price}}</del>
												<h1 class="text-orange font-22 font-GilroyBold">RM{{($productitem->variation_id != 0) ? $productitem->variation->customer_price : $product->customer_price}}</h1>
											</div>
											<div class="d-flex align-items-center mt-4 mt-md-0">
												<div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer minus" data-id="{{ Helper::encrypt($productitem->id) }}">
													<span class="text-gray fw-600 font-16 ">-</span>
												</div>
												<div class="text-gray font-16 mx-4 increment" id="{{ Helper::encrypt($productitem->id) }}">
													<input type="hidden" name="product_id" class="product_id" value="{{ Helper::encrypt($productitem->product_id) }}">
													<input type="hidden" name="qty" class="qty" value="{{$productitem->qty}}">
													<span>{{$productitem->qty}}</span>
												</div>
												<div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer plus" data-id="{{ Helper::encrypt($productitem->id) }}">
													<span class="text-gray fw-600 font-16">+</span>
												</div>
											</div>
											<div class="mt-4 mt-md-0">
												<input type="hidden" name="cart_item[]" class="cartitem" value="{{ Helper::encrypt($productitem->id) }}">
												<a href="javascript:void(0)" class="text-gray font-14 font-GilroyMedium remove">Delete</a>
												<a href="{{ route('searchfilter').'?search='.$product->name }}" class="text-orange font-12 font-GilroyMedium d-block"><u>Find
												Similar</u></a>
											</div>
										</div>
									</div>
								</div>
							@endforeach
						</div>
						<!-- <div class="col-12 text-right pt-2">
							<button class="btn btn-green-seller font-GilroyMedium text-white font-14 py-1 rounded px-4 mr-md-2">Contact
							Seller</button>
						</div> -->
					</div>
				@endforeach
				<div class="row">
					<div class="col-12 col-lg-4 col-xl-4 mt-4">
					</div>
					<div class="col-12 col-lg-4 col-xl-4 mt-4">
						<button id="checkout" class="btn btn-block bg-orange orange-btn text-white font-14 rounded px-5 mt-3 font-GilroySemiBold" disabled>Proceed to Checkout</button>
					</div>
				</div>
			@else
				<div class="row align-items-center bg-white mx-0 br-15 py-3 shadow overflow-hidden">
					<div class="col-12">
						<div class="custom-control">
							<label class=" text-medium-gray font-GilroySemiBold font-16">No order found</label>
						</div>
					</div>
				</div>
			@endif
		</div>
		<!-- 	<div class="col-12 col-xl-4 mt-4 mt-xl-0">
		<div class="row mx-0 br-15 bg-white p-3 py-4 p-xl-4 shadow overflow-hidden">
			<div class="col-12 py-2">
				<div class="row">
					<div class="col-12">
						<h4 class="text-medium-gray font-GilroyBold font-18">Shipping</h4>

						<div class="mt-3">
							<?php 
							$fulladdress = implode(", ", array_filter([$defaultaddress->defaultaddress_line1, $defaultaddress->defaultaddress_line2, $defaultaddress->town, $defaultaddress->state, $defaultaddress->country, $defaultaddress->postal_code])) ;
							?>
							<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Shipping To</p>
							<h4 class="text-black font-GilroyBold font-14">{{$fulladdress}}</h4>
						</div>

						<hr class="mt-4" />

						<h4 class="text-medium-gray font-GilroyBold font-18 mt-3">Order Summary</h4>

						<div class="d-flex align-items-center justify-content-between">
							<div>
								<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Subtotal</p>
								<h4 class="text-black font-GilroyBold font-14">{{$totalitems}} Items</h4>
							</div>
							<h4 class="text-black font-GilroyBold font-14">RM{{number_format($sub_total,2) }}</h4>
						</div>

						<div class="custom-control custom-checkbox searchFilter-checkbox">
							<input type="checkbox" class="custom-control-input" id="Maxshop">
							<label class="custom-control-label text-medium-gray font-GilroyMedium font-14 pl-2" for="Maxshop"> 
								<img src="assets/images/dollor-orange.png" class="img-fluid max-w-14px mr-2" alt=""> Maxshop Coins
							</label>
						</div>
						<div class="text-right">
							<a href="#"
							class="text-light-blue ml-2 font-GilroyMedium font-14"><u>Change</u></a>
						</div>

						<hr class="mt-0" />

						<div class="d-flex align-items-center justify-content-between">
							<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Total</p>
							<h4 class="text-orange font-GilroyBold font-18">RM{{number_format($sub_total,2) }}</h4>
						</div>

						<div class="mt-4">
							<button id="checkout" class="btn btn-block bg-orange orange-btn text-white font-14 rounded px-5 mt-3 font-GilroySemiBold" disabled>Proceed to Checkout</button>
						</div>

						<div class="text-center mt-3">
							<a href="#" class="text-light-blue ml-2 font-GilroyMedium font-14"><u>Select Or Enter Code</u></a>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div> -->
	</div>
</form>
