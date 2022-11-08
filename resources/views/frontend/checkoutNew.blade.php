@extends('layouts.main')
@section('title', 'Checkout')
@section('content')

<section class="bg-gray pt-4 pb-5">
	<div class="container">
		<div class="row">
			<div class="col-12 col-lg-8">
				<div class="row mx-0 br-15 bg-white p-3 py-4 shadow overflow-hidden">
					<div class="col-12 py-2">
						<div class="row">
							<div class="col-12">
								<h4 class="text-black font-GilroyBold font-18">Shipping</h4>

								<div class="mt-3">
									<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Shipping To</p>
									<div class="d-flex align-items-center">
										<h4 class="text-black font-GilroyBold font-14 mb-0">Petaling Jaya, Selangor
										</h4>
										<a href="#"
											class="text-light-blue ml-2 font-GilroyMedium font-14 ml-5"><u>Change</u></a>
									</div>
								</div>

								<hr class="mt-4" />

								<h4 class="text-black font-GilroyBold font-18 mt-3">Order Summary</h4>

								<div class="row">
									<div class="col-12 col-md-8">
										<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Product</p>
										<div class="d-flex flex-column flex-sm-row align-items-center mt-3">
											<div class="mr-sm-3">
												<img src="assets/images/image.png" class="img-fluid max-w-60px br-15"
													alt="">
											</div>
											<div class="mt-3 mt-sm-0">
												<h4 class="text-black font-GilroyBold font-16">
													Glenfarclas 21 Years
													(700mL) <span class="ml-5">1X</span>
												</h4>
												<button
													class="btn btn-green-seller font-GilroyMedium text-white font-12 py-1 rounded px-3">Chat
													Now
												</button>
											</div>
										</div>
									</div>
									<div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
										<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Subtotal</p>
										<h4 class="text-black font-GilroyBold font-16 mt-3">RM222.03</h4>
									</div>
								</div>

								<div class="row align-items-center mt-3 pb-3">
									<div class="col-auto pr-0">
										<span class="text-medium-gray font-14 font-GilroyMedium">Messages:</span>
									</div>
									<div class="col-8 col-sm-10">
										<div class="form-group mb-0">
											<div class="from-inner-space">
												<input class="form-control font-14 h-auto py-3" type="text"
													placeholder="(Optional) Leave a message to seller">
											</div>
										</div>
									</div>
								</div>

								<hr class="mt-4" />

								<div class="row">
									<div class="col-8">
										<div class="custom-control custom-checkbox searchFilter-checkbox">
											<input type="checkbox" class="custom-control-input" id="Maxshop2">
											<label
												class="custom-control-label text-black font-GilroyMedium font-14 pl-2"
												for="Maxshop2"> <img src="assets/images/dollor-orange.png"
													class="img-fluid max-w-20px mr-2" alt=""> Redeem 30
												Maxshop Coin</label>
										</div>
									</div>
									<div class="col-4 text-right">
										<h4 class="text-black font-GilroyBold font-14">[-RM 0.30]</h4>
									</div>
								</div>

								<hr class="mt-2" />

								<div class="row">
									<div class="col-8">
										<div class="custom-control custom-checkbox searchFilter-checkbox">
											<label class="text-black font-GilroyMedium font-14 pl-2">
												<img src="assets/images/sale.png" class="img-fluid max-w-20px mr-2"
													alt=""> Up to 12% of voucher available</label>
										</div>
									</div>
									<div class="col-4 text-right">
										<a href="#"
											class="text-light-blue ml-2 font-GilroyMedium font-14 ml-5"><u>Select
												Vouncher
											</u></a>
									</div>
								</div>

								<hr class="mt-2" />

								<div class="row">
									<div class="col-12">
										<p class="text-medium-gray font-GilroyMedium font-14 mb-0">Standard Delivery</p>
									</div>
									<div class="col-12 col-md-8">
										<p class="text-black font-GilroyBold font-14 mb-0">Receive by 30 Jul - 6 Aug</p>
									</div>
									<div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
										<h4 class="text-black font-GilroyBold font-14 mb-0">RM4.90</h4>
									</div>
								</div>

								<hr class="mt-4" />

								<div class="row justify-content-end">
									<div class="col-12 col-xl-8">
										<div class="row mt-3">
											<span class="col-8 text-right text-black font-16 font-GilroySemiBold">Total</span>
											<span class="col-4 text-right text-orange font-18 font-GilroyExtraBold">RM222.03</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row align-items-center bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden mt-4">
					<div class="col-12">
						<div class="row justify-content-end">
							<div class="col-12 col-xl-8">
								<div class="row mt-3">
									<span class="col-8 text-right text-black font-16 font-GilroySemiBold">Merchandise Subtotal:</span>
									<span class="col-4 text-right text-black font-14 font-GilroyBold">RM12.50</span>
								</div>
								<div class="row mt-3">
									<span class="col-8 text-right text-black font-16 font-GilroySemiBold">Shipping Total:</span>
									<span class="col-4 text-right text-black font-14 font-GilroyBold">RM4.90</span>
								</div>
								<div class="row mt-3">
									<span class="col-8 text-right text-black font-16 font-GilroySemiBold">Total Payment:</span>
									<span class="col-4 text-right text-orange font-18 font-GilroyExtraBold">RM222.03</span>
								</div>
							</div>
						</div>
					</div>

					<div class="col-12 mt-2">
						<hr>
					</div>
					<div class="col-12 mt-2 text-right">
						<button type="submit"
							class="btn bg-orange orange-btn text-white font-14 rounded px-4 py-1 font-GilroySemiBold">Place
							Order</button>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-4 mt-4 mt-lg-0">
				<div class="row bg-white mx-0 p-3 br-15 py-4 shadow overflow-hidden">
					<div class="col-12">
						<h4 class="text-black font-GilroyBold font-18">Payment Method</h4>
					</div>
					<div class="col-12">
						<div class="payment_radio_container">
							<input class="d-none" type="radio" name="radio" id="Cash" disabled>
							<label for="Cash">Cash on Delivery</label>
							<input class="d-none" type="radio" name="radio" id="Online" checked>
							<label for="Online">Online Banking</label>
							<input class="d-none" type="radio" name="radio" id="Maybank2u">
							<label for="Maybank2u">Maybank2u</label>
							<input class="d-none" type="radio" name="radio" id="Maxshop">
							<label for="Maxshop">Maxshop Pay</label>
							<input class="d-none" type="radio" name="radio" id="Credit">
							<label for="Credit">Credit/Debit Card</label>
						</div>
					</div>

					<div class="col-12 mt-2 mb-3">
						<hr />
					</div>

					<div class="col-12">
						<h4 class="text-black font-GilroyBold font-18">Select Payment
							Account</h4>
					</div>
					<div class="col-12 mt-3">
						<div class="custom-control custom-checkbox searchFilter-checkbox">
							<input type="checkbox" class="custom-control-input" id="CIMB" disabled>
							<label class="custom-control-label text-black font-GilroySemiBold font-14 pl-2"
								for="CIMB"><img src="assets/images/mastercard-1.png" class="img-fluid max-w-35px mr-2"
									alt=""> CIMB **** 1234</label>
							<span class="font-GilroySemiBold text-orange ml-3 font-12">Expired</span>
						</div>
						<div class="custom-control custom-checkbox searchFilter-checkbox mt-3">
							<input type="checkbox" class="custom-control-input" id="CIMB2">
							<label class="custom-control-label text-black font-GilroySemiBold font-14 pl-2"
								for="CIMB2"><img src="assets/images/mastercard-1.png" class="img-fluid max-w-35px mr-2"
									alt=""> CIMB **** 1234</label>
						</div>

						<div class="mt-4">
							<p class="text-medium-gray font-GilroyRegular font-14">I acknowledge that my card
								information is saved securely on my Maxshop account and One
								Time Password (OTP) might not be required for future transactions on Maxshop.</p>
						</div>

						<div class="mt-3">
							<button class="btn bg-orange orange-btn font-GilroySemiBold text-white font-12 px-4">+
								Pay
								With New Card</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection