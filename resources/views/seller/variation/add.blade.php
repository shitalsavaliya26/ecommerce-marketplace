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
						<span class="m-nav__link-text">Add Variation</span>
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
						Add Variation
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
			<form action="{{route('variations.store')}}" method="post" id="variation_form" name="variation_form">
				{{ csrf_field() }}
				<input type="hidden" id="product" name="product" placeholder="Enter Product" value="{{$products->id}}" >
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="product">Product <span class="colorred">*</span></label>
								<input type="text" class="form-control m-input" id="products"
												name="products" placeholder="Enter Product" value="{{$products->name}}" readonly autofocus>
                                <span class="help-block text-danger">{{ $errors->first('product') }}</span>
							</div>
						</div>
						<div class="col-lg-4"></div>
						<div class="col-lg-2">
							<div class="form-group m-form__group">
								<label></label>
								<div class="form-group m-form__group">
									<button type="button" name="add" id="add" class="btn btn-primary add-button">
										Add Attribute   <img src="{{asset('public/backend/images/plus-16.png')}}" style="width: 15px; height: 15px">
									</button>
								</div>
							</div>
						</div>
					</div>
					<div id="dynamic_option">
						<div id="basic">
							<div class="form-group m-form__group row dynamic_option" id="basic">
								<div class="col-lg-3">
									<div class="form-group m-form__group">
										<label for="attribute">Attribute <span class="colorred">*</span></label>
										<select class="form-control m_selectpicker" name="attribute[]" id="attribute">
											@foreach ($attributes as $attribute)
												<option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
											@endforeach
										</select>
										<div id="attribute-error" class="form-control-feedback attribute-error"></div>
										<span class="help-block text-danger">{{ $errors->first('attribute') }}</span>
									</div>
								</div>
								<div class="col-lg-5">
									<div class="form-group m-form__group">
										<label for="variation">Variation <span class="colorred">*</span></label>
										<input type="text" data-role="tagsinput" id="variation" name="variation[]" class="form-control dynamic-tags">
										<span class="help-block text-danger">{{ $errors->first('variation') }}</span>
									</div>
									<div id="variation-error" class="form-control-feedback variation-error"></div>
								</div>
								<div class="col-lg-2">
									<div class="form-group m-form__group">
										<label class="">Is Variable?</label><br>
										<div class="col-lg-9 col-md-9 col-sm-12 mt-2">
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="checkbox" name="is_variation[]" id="is_variation" value="1">
												<div id="is_variation-error" class="form-control-feedback is_variation-error"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="form-group m-form__group">
										<button type="button" name="remove" id="remove" class="btn btn-primary remove-button btn_remove">
											<img src="{{asset('public/backend/images/minus-2-16.png')}}" style="width: 15px; height: 15px">
										</button>
									</div>
								</div>
							</div>
						</div>
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
					<div id="attribute-pricing-row"></div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-send-request font12" disabled >Submit</button>
                                    <a href="{{ route('products')}}" class="btn btn-secondary font12">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript" src="{{asset('public/js/bootstrap-tagsinput.min.js')}}"></script>
