@extends('seller.layouts.main')

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
					<a href="{{ route('seller.products.index')}}" class="m-nav__link">
						<span class="m-nav__link-text">Products</span>
					</a>
				</li>
				<li class="m-nav__separator">-</li>
				<li class="m-nav__item">
					<a href="" class="m-nav__link">
						<span class="m-nav__link-text">View product</span>
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
						Product details (#{{$product->id}}) 
					</h3>
				</div>
			</div>
			<div class="mt9">
				<h3 class="m-portlet__head-text">
					<a href="{{ route('seller.products.edit', [App\Helpers\Helper::encrypt($product->id)]) }}" class="btn btn-primary  m-btn m-btn--sm ">
						<span class="font12">Edit product</span>
					</a>
					<a onclick="return confirm('Are you sure you want to delete this product?');" href="{{ route('seller.products.destroy', [App\Helpers\Helper::encrypt($product->id)]) }}" class="btn btn-danger  m-btn m-btn--sm ">
						<span class="font12">Delete product</span>
					</a>
				</h3>
			</div>
		</div>
		<div class="m-portlet__body">
			<ul class="nav nav-tabs  m-tabs-line m-tabs-line--2x m-tabs-line--warning" role="tablist">
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_tabs_6_1" role="tab">Product details</a>
				</li>
				<li class="nav-item m-tabs__item">
					<a class="nav-link m-tabs__link" data-toggle="tab" href="#m_tabs_6_2" role="tab">Product price</a>
				</li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active show" id="m_tabs_6_1" role="tabpanel">
					<table class="table">
						<tr>
							<td width="20%">
								@foreach($product->images as $image)
								<span id="{{ $image->id }}" >
									<img src="{{ $image->image }}"  width="100" height="100" />
								</span>
								@endforeach
							</td>
							<td>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product name
									</span>
									<span class="col-xl-6">
										:  {{$product->name}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Category
									</span>
									<?php $categories = $product->categories->pluck('category.name')->toArray();  ?>

									<span class="col-xl-6">
										:  {{ (!empty($categories)) ? implode(', ',$categories) : '-' }}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@if(isset($product_chinese->product_name))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product name (Chinese)
									</span>
									<span class="col-xl-6">
										:  {{$product_chinese->product_name}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(isset($product_malay->product_name))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product name (Malay)
									</span>
									<span class="col-xl-6">
										:  {{$product_malay->product_name}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(isset($product_vietnamese->product_name))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product name (Vietnamese)
									</span>
									<span class="col-xl-6">
										:  {{$product_vietnamese->product_name}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(isset($product_thai->product_name))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product name (Thai)
									</span>
									<span class="col-xl-6">
										:  {{$product_thai->product_name}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										SKU code
									</span>
									<span class="col-xl-6">
										:  {{$product->sku}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Seller
									</span>
									<span class="col-xl-6">
										:  {{ ($product->seller->name) }}
									</span>
									<span class="col-xl-4"></span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Description
									</span>
									<span class="col-xl-6">
										:  {{$product->description}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@if(isset($product_chinese->product_description))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Description (Chinese)
									</span>
									<span class="col-xl-6">
										:  {{$product_chinese->product_description}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(isset($product_malay->product_description))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Description (Malay)
									</span>
									<span class="col-xl-6">
										:  {{$product_malay->product_description}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(isset($product_vietnamese->product_description))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Description (Vietnamese)
									</span>
									<span class="col-xl-6">
										:  {{$product_vietnamese->product_description}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(isset($product_thai->product_description))
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Description (Thai)
									</span>
									<span class="col-xl-6">
										:  {{$product_thai->product_description}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								@if(count($productPrices) <= 0)
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product weight (KG)
									</span>
									<span class="col-xl-6">
										:  {{$product->weight}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Product dimension (length * width * height)
									</span>
									<span class="col-xl-6">
										: {{$product->length}} * {{$product->width}} * {{$product->height}}
									</span>
									<span class="col-xl-4"></span>
								</div>
								@endif
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										New arrival
									</span>
									<span class="col-xl-6">
										: @if($product->is_new == 'true')
										Yes
										@else
										No
										@endif
									</span>
									<span class="col-xl-4"></span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Featured product
									</span>
									<span class="col-xl-6">
										: @if($product->is_featured == '1')
										Yes
										@else
										No
										@endif
									</span>
									<span class="col-xl-4"></span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-3 bold" >
										Other product
									</span>
									<span class="col-xl-6">
										: @if($product->is_other == '1')
										Yes
										@else
										No
										@endif
									</span>
									<span class="col-xl-4"></span>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<div class="tab-pane" id="m_tabs_6_2" role="tabpanel">
					@if(count($productPrices) <= 0)
						<div class="row">
							<div class="col-md-6">
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Customer price
									</span>
									<span class="col-xl-6">
										:  RM {{ number_format($product->customer_price,2)}}
									</span>
								</div>
								<!-- <div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Executive price
									</span>
									<span class="col-xl-6">
										:  RM {{ number_format($product->executive_leader_price,2) }}
									</span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Silver price
									</span>
									<span class="col-xl-6">
										: RM {{ number_format($product->silver_leader_price,2)}}
									</span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Gold price
									</span>
									<span class="col-xl-6">
										:  RM {{number_format($product->gold_leader_price,2)}}
									</span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Platinum price
									</span>
									<span class="col-xl-6">
										: RM {{number_format($product->plat_leader_price,2)}}
									</span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Diamond price
									</span>
									<span class="col-xl-6">
										: RM {{number_format($product->diamond_leader_price,2)}}
									</span>
								</div> -->
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Selling price
									</span>
									<span class="col-xl-6">
										: RM {{number_format($product->sell_price,2)}}
									</span>
								</div>
								@if(in_array(Auth::user()->role_id, [1,9]))
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Cost price
									</span>
									<span class="col-xl-6">
										: RM {{number_format($product->cost_price,2)}}
									</span>
								</div>
								@endif
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Quantity
									</span>
									<span class="col-xl-6">
										: {{ number_format($product->qty) }}
									</span>
								</div>
								<!-- <div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Staff price
									</span>
									<span class="col-xl-6">
										: RM {{number_format($product->staff_price,2)}}
									</span>
								</div> -->
							</div>
							<div class="col-md-6">
								@if(count($daynamic_customer_price) > 0)
								<div class="row  mb15 " style="text-align: center;">
									<span class=" col-xl-4 bold" >
										Customer price tier
									</span>
								</div>
								<div class="row  mb15">
									<span class=" col-xl-4 bold" >
										Qty 
									</span>
									<span class=" col-xl-4 bold" >
										Price / Qty
									</span>
									
								</div>
								@foreach($daynamic_customer_price as $price)
								<div class="row  mb15">
									<span class=" col-xl-4 " >
										{{ $price->qty }}
									</span>
									<span class=" col-xl-4 " >
										{{ $price->price }}
									</span>
									
								</div>
								@endforeach
								@endif
							</div>
						</div>
					@else
						<div class="row">
							@foreach($productPrices as $varPrice)
								<div class="col-md-6">
									<span class=" col-xl-6 bold" >
										<?php $variationArray = explode('_', $varPrice->variation_value_text);
										?>
										@foreach($variationArray as $key => $var)
											{{ $variationArray[$key]}}
											@if(count($variationArray) > $key+1) , @endif
										@endforeach
									</span>
									<br>
									<br>

									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Product weight (KG)
										</span>
										<span class="col-xl-6">
											:  {{$varPrice->weight}}
										</span>
										<span class="col-xl-4"></span>
									</div>
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Product dimension (length * width * height)
										</span>
										<span class="col-xl-6">
											: {{$varPrice->length}} * {{$varPrice->width}} * {{$varPrice->height}}
										</span>
										<span class="col-xl-4"></span>
									</div>
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Customer price
										</span>
										<span class="col-xl-6">
											:  RM {{ number_format($varPrice->customer_price,2)}}
										</span>
									</div>
									<!-- <div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Executive price
										</span>
										<span class="col-xl-6">
											:  RM {{ number_format($varPrice->executive_leader_price,2) }}
										</span>
									</div>
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Silver price
										</span>
										<span class="col-xl-6">
											: RM {{ number_format($varPrice->silver_leader_price,2)}}
										</span>
									</div>
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Gold price
										</span>
										<span class="col-xl-6">
											:  RM {{number_format($varPrice->gold_leader_price,2)}}
										</span>
									</div>
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Platinum price
										</span>
										<span class="col-xl-6">
											: RM {{number_format($varPrice->plat_leader_price,2)}}
										</span>
									</div>
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Diamond price
										</span>
										<span class="col-xl-6">
											: RM {{number_format($varPrice->diamond_leader_price,2)}}
										</span>
									</div> -->
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Selling price
										</span>
										<span class="col-xl-6">
											: RM {{number_format($varPrice->sell_price,2)}}
										</span>
									</div>
									@if(in_array(Auth::user()->role_id, [1,9]))
									<div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Cost price
										</span>
										<span class="col-xl-6">
											: RM {{number_format($varPrice->cost_price,2)}}
										</span>
									</div>
									@endif
									<div class="row  mb15">
									<span class=" col-xl-4 bold" >
											Quantity
										</span>
										<span class="col-xl-6">
											: {{ number_format($varPrice->qty) }}
										</span>
									</div>
									<!-- <div class="row  mb15">
										<span class=" col-xl-4 bold" >
											Staff price
										</span>
										<span class="col-xl-6">
											: RM {{number_format($varPrice->staff_price,2)}}
										</span>
									</div> -->
								</div>
							@endforeach
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
