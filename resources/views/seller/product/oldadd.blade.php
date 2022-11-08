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
		<div class="col-lg-12">

			<div class="m-portlet">

				<form class="m-form m-form--fit m-form--label-align-right "  method="POST" action="{{ route('product_addproduct') }}"  enctype="multipart/form-data"  id="m_form_1" >
					{{ csrf_field() }}
					<div class="m-portlet__body">
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

						<div class="form-group m-form__group row">
							<div class="col-lg-3">
								<br/><br/><br/>
								<label class="col-form-label">Product gallery</label>
							</div>
							<div class="col-lg-9 col-md-9 col-sm-12">
								<div class="m-dropzone dropzone m-dropzone--primary"  id="productDropZone" action="/" method="post">
									<div class="m-dropzone__msg dz-message needsclick" >
										<h3 class="m-dropzone__msg-title">Drop image here</h3>
										<span class="m-dropzone__msg-desc">Allowed only image files</span>
									</div>
									<div id="image_data"></div>
						<div id="image-holder"></div>
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
					<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
						<div class="m-form__actions ">
							<div class="form-group m-form__group row">
								<div class="col-lg-5">
								</div>
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary  font12" >Save</button>
									<a href="{{ route('products') }}" class="btn btn-secondary font12">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>

			<script>
				Dropzone.autoDiscover = false;
				var FormControls = function () {

					var demo1 = function () {
						$( "#m_form_1" ).validate({
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
							},

							invalidHandler: function(event, validator) {     
								/*var alert = $('#m_form_1_msg');
								alert.removeClass('m--hide').show();
								mUtil.scrollTop();*/
								if (!validator.numberOfInvalids())
						            return;

						        $('html, body').animate({
						            scrollTop: $(validator.errorList[0].element).offset().top - 100
						        }, 500);
							},

							submitHandler: function (form) {
								var imgsrc = $('.dz-image img').attr('src');
								if(imgsrc == undefined){
									alert('Please upload product image before submit');
								}else{
									
									form[0].submit();
								} 
							}
						});      
					}

					return {
						init: function() {
							demo1(); 
						}
					};
				}();


				$(document).ready(function(){
					FormControls.init();
					
				});

				$(document).ready(function(){
					
					var dropzone_image_id = 0;				
					$("#productDropZone").dropzone({
						autoQueue: false,
						maxFilesize: 20,
						acceptedFiles: "jpeg,.jpg,.png,.gif",
						uploadMultiple: false,
						parallelUploads: 5,
						paramName: "file",
						addRemoveLinks: true,
						dictFileTooBig: 'Image is larger than 20MB',
						timeout: 10000,
						init: function() {
							this.on("success", function(file, responseText) {      
								// console.log("Dropzone Sucess.");
							});
							this.on("removedfile", function(file) {
								$(".remove_image_" + file.name.replace(/[\. ,:-]+/g, "_").replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '_')).first().remove();
							});
							this.on("addedfile", function(file) {
								var _this=this,
								reader = new FileReader();
								reader.onload = function(event) {
									base64 = event.target.result;
									_this.processQueue();
									var hidden_field = "<input hidden type='text' class='remove_image_"+ file.name.replace(/[\. ,:-]+/g, "_").replace(/[&\/\\#,+()$~%.'":*?<>{}]/g, '_') + "' name='form[file][" + dropzone_image_id + "]' value=" + base64 + ">";
									var image = "<img  name='" + file.name + "' src='" + base64 + "' height=100>"
									$("#image_data").append(hidden_field);
									// console.log(dropzone_image_id);
									dropzone_image_id++;
								};
								reader.readAsDataURL(file);
							});
						},
						accept: function (file, done) {
						// console.log(file);
						done();
						}
					});
				});
			</script>
			@endsection
