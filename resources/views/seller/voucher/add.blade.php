@extends('seller.layouts.main')

@section('content')
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ url('/seller')}}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{ route('seller.vouchers.index')}}" class="m-nav__link">
                        <span class="m-nav__link-text">Vouchers</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Add Voucher</span>
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
                        Add Voucher
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
            <form class="m-form m-form--label-align-left- m-form--state-" method="POST"
                            action="{{route('seller.vouchers.store')}}" enctype="multipart/form-data" id="voucher_form">
                {{ csrf_field() }}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 form-group m-form__group">
                            <div class="row">
                                <div class="col-lg-3">
                                    <label>Voucher Type</label>
                                </div>
                                <div class="col-lg-4">
                                    <label for="type"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="type" class="type" value="seller" id="seller" checked> Seller Voucher</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="type"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="type" class="type" value="product" id="product"> Product Voucher</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="name">Voucher Name</label>
								<input type="text" name="name" class="form-control m-input"
								placeholder="Enter voucher name" required>
                                <span class="help-block text-danger">{{ $errors->first('name') }}</span>
							</div>
						</div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="code">Voucher Code</label>
								<input type="text" name="code" class="form-control m-input"
								placeholder="Enter voucher code" required>
                                <span class="help-block text-danger">{{ $errors->first('code') }}</span>
							</div>
						</div>
                        <div class="col-lg-2">
							<div class="form-group m-form__group">
								<label for="fromDate">Start Date of Sale </label>
                                <div class="m-input-icon ">
									<input type="text" name="fromDate" class="form-control m-input" id="fromDate" placeholder="Start Date of Sale" autocomplete="off">
									<span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
								</div>
                                <span class="help-block text-danger">{{ $errors->first('fromDate') }}</span>
							</div>
						</div>
						<div class="col-lg-2">
							<div class="form-group m-form__group">
								<label for="toDate">End Date of Sale </label>
                                <div class="m-input-icon ">
									<input type="text" name="toDate" class="form-control m-input" id="toDate" placeholder="End Date of Sale" autocomplete="off">
									<span class="m-input-icon__icon m-input-icon__icon--right"><span><i class="la la-calendar-check-o"></i></span></span>
								</div>
                                <span class="help-block text-danger">{{ $errors->first('toDate') }}</span>
							</div>
						</div>
                        <div class="col-lg-2">
							<div class="form-group m-form__group">
								<label for="display_voucher_early">Display voucher early </label>
                                <input type="checkbox" class="m-input m-checkbox" name="display_voucher_early">
                                <span class="help-block text-danger">{{ $errors->first('display_voucher_early') }}</span>
							</div>
						</div>
                    </div>

                    <div class="form-group m-form__group row seller">
                        <div class="col-lg-7">
                            <div class="row">
                                <div class="col-lg-2">
                                    <label>Target Buyer</label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="target_buyer"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="target_buyer" class="target_buyer" value="all_buyer" id="all_buyer" checked> All Buyer</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <label for="target_buyer"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="target_buyer" class="target_buyer" value="new_buyer" id="new_buyer"> New Buyer</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="target_buyer"></label>
                                    <div style="margin-top:-20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="target_buyer" class="target_buyer" value="repeat_purchase_buyer" id="repeat_purchase_buyer"> Repeat Purchase Buyer</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 repeat_purchase_buyer_condition" style="display:none">
                            <div >
                                <div class="form-group"> 
                                    <p>Purchased
                                        <select class="m-input" name="purchased_time" class="purchased_time" id="purchased_time">
                                            @for($i=1; $i <= 10; $i++)
                                                <option value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select> time(s) from your shop in the past
                                        <select class="m-input" name="past_days" class="past_days" id="past_days">
                                            @for($j=1; $j <= 30; $j++)
                                                <option value="{{$j}}">{{$j}}</option>
                                            @endfor
                                        </select> days. </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1><b>Reward Settings</b></h1>
                    
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 form-group m-form__group">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>Reward Type</label>
                                </div>
                                <div class="col-lg-4">
                                    <label for="reward_type"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="reward_type" value="discount" id="discount" checked> Discount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="reward_type"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="reward_type" value="cashback" id="cashback"> Coins Cashback</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="discount_price">Discount Type | Amount </label>
								<div class="input-group m-input-group">
									<select name="discount_type" class="discount_type" id="discount_type">
										<option value="by_percentage"> &nbsp;By Percentage&nbsp;</option>
										<option value="cash"> &nbsp;Cash&nbsp;</option>
									</select>
									<input type="text" class="form-control m-input"
                                        placeholder="Enter your amount" id="discount_price" name="discount_price"
                                        value="" maxlength="12">
                                    <span class="help-block text-danger">{{ $errors->first('discount_price') }}</span>
								</div>
							</div>
						</div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 form-group m-form__group">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>Maximum Discount Price Type</label>
                                </div>
                                <div class="col-lg-4">
                                    <label for="max_discount_price_type"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="max_discount_price_type" class="max_discount_price_type" value="limit" id="limit" checked> Set Amount</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label for="max_discount_price_type"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="max_discount_price_type" class="max_discount_price_type" value="limit_less" id="limit_less"> No Limit</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 max_discount_price_div">
							<div class="form-group m-form__group">
								<label for="max_discount_price">Maximum Discount Price</label>
								<input type="text" name="max_discount_price" class="form-control m-input"
								placeholder="Enter maximum discount price" required>
                                <span class="help-block text-danger">{{ $errors->first('max_discount_price') }}</span>
							</div>
						</div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 form-group m-form__group">
                            <div class="form-group m-form__group">
								<label for="min_basket_price">Minimum Basket Price</label>
								<input type="text" name="min_basket_price" class="form-control m-input"
								placeholder="Enter minimum basket price" required>
                                <span class="help-block text-danger">{{ $errors->first('min_basket_price') }}</span>
							</div>
                        </div>
                        <div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="usage_qty">Usage Quantity</label>
								<input type="text" name="usage_qty" class="form-control m-input"
								placeholder="Enter usage quantity" required>
                                <span class="help-block text-danger">{{ $errors->first('usage_qty') }}</span>
							</div>
						</div>
                    </div>

                    <h1><b>Voucher Display & Applicable Products</b></h1>

                    <div class="form-group m-form__group row">
                        <div class="col-lg-6 ">
                            <div class="row">
                                <div class="col-lg-4">
                                    <label>Voucher Display Setting</label>
                                </div>
                                <div class="col-lg-4">
                                    <label for="voucher_display"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="voucher_display" value="on_all_page" id="on_all_page" checked> Display on all pages</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 product" style="display:none">
                                    <label for="voucher_display"></label>
                                    <div style="margin-top: -20px;">
                                        <div class="form-group"> 
                                            <label class="radio-inline">
                                                <input type="radio" name="voucher_display" value="not_display" id="not_display"> Do not display</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 product" style="display:none">
                            <label for="product">Applicable Products </label>
                            <div class="m-input-icon m-input-icon--right">
                                <select class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true" multiple="multiple"
                                    name="products[]" id="products">
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 seller">
                            <label for="seller">Select Seller </label>
                            <div class="m-input-icon m-input-icon--right">
                                <select class="form-control m-input" name="seller" id="seller">
                                    <option value="{{$seller->id}}" @if($seller->user_id == Auth::user()->id) selected @endif >{{$seller->name}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions">
                            <div class="row">
                                <div class="col-lg-5">
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit"
                                    class="btn btn-primary btn-send-request font12">Submit</button>
                                    <a href="{{ route('seller.vouchers.index')}}" class="btn btn-secondary font12">Cancel</a>
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
<script>
    $(document).ready(function() {
        $('.m_selectpicker').selectpicker();

        $('#fromDate').datetimepicker({
			autoclose: true,
			changeMonth: true,
                yearRange: new Date().getFullYear().toString() + ':' + new Date().getFullYear().toString(),
                onClose: function (selectedDate) {
                    $("#toDate").datepicker("option", "minDate", selectedDate);
                }
		});

		$('#toDate').datetimepicker({
			autoclose: true,
			changeMonth: true,
			yearRange: new Date().getFullYear().toString() + ':' + new Date().getFullYear().toString(),
			onClose: function (selectedDate) {
				$("#fromDate").datepicker("option", "maxDate", selectedDate);
			}
		});

        $.validator.addMethod('mindatetime',function(v,el){
			if($("input[name=toDate]").val() == ''){
				return true;
			}
			var endDate = $("input[name=toDate]").datetimepicker('getDate');

			var startDate = $(el).datetimepicker('getDate');
			return endDate > startDate;
		}, 'Start Date must be less then end date');

		$.validator.addMethod('maxdatetime',function(v,el){
			if (this.optional(el)){
				return true;
			}
			if($("input[name=fromDate]").val() == ''){
				return false;
			}
			var endDate = $("input[name=toDate]").datetimepicker('getDate');

			var startDate = $("input[name=fromDate]").datetimepicker('getDate');
			return endDate > startDate;
		}, 'End date must be greater then start date');

        $(document).on('change','.target_buyer',function() {
            var val = $(this).val();
            if(val == 'repeat_purchase_buyer'){
                $('.repeat_purchase_buyer_condition').removeAttr('style');
            }else{
                $('.repeat_purchase_buyer_condition').attr('style', 'display:none;');
            }
        });

        $(document).on('change','.type',function() {
            var val = $(this).val();
            if(val == 'product'){
                $('.product').removeAttr('style');
                $('.seller').attr('style', 'display:none;');
            }else{
                $('.seller').removeAttr('style');
                $('.product').attr('style', 'display:none;');
            }
        });

        $(document).on('change','.max_discount_price_type',function() {
            var val = $(this).val();
            if(val == 'limit'){
                $('.max_discount_price_div').removeAttr('style');
            }else{
                $('.max_discount_price_div').attr('style', 'display:none;');
            }
        });

        $( "#voucher_form" ).validate({
            ignore: ":hidden",
			rules: {
				name:{
					required:true,
                    maxlength:50,
				},
				code:{
					required:true,
                    maxlength:30,
				},
				toDate: {
                    required: true,
                    maxdatetime: true,
                },
                fromDate: {
                    required: true,
                    mindatetime: true,
                },
                discount_price:{
                    required: true,
                    number: true
                },max_discount_price:{
                    required: true,
                    number: true
                },min_basket_price:{
                    required: true,
                    number: true
                },seller:{
                    required: true,
                },'products[]':{
                    required: true,
                },usage_qty:{
                    required: true,
                    digits: true
                }
			},messages: {
                discount_price: {
                    number: "Decimal Numbers Only"
                },
                max_discount_price: {
                    number: "Decimal Numbers Only"
                },
                min_basket_price: {
                    number: "Decimal Numbers Only"
                },usage_qty:{
                    digits: "Integer Numbers Only"
                }
            }

		});
    });
</script>
@endsection