<script type="text/javascript">
	var i = 0;
	product_id = {{json_encode($products->id)}};

	$('#add').click(function() {
		i++;
		var clone = $("#basic").clone();
		clone.find('#basic').attr('id', 'basic'+i);
		clone.find('#attribute').attr('id', 'attribute'+i);
		clone.find('#variation').attr('id', 'variation'+i);
		clone.find('#variation-error').attr('id', 'variation-error'+i);
		clone.find("#variation"+i).val('');
		clone.find('#is_variation').attr('id', 'is_variation'+i);
		clone.find("#is_variation"+i).prop('checked',false);
		clone.find('#remove').attr('id', i);
		$("#dynamic_option").append(clone);
		$('.dynamic-tags').tagsinput();
		$(".bootstrap-tagsinput").nextAll().remove();
	});
	$(document).on('click', '.btn_remove', function() {
		var button_id = $(this).attr("id");
		$('#basic' + button_id).remove();
		$(button_id).remove();
	});

	function checkIfArrayIsUnique(myArray) {
		return myArray.length === new Set(myArray).size;
	}

	$('#set').click(function() {
		var attributeArray = $("[name='attribute[]']").map(function(){return $(this).val();}).get();
		var variationArray = $("[name='variation[]']").map(function(){return $(this).val();}).get();

		$.each(variationArray, function( key, value ) {
			key == 0 ? key = '' : key = key;
            if(value == ''){
				$('#variation-error'+key).addClass("variation-error form-control-feedback");
				$('#variation-error'+key).html('Please enter atleast one variation');
			}
			else{
				$('#variation-error'+key).removeClass("variation-error form-control-feedback");
				$('#variation-error'+key).html('');
			}
        });

		var isVariationArray = $("input[name='is_variation[]']").map(function(){
			if (this.checked) {
				return $(this).val();
			}
			return '0';
		}).get();

		if(checkIfArrayIsUnique(attributeArray) == false){
			$('#attribute-error').html('Please select unique attribute');
		}else{
			$('#attribute-error').html('');
		}
		// $.each( isVariationArray, function( key, value ) {
        //     if(value == '0'){
		// 		delete attributeArray[key];
		// 		delete variationArray[key];
		// 	}
        // });

		if (($(".variation-error").length > 0) || (checkIfArrayIsUnique(attributeArray) == false)) {
			$('#attribute-pricing-row').html('');
			return;
		}else{
			pricing(attributeArray, variationArray, isVariationArray, product_id);
			$(':input[type="submit"]').prop('disabled', false);

		}
	});

	function pricing(attributeArray, variationArray, isVariationArray, product_id){
		var url = "{{ route('variations.pricing') }}";
		$.ajax({
			type:'post',
			url:url,
			data:{
				'attributeArray': attributeArray,
        		'variationArray': variationArray,
        		'isVariationArray': isVariationArray,
        		'product_id': product_id
			},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			success: function(response){
				$('#attribute-pricing-row').html(response.view);
			}
		});
	}

	$(document).ready(function(){
		$.validator.addMethod("customer_cost_price", function (value, element) {
			var flag = true;
			$("[name^=customer_cost_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="customer_cost_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("staff_price", function (value, element) {
			var flag = true;
			$("[name^=staff_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="staff_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("customer_price", function (value, element) {
			var flag = true;
			$("[name^=customer_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="customer_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("sell_price", function (value, element) {
			var flag = true;
			$("[name^=sell_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="sell_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("ex_price", function (value, element) {
			var flag = true;
			$("[name^=ex_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="ex_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("si_price", function (value, element) {
			var flag = true;
			$("[name^=si_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="si_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("go_price", function (value, element) {
			var flag = true;
			$("[name^=go_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="go_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("pl_price", function (value, element) {
			var flag = true;
			$("[name^=pl_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="pl_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("di_price", function (value, element) {
			var flag = true;
			$("[name^=di_price]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="di_price' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$.validator.addMethod("qty", function (value, element) {
			var flag = true;
			$("[name^=qty]").each(function (i, j) {
				$(this).parent('div').next(".form-control-feedback").remove();
				if ($.trim($(this).val()) == '') {
					flag = false;
					$(this).parent('div').after('<div  id="qty' + i + '-error" class="form-control-feedback">This field is required.</div>');
				}
			});
			return flag;
		}, "");

		$("#variation_form").validate({
			rules: {
				"customer_cost_price[]": {
					customer_cost_price: true,
				},
				"staff_price[]": {
					staff_price: true
				},
				"customer_price[]": {
					customer_price: true
				},
				"sell_price[]": {
					sell_price: true
				},
				"ex_price[]": {
					ex_price: true
				},
				"si_price[]": {
					si_price: true
				},
				"go_price[]": {
					go_price: true
				},
				"pl_price[]": {
					pl_price: true
				},
				"di_price[]": {
					di_price: true
				},
				"qty[]": {
					qty: true
				},
			}
		});

	});
</script>
@endsection
