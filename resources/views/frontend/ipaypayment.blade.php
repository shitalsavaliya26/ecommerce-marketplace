@extends('layouts.main')
@section('title', 'Ipay Payment')
@section('content')
<div class="wrapper wrapper-content">

	<div class="row animated fadeInRight">
		<div class="col-md-12">
			<div class="ibox float-e-margins cus-box-shadow cus-blue-bg">
				<div style="text-align:center; margin-top:25px;">
					<form name="usdtform" id="usdtform" action="https://payment.ipay88.com.my/epayment/entry.asp" method="post" class="onloadformsubmit" style="display:none;">
						<INPUT type="hidden" name="MerchantCode" value="{{$merchant_code}}">
						<INPUT type="hidden" name="PaymentId"
						value="">
						<INPUT type="hidden" name="RefNo"
						value="{{$refno}}">
						<INPUT type="hidden" name="Amount"
						value="{{$amount}}">
						<INPUT type="hidden" name="Currency"
						value="{{$currency}}">
						<INPUT type="hidden" name="ProdDesc"
						value="{{$refno}}">
						<INPUT type="hidden" name="UserName"
						value="{{auth()->user()->name}}">
						<INPUT type="hidden" name="UserEmail"
						value="{{auth()->user()->email}}">
						<INPUT type="hidden" name="UserContact"
						value="{{auth()->user()->phone}}">
						<INPUT type="hidden" name="Remark"
						value="">
						<INPUT type="hidden" name="Lang"
						value="UTF-8">
						<INPUT type="hidden" name="SignatureType" value="SHA256">
						<INPUT type="hidden" name="Signature"
						value="{{$signature}}">
						<INPUT type="hidden" name="ResponseURL"
						value="{{$responseURL}}">
						<INPUT type="hidden" name="BackendURL"
						value="{{$backendUrl}}">
						<input type="submit" style="display:none;">
					</form>
					<div style="width: 200px;margin: 0 auto;height: 200px;"><svg class="lds-coin" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
						<defs>
							<filter id="lds-mask-filterid-8cd6779640b8a" x="0" y="0" width="100" height="100" filterUnits="userSpaceOnUse">
								<feColorMatrix type="matrix" values="0 0 0 0 1  0 0 0 0 1  0 0 0 0 1  -1 -1 -1 1 0"></feColorMatrix>
							</filter>
							<mask id="lds-mask-maskid-09a6a847528b5" x="0" y="0" width="100" height="100" maskUnits="userSpaceOnUse">
								<image id="lds-mask-imgid-eae718df2f0b2" xlink:href="data:image/svg+xml;base64, PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBmaWxsPSIjMDAwIiBkPSJNNDkuOTk5LDEyLjQ3OWMtMjAuNjg5LDAtMzcuNTIsMTYuODMxLTM3LjUyLDM3LjUyYzAsMjAuNjg5LDE2LjgzMSwzNy41MjIsMzcuNTIsMzcuNTIyIHMzNy41MjItMTYuODMzLDM3LjUyMi0zNy41MjJDODcuNTIxLDI5LjMxLDcwLjY4OCwxMi40NzksNDkuOTk5LDEyLjQ3OXogTTUyLjg4OCw2OS42MzJ2My40MDFjMCwxLjczNi0xLjQwNywzLjE0NC0zLjE0NCwzLjE0NCBoLTAuMDAyYy0xLjczNiwwLTMuMTQ0LTEuNDA3LTMuMTQ0LTMuMTQ0di0yLjk1MmMtMi43NjMtMC4xMjMtNS40NzQtMC42NDUtNy43MDUtMS4zNzdjLTEuODUyLTAuNjA3LTIuOS0yLjU1Ny0yLjQxNi00LjQ0NSBsMC4wNzctMC4zMDFjMC41MzUtMi4wODUsMi43MzctMy4yMDYsNC43NzQtMi41MTJjMi4wNzMsMC43MDYsNC40MzcsMS4xOTIsNi45MzksMS4xOTJjMy42NTcsMCw2LjE1OS0xLjQxLDYuMTU5LTMuOTc3IGMwLTIuNDM3LTIuMDUyLTMuOTc3LTYuODAxLTUuNTgyYy02Ljg2NS0yLjMxLTExLjU0OS01LjUxOC0xMS41NDktMTEuNzQxYzAtNS42NDcsMy45NzktMTAuMDczLDEwLjg0NC0xMS40MjF2LTIuOTUgYzAtMS43MzYsMS40MDctMy4xNDQsMy4xNDQtMy4xNDRzMy4xNDQsMS40MDcsMy4xNDQsMy4xNDR2Mi41MDFjMi4yOTYsMC4xMDMsNC4xODksMC40MDgsNS43NzgsMC44MjUgYzEuOTkzLDAuNTI0LDMuMjA4LDIuNTI3LDIuNjk2LDQuNTIzYy0wLjUxNiwyLjAxMi0yLjU5MiwzLjI0NS00LjU4MiwyLjY1MmMtMS41MTctMC40NTItMy4zOTctMC44MTUtNS42ODgtMC44MTUgYy00LjE3MSwwLTUuNTE4LDEuNzk2LTUuNTE4LDMuNTk0YzAsMi4xMTcsMi4yNDUsMy40NjQsNy42OTksNS41MTZjNy42MzUsMi42OTYsMTAuNzE2LDYuMjI1LDEwLjcxNiwxMS45OTggQzY0LjMwOCw2My40NzMsNjAuMjY1LDY4LjM0OSw1Mi44ODgsNjkuNjMyeiIvPjwvc3ZnPgo=" x="0" y="0" width="100" height="100" style="width:100px;height:100px!important" filter="url(#lds-mask-filterid-8cd6779640b8a)"></image>
							</mask>
						</defs>
						<g mask="url(#lds-mask-maskid-09a6a847528b5)">
							<g><rect x="0" y="0" width="17.666666666666668" height="100" fill="#ff003a">
								<animate attributeName="fill" values="#4658ac;#e7008a;#ff003a;#ff6d00;#4658ac" keyTimes="0;0.25;0.5;0.75;1" dur="1s" repeatCount="indefinite" begin="-1s"></animate>
							</rect><rect x="16.666666666666668" y="0" width="17.666666666666668" height="100" fill="#ff6d00">
								<animate attributeName="fill" values="#4658ac;#e7008a;#ff003a;#ff6d00;#4658ac" keyTimes="0;0.25;0.5;0.75;1" dur="1s" repeatCount="indefinite" begin="-0.8333333333333334s"></animate>
							</rect><rect x="33.333333333333336" y="0" width="17.666666666666668" height="100" fill="#4658ac">
								<animate attributeName="fill" values="#4658ac;#e7008a;#ff003a;#ff6d00;#4658ac" keyTimes="0;0.25;0.5;0.75;1" dur="1s" repeatCount="indefinite" begin="-0.6666666666666666s"></animate>
							</rect><rect x="50" y="0" width="17.666666666666668" height="100" fill="#e7008a">
								<animate attributeName="fill" values="#4658ac;#e7008a;#ff003a;#ff6d00;#4658ac" keyTimes="0;0.25;0.5;0.75;1" dur="1s" repeatCount="indefinite" begin="-0.5s"></animate>
							</rect><rect x="66.66666666666667" y="0" width="17.666666666666668" height="100" fill="#ff003a">
								<animate attributeName="fill" values="#4658ac;#e7008a;#ff003a;#ff6d00;#4658ac" keyTimes="0;0.25;0.5;0.75;1" dur="1s" repeatCount="indefinite" begin="-0.3333333333333333s"></animate>
							</rect><rect x="83.33333333333334" y="0" width="17.666666666666668" height="100" fill="#ff6d00">
								<animate attributeName="fill" values="#4658ac;#e7008a;#ff003a;#ff6d00;#4658ac" keyTimes="0;0.25;0.5;0.75;1" dur="1s" repeatCount="indefinite" begin="-0.16666666666666666s"></animate>
							</rect><anximatetransform attributeName="transform" type="translate" filter="url(#lds-mask-filterid-8cd6779640b8a)" values="0 0;100 0" keyTimes="0;1" dur="1s" repeatCount="indefinite"></anximatetransform>
						</g></g></svg></div>
						<p style="font-family: verdana;color: #4c4c4c;">Please wait. Do not refresh this page.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection
	@section('script')
	<script type="text/javascript">
		$(document).ready(function() {
			$('.onloadformsubmit').submit() ;
		});
	</script>
	@endsection