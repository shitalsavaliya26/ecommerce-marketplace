@extends('layouts.app')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
		<div class="mr-auto">
			<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
				<li class="m-nav__item m-nav__item--home">
					<a href="{{ url('/')}}" class="m-nav__link m-nav__link--icon">
						<i class="m-nav__link-icon la la-home"></i>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="{{ route('products') }}" class="m-nav__link">
						<span class="m-nav__link-text">Products</span>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="" class="m-nav__link">
						<span class="m-nav__link-text">Add product</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- END: Subheader -->
<div class="m-content">
	<div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Add product
					</h3>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="m-portlet__body">
				<div class="m-wizard m-wizard--5 m-wizard--warning" id="m_wizard">
					<!--begin: Message container -->
					<div class="m-portlet__padding-x">
						<!-- Here you can put a message or alert -->
					</div>
					<!--end: Message container -->
					<!--begin: Form Wizard Head -->
					<div class="m-wizard__head m-portlet__padding-x" style="    margin-top: -31px;">
						<div class="row">
							<div class="col-xl-12 ">
								<!--begin: Form Wizard Nav -->
								<div class="m-wizard__nav">
									<div class="m-wizard__steps">
										<div class="m-wizard__step m-wizard__step--current" m-wizard-target="m_wizard_form_step_1" style="padding-bottom: 10px; !important">
											<div class="m-wizard__step-info">
												<a href="#" class="m-wizard__step-number">
													<span class="m-wizard__step-label">
														Product information
													</span>
													<span class="m-wizard__step-icon"><i class="la la-check"></i></span>
												</a>
											</div>
										</div>
										<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2" style="padding-bottom: 10px; !important">
											<div class="m-wizard__step-info">
												<a href="#" class="m-wizard__step-number">
													<span class="m-wizard__step-seq"></span>
													<span class="m-wizard__step-label">
														Chinese
													</span>
													<span class="m-wizard__step-icon"><i class="la la-check"></i></span>
												</a>
											</div>
										</div>
										<div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3" style="padding-bottom: 10px; !important">
											<div class="m-wizard__step-info">
												<a href="#" class="m-wizard__step-number">
													<span class="m-wizard__step-seq">3.</span>
													<span class="m-wizard__step-label">
														Malay
													</span>
													<span class="m-wizard__step-icon"><i class="la la-check"></i></span>
												</a>
											</div>
										</div>
									</div>
								</div>

								<!--end: Form Wizard Nav -->
							</div>
						</div>
					</div>

					<!--end: Form Wizard Head -->

					<!--begin: Form Wizard Form-->
					<div class="m-wizard__form">
						<form class="m-form m-form--label-align-left- m-form--state-" id="m_form">
							<!--begin: Form Body -->
							<div class="m-portlet__body">
								<!--begin: Form Wizard Step 1-->
								<div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
									<div class="row">
										<div class="col-lg-12">
											<div class="m-form__section m-form__section--first">
												<div class="form-group m-form__group row">
													<div class="col-lg-12 form-group m-form__group ">
													</div>
													<div class="col-lg-4 form-group m-form__group">
														<label for="name" >Product name</label>
														<div class="m-input-icon m-input-icon--right">
															<input type="text" class="form-control m-input" id="name" name="name" placeholder="Enter product name"  value="{{ old('name') }}"autofocus >
															@if ($errors->has('name'))
															<span class="helpBlock">
																<strong>{{ $errors->first('name') }}</strong>
															</span>
															@endif
														</div>
													</div>
													<div class="col-lg-4 form-group m-form__group ">
														<label for="sku">SKU code </label>
														<div class="m-input-icon m-input-icon--right">
															<input type="text" class="form-control m-input"  id="sku" name="sku" placeholder="Enter sku code"  value="{{ old('sku') }}" autofocus >
															@if ($errors->has('sku'))
															<span class="helpBlock">
																<strong>{{ $errors->first('sku') }}</strong>
															</span>
															@endif
														</div>
													</div>
													<div class="col-lg-4 form-group m-form__group ">
														<label for="qty">Quantity </label>
														<div class="m-input-icon m-input-icon--right">
															<input type="text" class="form-control m-input" id="qty" name="qty" placeholder="Enter quantity"  value="{{ old('qty') }}"  min="1" autofocus >
															@if ($errors->has('qty'))
															<span class="helpBlock">
																<strong>{{ $errors->first('qty') }}</strong>
															</span>
															@endif
														</div>
													</div>
												</div>
												<div class="form-group m-form__group row">
													<div class="col-lg-12 form-group m-form__group ">
														<label for="description">Description </label>
														<div class="m-input-icon m-input-icon--right">
															<textarea type="text" class="form-control m-input txarea-height " id="description"  name="description" placeholder="Enter description" autofocus>{{ old('description') }} </textarea>
															@if ($errors->has('description'))
															<span class="helpBlock">
																<strong>{{ $errors->first('description') }}</strong>
															</span>
															@endif
														</div>
													</div>
												</div>
												<div class="form-group m-form__group row">
													<div class="col-lg-12 form-group m-form__group ">
													</div>
													<div class="col-lg-6 form-group m-form__group ">
														<label for="weight">Product weight (KG)</label>
														<div class="m-input-icon m-input-icon--right">
															<input type="text" class="form-control m-input" id="weight" name="weight" placeholder="Enter weight"  value="{{ old('weight') }}"  autofocus >
															@if ($errors->has('weight'))
															<span class="helpBlock">
																<strong>{{ $errors->first('weight') }}</strong>
															</span>
															@endif
														</div>
													</div>
													<div class="col-lg-6 form-group m-form__group ">
														<label for="length">Product dimension (length * width * height)</label>
														<div class="m-input-icon m-input-icon--right">
															<div class="row">
																<div class="col-lg-4">
																	<input type="text" class="form-control m-input" id="length" name="length" placeholder="Length"  value="{{ old('length') }}"  autofocus >
																	@if ($errors->has('length'))
																	<span class="helpBlock">
																		<strong>{{ $errors->first('length') }}</strong>
																	</span>
																	@endif
																</div>

																<div class="col-lg-4">
																	<input type="text" class="form-control m-input" id="width" name="width" placeholder="Width"  value="{{ old('width') }}"  autofocus>
																	@if ($errors->has('width'))
																	<span class="helpBlock">
																		<strong>{{ $errors->first('width') }}</strong>
																	</span>
																	@endif
																</div>

																<div class="col-lg-4">
																	<input type="text" class="form-control m-input" id="pheight" name="pheight" placeholder="Height"  value="{{ old('pheight') }}"  autofocus>
																	@if ($errors->has('pheight'))
																	<span class="helpBlock">
																		<strong>{{ $errors->first('pheight') }}</strong>
																	</span>
																	@endif
																</div>


															</div>

														</div>
													</div>
												</div>
												<div class="form-group m-form__group row">
													<div class="col-lg-12 form-group m-form__group ">
													</br>
													<h5>Price tire </h5>
												</div>
												<div class="col-lg-4 form-group m-form__group ">
													<label for="customer_price">Customer</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control m-input" id="customer_price" name="customer_price" placeholder="Enter customer price"  value="{{ old('customer_price') }}" min="1" autofocus >

														@if ($errors->has('customer_price'))
														<span class="helpBlock">
															<strong>{{ $errors->first('customer_price') }}</strong>
														</span>
														@endif
													</div>
												</div>
												<div class="col-lg-4 form-group m-form__group ">
													<label for="ex_price">Executive</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control m-input" id="ex_price" name="ex_price" placeholder="Enter executive price"  value="{{ old('ex_price') }}"  min="1" autofocus >
														@if ($errors->has('ex_price'))
														<span class="helpBlock">
															<strong>{{ $errors->first('ex_price') }}</strong>
														</span>
														@endif
													</div>
												</div>
												<div class="col-lg-4 form-group m-form__group ">
													<label for="si_price" >Silver</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control m-input" id="si_price" name="si_price" placeholder="Enter silver price"  value="{{ old('si_price') }}" min="1" autofocus >
														@if ($errors->has('si_price'))
														<span class="helpBlock">
															<strong>{{ $errors->first('si_price') }}</strong>
														</span>
														@endif
													</div>
												</div>
												<div class="col-lg-4 form-group m-form__group ">
													<label for="go_price">Gold</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control m-input" id="go_price" name="go_price" placeholder="Enter gold price"  value="{{ old('go_price') }}"  min="1" autofocus >
														@if ($errors->has('go_price'))
														<span class="helpBlock">
															<strong>{{ $errors->first('go_price') }}</strong>
														</span>
														@endif
													</div>
												</div>
												<div class="col-lg-4 form-group m-form__group ">
													<label for="pl_price">Platinum</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control m-input" id="pl_price" name="pl_price" placeholder="Enter platinum price"  value="{{ old('pl_price') }}" min="1" autofocus >
														@if ($errors->has('pl_price'))
														<span class="helpBlock">
															<strong>{{ $errors->first('pl_price') }}</strong>
														</span>
														@endif
													</div>
												</div>
												<div class="col-lg-4 form-group m-form__group ">
													<label for="di_price">Diamond</label>
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text">RM</span>
														</div>
														<input type="text" class="form-control m-input" id="di_price" name="di_price" placeholder="Enter diamon price"  value="{{ old('di_price') }}" min="1" autofocus >
														@if ($errors->has('di_price'))
														<span class="helpBlock">
															<strong>{{ $errors->first('di_price') }}</strong>
														</span>
														@endif
													</div>
												</div>
											</div>	
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-3">
												<br/><br/><br/>
												<label class="col-form-label">Product gallery</label>
											</div>
											<div class="col-lg-9 col-md-9 col-sm-12">
												<div class="m-dropzone dropzone m-dropzone--primary" action="{{ route('product_upload') }}" id="m-dropzone-two">
													{{ csrf_field() }}
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<div class="m-dropzone__msg dz-message needsclick">
														<h3 class="m-dropzone__msg-title">Drop image here</h3>
														<span class="m-dropzone__msg-desc">Allowed only image files</span>
													</div>
												</div>
											</div>
										</div>	
										<div class="form-group m-form__group row">
											<div class="col-lg-3">
												<label class="col-form-label"></label>
											</div>
											<div class="col-lg-6">
												<div class="m-checkbox-inline">
													<label class="m-checkbox">
														<input type="checkbox" value="true" name="is_new"> New arrival
														<span></span>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 1-->

						<!--begin: Form Wizard Step 2-->
						<div class="m-wizard__form-step" id="m_wizard_form_step_2">
							<div class="row">
								<div class="col-xl-10 offset-xl-1">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">Account Details</h3>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label class="form-control-label">* URL:</label>
												<input type="url" name="account_url" class="form-control m-input" placeholder="" value="http://sinortech.vertoffice.com">
												<span class="m-form__help">Please enter your preferred URL to your dashboard</span>
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6 m-form__group-sub">
												<label class="form-control-label">* Username:</label>
												<input type="text" name="account_username" class="form-control m-input" placeholder="" value="nick.stone">
												<span class="m-form__help">Your username to login to your dashboard</span>
											</div>
											<div class="col-lg-6 m-form__group-sub">
												<label class="form-control-label">* Password:</label>
												<input type="password" name="account_password" class="form-control m-input" placeholder="" value="qwerty">
												<span class="m-form__help">Please use letters and at least one number and symbol</span>
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">Client Settings</h3>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-6 m-form__group-sub">
												<label class="form-control-label">* User Group:</label>
												<div class="m-radio-inline">
													<label class="m-radio m-radio--solid m-radio--brand">
														<input type="radio" name="account_group" checked="" value="2"> Sales Person
														<span></span>
													</label>
													<label class="m-radio m-radio--solid m-radio--brand">
														<input type="radio" name="account_group" value="2"> Customer
														<span></span>
													</label>
												</div>
												<span class="m-form__help">Please select user group</span>
											</div>
											<div class="col-lg-6 m-form__group-sub">
												<label class="form-control-label">* Communications:</label>
												<div class="m-checkbox-inline">
													<label class="m-checkbox m-checkbox--solid m-checkbox--brand">
														<input type="checkbox" name="account_communication[]" checked value="email"> Email
														<span></span>
													</label>
													<label class="m-checkbox m-checkbox--solid  m-checkbox--brand">
														<input type="checkbox" name="account_communication[]" value="sms"> SMS
														<span></span>
													</label>
													<label class="m-checkbox m-checkbox--solid  m-checkbox--brand">
														<input type="checkbox" name="account_communication[]" value="phone"> Phone
														<span></span>
													</label>
												</div>
												<span class="m-form__help">Please select user communication options</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 2-->

						<!--begin: Form Wizard Step 3-->
						<div class="m-wizard__form-step" id="m_wizard_form_step_3">
							<div class="row">
								<div class="col-xl-10 offset-xl-1">
									<div class="m-form__section m-form__section--first">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">Billing Information</h3>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label class="form-control-label">* Card Number:</label>
												<input type="text" name="billing_card_number" class="form-control m-input" placeholder="" value="372955886840581">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-4 m-form__group-sub">
												<label class="form-control-label">* Exp Month:</label>
												<select class="form-control m-input" name="billing_card_exp_month">
													<option value="">Select</option>
													<option value="01">01</option>
													<option value="02">02</option>
													<option value="03">03</option>
													<option value="04" selected>04</option>
													<option value="05">05</option>
													<option value="06">06</option>
													<option value="07">07</option>
													<option value="08">08</option>
													<option value="09">09</option>
													<option value="10">10</option>
													<option value="11">11</option>
													<option value="12">12</option>
												</select>
											</div>
											<div class="col-lg-4 m-form__group-sub">
												<label class="form-control-label">* Exp Year:</label>
												<select class="form-control m-input" name="billing_card_exp_year">
													<option value="">Select</option>
													<option value="2018">2018</option>
													<option value="2019">2019</option>
													<option value="2020">2020</option>
													<option value="2021" selected>2021</option>
													<option value="2022">2022</option>
													<option value="2023">2023</option>
													<option value="2024">2024</option>
												</select>
											</div>
											<div class="col-lg-4 m-form__group-sub">
												<label class="form-control-label">* CVV:</label>
												<input type="number" class="form-control m-input" name="billing_card_cvv" placeholder="" value="450">
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">Billing Address <i data-toggle="m-tooltip" data-width="auto" class="m-form__heading-help-icon flaticon-info" title="If different than the corresponding address"></i></h3>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label class="form-control-label">* Address 1:</label>
												<input type="text" name="billing_address_1" class="form-control m-input" placeholder="" value="Headquarters 1120 N Street Sacramento 916-654-5266">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-12">
												<label class="form-control-label">Address 2:</label>
												<input type="text" name="billing_address_2" class="form-control m-input" placeholder="" value="P.O. Box 942873 Sacramento, CA 94273-0001">
											</div>
										</div>
										<div class="form-group m-form__group row">
											<div class="col-lg-5 m-form__group-sub">
												<label class="form-control-label">* City:</label>
												<input type="text" class="form-control m-input" name="billing_city" placeholder="" value="Polo Alto">
											</div>
											<div class="col-lg-5 m-form__group-sub">
												<label class="form-control-label">* State:</label>
												<input type="text" class="form-control m-input" name="billing_state" placeholder="" value="California">
											</div>
											<div class="col-lg-2 m-form__group-sub">
												<label class="form-control-label">* ZIP:</label>
												<input type="text" class="form-control m-input" name="billing_zip" placeholder="" value="34890">
											</div>
										</div>
									</div>
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="m-form__section">
										<div class="m-form__heading">
											<h3 class="m-form__heading-title">Delivery Type</h3>
										</div>
										<div class="form-group m-form__group">
											<div class="row">
												<div class="col-lg-6">
													<label class="m-option">
														<span class="m-option__control">
															<span class="m-radio m-radio--state-brand">
																<input type="radio" name="billing_delivery" value="">
																<span></span>
															</span>
														</span>
														<span class="m-option__label">
															<span class="m-option__head">
																<span class="m-option__title">
																	Standart Delevery
																</span>
																<span class="m-option__focus">
																	Free
																</span>
															</span>
															<span class="m-option__body">
																Estimated 14-20 Day Shipping
																(&nbsp;Duties end taxes may be due
																upon delivery&nbsp;)
															</span>
														</span>
													</label>
												</div>
												<div class="col-lg-6">
													<label class="m-option">
														<span class="m-option__control">
															<span class="m-radio m-radio--state-brand">
																<input type="radio" name="billing_delivery" value="">
																<span></span>
															</span>
														</span>
														<span class="m-option__label">
															<span class="m-option__head">
																<span class="m-option__title">
																	Fast Delevery
																</span>
																<span class="m-option__focus">
																	$&nbsp;8.00
																</span>
															</span>
															<span class="m-option__body">
																Estimated 2-5 Day Shipping
																(&nbsp;Duties end taxes may be due
																upon delivery&nbsp;)
															</span>
														</span>
													</label>
												</div>
											</div>
											<div class="m-form__help">

												<!--must use this helper element to display error message for the options-->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 3-->

						<!--begin: Form Wizard Step 4-->
						<div class="m-wizard__form-step" id="m_wizard_form_step_4">
							<div class="row">
								<div class="col-xl-10 offset-xl-1">

									<!--begin::Section-->
									<div class="m-accordion m-accordion--default" id="m_accordion_1" role="tablist">

										<!--begin::Item-->
										<div class="m-accordion__item active">
											<div class="m-accordion__item-head" role="tab" id="m_accordion_1_item_1_head" data-toggle="collapse" href="#m_accordion_1_item_1_body" aria-expanded="  false">
												<span class="m-accordion__item-icon"><i class="fa flaticon-user-ok"></i></span>
												<span class="m-accordion__item-title">1. Client Information</span>
												<span class="m-accordion__item-mode"></span>
											</div>
											<div class="m-accordion__item-body collapse show" id="m_accordion_1_item_1_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_1_head" data-parent="#m_accordion_1">

												<!--begin::Content-->
												<div class="tab-content  m--padding-30">
													<div class="m-form__section m-form__section--first">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title">Account Details</h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">URL:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">sinortech.vertoffice.com</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Username:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">sinortech.admin</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Password:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">*********</span>
															</div>
														</div>
													</div>
													<div class="m-separator m-separator--dashed m-separator--lg"></div>
													<div class="m-form__section">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title">Client Settings</h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">User Group:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Customer</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Communications:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Phone, Email</span>
															</div>
														</div>
													</div>
												</div>

												<!--end::Content-->
											</div>
										</div>

										<!--end::Item-->

										<!--begin::Item-->
										<div class="m-accordion__item">
											<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_2_head" data-toggle="collapse" href="#m_accordion_1_item_2_body" aria-expanded="    false">
												<span class="m-accordion__item-icon"><i class="fa  flaticon-placeholder"></i></span>
												<span class="m-accordion__item-title">2. Account Setup</span>
												<span class="m-accordion__item-mode"></span>
											</div>
											<div class="m-accordion__item-body collapse" id="m_accordion_1_item_2_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_2_head" data-parent="#m_accordion_1">

												<!--begin::Content-->
												<div class="tab-content  m--padding-30">
													<div class="m-form__section m-form__section--first">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title">Account Details</h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">URL:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">sinortech.vertoffice.com</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Username:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">sinortech.admin</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Password:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">*********</span>
															</div>
														</div>
													</div>
													<div class="m-separator m-separator--dashed m-separator--lg"></div>
													<div class="m-form__section">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title">Client Settings</h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">User Group:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Customer</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Communications:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Phone, Email</span>
															</div>
														</div>
													</div>
												</div>

												<!--end::Content-->
											</div>
										</div>

										<!--end::Item-->

										<!--begin::Item-->
										<div class="m-accordion__item">
											<div class="m-accordion__item-head collapsed" role="tab" id="m_accordion_1_item_3_head" data-toggle="collapse" href="#m_accordion_1_item_3_body" aria-expanded="    false">
												<span class="m-accordion__item-icon"><i class="fa  flaticon-alert-2"></i></span>
												<span class="m-accordion__item-title">3. Billing Setup</span>
												<span class="m-accordion__item-mode"></span>
											</div>
											<div class="m-accordion__item-body collapse" id="m_accordion_1_item_3_body" class=" " role="tabpanel" aria-labelledby="m_accordion_1_item_3_head" data-parent="#m_accordion_1">
												<div class="tab-content  m--padding-30">
													<div class="m-form__section m-form__section--first">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title">Billing Information</h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Cardholder Name:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Nick Stone</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Card Number:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">*************4589</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Exp Month:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">10</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Exp Year:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">2018</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">CVV:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">***</span>
															</div>
														</div>
													</div>
													<div class="m-separator m-separator--dashed m-separator--lg"></div>
													<div class="m-form__section">
														<div class="m-form__heading">
															<h4 class="m-form__heading-title">Billing Address</h4>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Address Line 1:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Headquarters 1120 N Street Sacramento 916-654-5266</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Address Line 2:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">P.O. Box 942873 Sacramento, CA 94273-0001</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">City:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">Polo Alto</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">State:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">California</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">ZIP:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">37505</span>
															</div>
														</div>
														<div class="form-group m-form__group m-form__group--sm row">
															<label class="col-xl-4 col-lg-4 col-form-label">Country:</label>
															<div class="col-xl-8 col-lg-8">
																<span class="m-form__control-static">USA</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<!--end::Item-->
									</div>

									<!--end::Section-->
									<div class="m-separator m-separator--dashed m-separator--lg"></div>
									<div class="form-group m-form__group m-form__group--sm row">
										<div class="col-xl-12">
											<div class="m-checkbox-inline">
												<label class="m-checkbox m-checkbox--solid m-checkbox--brand">
													<input type="checkbox" name="accept" value="1">
													Click here to indicate that you have read and agree to the terms presented in the Terms and Conditions agreement
													<span></span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!--end: Form Wizard Step 4-->
					</div>

					<!--end: Form Body -->

					<!--begin: Form Actions -->
					<div class="">
						<div class="m-form__actions m-form__actions">
							<div class="row">
								<div class="col-lg-1"></div>
								<div class="col-lg-4 m--align-left">
									<a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon" data-wizard-action="prev">
										<span>
											<i class="la la-arrow-left"></i>&nbsp;&nbsp;
											<span>Back</span>
										</span>
									</a>
								</div>
								<div class="col-lg-6 m--align-right">
									<a href="#" class="btn btn-primary m-btn m-btn--custom" data-wizard-action="submit">
										<span>
											<i class="la la-check"></i>&nbsp;&nbsp;
											<span>Submit</span>
										</span>
									</a>
									<a href="#"  class="btn btn-primary btn-send-request font12" data-wizard-action="next">
										<span>
											<span >Next</span>&nbsp;&nbsp;
										</span>
									</a>
								</div>
								<div class="col-lg-1"></div>
							</div>
						</div>
					</div>

					<!--end: Form Actions -->
				</form>
			</div>

			<!--end: Form Wizard Form-->
		</div>

		<!--end: Form Wizard-->
	</div>
