@extends('layouts.app')
<link rel="stylesheet" href="{{asset('public/css/tagsinput/tagsinput.css')}}">
<style type="text/css">
	.bootstrap-tagsinput {
		width: 100%;
		height: 100px;
	}
	.label {
		line-height: 2 !important;
	}
	.bootstrap-tagsinput .tag{
		background-color:#4b49ac;
		border-radius: 10px;
		padding-left: 10px;
		padding-right: 10px;
	}
	.bootstrap-tagsinput {
		line-height: 34px;
	}
</style>

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
					<a href="{{ route('products')}}" class="m-nav__link">
						<span class="m-nav__link-text">Products</span>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="" class="m-nav__link">
						<span class="m-nav__link-text">Edit Variation</span>
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
                        Edit Variation
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row" id="app_massges">
                @if (\Session::has('success'))
                    <div class="col-xl-12 m-section__content toast-container ">
                        <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            <strong> {!! \Session::get('success') !!}</strong>
                        </div>
                    </div>
                @endif
                @if (\Session::has('error'))
                    <div class="col-xl-12 m-section__content">
                        <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            </button>
                            <strong> {!! \Session::get('error') !!}</strong>
                        </div>
                    </div>
                @endif
            </div>
            <form action="{{route('variations.update', $product->id)}}" method="post" id="variation_form">
				{{ csrf_field() }}
				<input type="hidden" id="product" name="product" placeholder="Enter Product" value="{{$product->id}}" >
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="product">Product <span class="colorred">*</span></label>
								<input type="text" class="form-control m-input" id="products"
												name="products" placeholder="Enter Product" value="{{$product->name}}" readonly autofocus>
                                <span class="help-block text-danger">{{ $errors->first('product') }}</span>
							</div>
						</div>
						<div class="col-lg-4"></div>
						<div class="col-lg-2">
							<!-- <div class="form-group m-form__group">
								<label></label>
								<div class="form-group m-form__group">
									<button type="button" name="add" id="add" class="btn btn-primary add-button">
										Add Attribute   <img src="{{asset('public/backend/images/plus-16.png')}}" style="width: 15px; height: 15px">
									</button>
								</div>
							</div> -->
						</div>
					</div>
					<div id="dynamic_option">
						<input type="hidden" id="attributeArray{{$key}}" name="attributeArray" value="{{json_encode($attributeIds)}}">
						@foreach($product->attributes as $key => $attr)
							<div id="basic">
								<div class="form-group m-form__group row dynamic_option" @if($key<=0) id="basic" @else id="basic{{$key}}" @endif>
									<div class="col-lg-3">
										<div class="form-group m-form__group">
											<label for="attribute">Attribute <span class="colorred">*</span></label>
											<select class="form-control m_selectpicker" name="attribute[]" @if($key<=0) id="attribute" @else id="attribute{{$key}}" @endif disabled>
												@foreach ($attributes as $attribute)
													<option value="{{ $attribute->id }}" @if($attribute->id == $attr->attribute_id) selected @endif>{{ $attribute->name }}</option>
												@endforeach
											</select>
											<span class="help-block text-danger">{{ $errors->first('attribute') }}</span>
										</div>
									</div>
									<div class="col-lg-5">
										<div class="form-group m-form__group">
											<label for="variation">Variation <span class="colorred">*</span></label>
											<input type="text" data-role="tagsinput" @if($key<=0) id="variation" @else id="variation{{$key}}" @endif name="variation[]" class="form-control dynamic-tags" value="{{implode(',' ,$varValue[$attr->id])}}" data-id="{{$product->attributevariation[$key]['product_attribute_id']}}" >
											<span class="help-block text-danger">{{ $errors->first('variation') }}</span>
										</div>
									</div>
									<div class="col-lg-2">
										<div class="form-group m-form__group">
											<label class="">Is Variable?</label><br>
											<div class="col-lg-9 col-md-9 col-sm-12 mt-2">
												<div class="form-check form-check-inline">
													<input class="form-check-input" type="checkbox" name="is_variation[]" @if($key<=0) id="is_variation" @else id="is_variation{{$key}}" @endif value="1" @if($attr->is_variation == '1') checked @endif disabled="disabled">
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-2">
										<!-- <div class="form-group m-form__group">
											<button type="button" name="remove" @if($key<=0) id="remove" @else id="{{$key}}" @endif class="btn btn-primary remove-button btn_remove">
												<img src="{{asset('public/backend/images/minus-2-16.png')}}" style="width: 15px; height: 15px">
											</button>
										</div> -->
									</div>
								</div>
							</div>
						@endforeach
					</div>
					<div class="col-lg-2">
						<div class="form-group m-form__group">
							<label></label>
							<div class="form-group m-form__group">
								<button type="button" name="set" id="set" class="btn btn-primary set-button">
									Set Variation
								</button>
							</div>
						</div>
					</div>
					<div id="attribute-pricing-row">

					</div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-send-request font12">Submit</button>
                                    <a href="{{ route('products')}}" class="btn btn-secondary font12">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
	</div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{asset('public/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript">
	var app = @json($existance);
	product_id = {{json_encode($product->id)}};

	$('#set').click(function() {
		setPrice();
	});
	$( document ).ready(function() {
		setPrice();
	});
	$(document).on('beforeItemRemove', 'input', function(event) {
		if(jQuery.inArray(event.item, app) !== -1){
			event.cancel = true;
		}else{
			event.cancel = false;
		}
	});

	function setPrice(){
		var attributeArray = $("[name='attribute[]']").map(function(){return $(this).val();}).get();
		var variationArray = $("[name='variation[]']").map(function(){return $(this).val();}).get();
		
		var allVariationArray = jQuery("[name='variation[]']").map(function() { 
			return jQuery(this).data('id'); 
		}).get();
		var isVariationArray = $("input[name='is_variation[]']").map(function(){
			if (this.checked) {
				return $(this).val();
			}
			return '0';
		}).get();

		var url = "{{ route('variations.editPricing') }}";
		$.ajax({
			type:'post',
			url:url,
			data:{
				'attributeArray': attributeArray,
        		'variationArray': variationArray,
        		'isVariationArray': isVariationArray,
        		'product_id': product_id,
        		'allVariationArray': allVariationArray,
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response){
				$('#attribute-pricing-row').html(response.view);
			}
		});
	}

	function validate(evt) {
		var theEvent = evt || window.event;

		// Handle paste
		if (theEvent.type === 'paste') {
			key = event.clipboardData.getData('text/plain');
		} else {
		// Handle key press
			var key = theEvent.keyCode || theEvent.which;
			key = String.fromCharCode(key);
		}
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
			theEvent.returnValue = false;
			if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
</script>
@endsection
