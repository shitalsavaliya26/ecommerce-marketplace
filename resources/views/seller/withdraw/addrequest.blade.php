@extends('seller.layouts.main')
@section('title', 'Withdrawal request')

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
					<a href="{{ route('seller.withdrawals')}}" class="m-nav__link">
						<span class="m-nav__link-text">Bank</span>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="" class="m-nav__link">
						<span class="m-nav__link-text">Add bank</span>
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
						Add bank
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
			<form action="{{route('seller.withdrawals.store')}}" method="post" id="faq_form">
				{{ csrf_field() }}
				
				<div class="m-portlet__body">
					<div class="form-group m-form__group row">
						<div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="amount">Amount</label>
								<input type="text" name="amount" class="form-control m-input" placeholder="Enter amount" maxlength="80" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="account_number">Account Number</label>
								<input type="text" name="account_number" class="form-control m-input" placeholder="Enter account number" maxlength="80" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="bank_id">Bank </label>
								<select class="form-control m-input" name="bank_id">
									<option value="">Select bank</option>
									@foreach($banks as $bank)
									<option value="{{$bank->id}}">{{$bank->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<!-- <div class="col-lg-6">
							<div class="form-group m-form__group">
								<label for="bankname">Bank name</label>
								<input type="text" name="bankname" class="form-control m-input" placeholder="Enter bank name" maxlength="80" required>
							</div>
						</div>
 -->
					</div>
					
					<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
						<div class="m-form__actions m-form__actions--solid">
							<div class="row">
								<div class="col-lg-5">
								</div>
								<div class="col-lg-6">
									<button type="submit" class="btn btn-primary btn-send-request font12">Submit</button>
									<a href="{{ route('seller.withdrawals')}}" class="btn btn-secondary font12">Cancel</a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<script type="text/javascript">
				$(document).ready(function(){
					$( "#faq_form" ).validate({
						rules: {
							amount: {
								required: true,
								number: true,
								min:1
							},
							account_number: {
								required: true,
								number: true,
								min:9
							},
							bank_id: {
								required: true,
							},

						}, messages: {
							amount: {
								required: 'Please enter amount',
							},
							account_number: {
								required: 'Please enter account number',
							},
							bank_id: {
								required: 'Please select bank',
							},
						}
					});

				});
			</script>

			@endsection