</div>
</div>
<script type="text/javascript">
	//== Class definition
	var WizardDemo = function () {
    //== Base elements
    var wizardEl = $('#m_wizard');
    var formEl = $('#m_form');
    var validator;
    var wizard;
    
    //== Private functions
    var initWizard = function () {
        //== Initialize form wizard
        wizard = new mWizard('m_wizard', {
        	startStep: 1
        });

        //== Validation before going to next page
        wizard.on('beforeNext', function(wizardObj) {
        	if (validator.form() !== true) {
                wizardObj.stop();  // don't go to the next step
            }
        })

        //== Change event
        wizard.on('change', function(wizard) {
        	mUtil.scrollTop();            
        });

        //== Change event
        wizard.on('change', function(wizard) {
        	if (wizard.getStep() === 1) {
        	}           
        });
    }

    var initValidation = function() {
    	validator = formEl.validate({
            //== Validate only visible fields
            ignore: ":hidden",

            //== Validation rules
            rules: {
               name: {
									required: true,
									maxlength: 30, 
								},
								sku: {
									required: true,
									maxlength: 20,
								},
								description: {
									required: true
								},
								qty: {
									required: true,
									number: true,
									maxlength: 30,
								},
								customer_price: {
									required: true,
									number: true, 
									maxlength: 30,
								},
								ex_price: {
									required: true,
									number: true,
									maxlength: 30,
								},
								go_price: {
									required: true,
									number: true,
									maxlength: 30,
								},
								si_price: {
									required: true,
									number: true,
									maxlength: 30,
								},
								pl_price: {
									required: true,
									number: true,
									maxlength: 30,
								},
								di_price: {
									required: true,
									number: true,
									maxlength: 30,
								},
								length: {
									required: true,
									min:0,
									maxlength: 30,
								},
								width: {
									required: true,
									min:0,
									maxlength: 30,
								},
								pheight: {
									required: true,
									min:0,
									maxlength: 30,
								},
								weight: {
									required: true,
									min:0,
									number: true,
									maxlength: 30,
								},

                //=== Client Information(step 2)
                //== Account Details
                account_url: {
                	required: true,
                	url: true
                },
                account_username: {
                	required: true,
                	minlength: 4
                },
                account_password: {
                	required: true,
                	minlength: 6
                },                

                //== Client Settings
                account_group: {
                	required: true
                },                
                'account_communication[]': {
                	required: true
                },

                //=== Client Information(step 3)
                //== Billing Information
                billing_card_name: {
                	required: true
                },
                billing_card_number: {
                	required: true,
                	creditcard: true
                },
                billing_card_exp_month: {
                	required: true
                },
                billing_card_exp_year: {
                	required: true
                },
                billing_card_cvv: {
                	required: true,
                	minlength: 2,
                	maxlength: 3
                },

                //== Billing Address
                billing_address_1: {
                	required: true
                },
                billing_address_2: {

                },
                billing_city: {
                	required: true
                },
                billing_state: {
                	required: true
                },
                billing_zip: {
                	required: true,
                	number: true
                },
                billing_delivery: {
                	required: true
                },

                //=== Confirmation(step 4)
                accept: {
                	required: true
                }
            },

            //== Validation messages
            messages: {
            	'account_communication[]': {
            		required: 'You must select at least one communication option'
            	},
            	accept: {
            		required: "You must accept the Terms and Conditions agreement!"
            	} 
            },
            
            //== Display error  
            invalidHandler: function(event, validator) {     
            	mUtil.scrollTop();
            },

            //== Submit valid form
            submitHandler: function (form) {

            }
        });   
    }

    var initSubmit = function() {
    	var btn = formEl.find('[data-wizard-action="submit"]');

    	btn.on('click', function(e) {
    		e.preventDefault();

    		if (validator.form()) {
                //== See: src\js\framework\base\app.js
                mApp.progress(btn);
                //mApp.block(formEl); 

                //== See: http://malsup.com/jquery/form/#ajaxSubmit
                formEl.ajaxSubmit({
                	success: function() {
                		mApp.unprogress(btn);
                        //mApp.unblock(formEl);

                        swal({
                        	"title": "", 
                        	"text": "The application has been successfully submitted!", 
                        	"type": "success",
                        	"confirmButtonClass": "btn btn-secondary m-btn m-btn--wide"
                        });
                    }
                });
            }
        });
    }

    return {
        // public functions
        init: function() {
        	wizardEl = $('#m_wizard');
        	formEl = $('#m_form');

        	initWizard(); 
        	initValidation();
        	initSubmit();
        }
    };
}();

jQuery(document).ready(function() {    
	WizardDemo.init();
});
</script>
@endsection
