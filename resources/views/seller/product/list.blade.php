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
					<a href="" class="m-nav__link">
						<span class="m-nav__link-text">Products</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- END: Subheader -->
<div class="m-content">
	<div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 no-footer">
		<div class="m-portlet__head">
			<div class="m-portlet__head-caption">
				<div class="m-portlet__head-title">
					<h3 class="m-portlet__head-text">
						Products
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools col-md-1 align-right">
				<a  href="{{ route('seller.products.create') }}" class="btn btn-primary m-btn m-btn--custom m-btn--air">
					<span>
						<span class="font12">Add product</span>
					</span>
				</a>
			</div>
		</div>
		<div class="m-portlet__body m_datatable m-datatable m-datatable--default m-datatable--loaded  ">
			@if (\Session::has('success'))
			<div class="m-section__content">
				<div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					</button>
					<strong> {!! \Session::get('success') !!}</strong>
				</div>
			</div>
			@endif
			@if (\Session::has('error'))
			<div class="m-section__content">
				<div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					</button>
					<strong> {!! \Session::get('error') !!}</strong>
				</div>
			</div>
			@endif
			<div class="row">
				<div class="col-md-5">
				</div>

				<div class="col-md-2">
					<form method="get" id="searchForm" action="">
						<div class="m-input-icon m-input-icon--left">
							<input type="text" class="form-control m-input" placeholder="Search..." id="generalSearch" name="search" value="{{ $search }}">
							<span class="m-input-icon__icon m-input-icon__icon--left">
								<span><i class="la la-search"></i></span>
							</span>
						</div>
					</div>

					<div class="col-lg-2 form-group m-form__group ">
						<select class="form-control m-input" name="status">
							<option value="" >Select status</option>
							<option value="active" {{(request()->status == 'active')?'selected':''}}>Active</option>
							<option value="inactive" {{(request()->status == 'inactive')?'selected':''}}>InActive</option>
						</select>
					</div>


					<div class="col-md-2 align-right">
						<button  type="submit" class="btn btn-primary m-btn m-btn--custom m-btn--air">
							<span>
								<span class="font12">Go</span>
							</span>
						</button>
						<button  type="reset" id="resetButon" class="btn btn-default m-btn m-btn--custom m-btn--air">
							<i class="la la-refresh"></i>
						</button>
						<div class="m-separator m-separator--dashed d-xl-none"></div>
					</form>
				</div>

			</div>
			<div class="table-responsive">
				<table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
					<thead>
						<tr>
							<th>Product name</th>
							<th>Category</th>
							<th>SKU</th>
							<th>Seller</th>
							<th>Status</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						@if(count($products) == 0)
						<tr>
							<td colspan="6" style="text-align:center;">No record found</td>
						</tr>
						@endif
						@foreach($products as $product)
						<tr>
							<td><a class="linkremove" href="{{ route('seller.products.show', [App\Helpers\Helper::encrypt($product->id)]) }}">{{ $product->name}}</a></td>
							<?php $categories = $product->categories->pluck('category.name')->toArray();  ?>
							
							<td>{{ (!empty($categories)) ? implode(', ',$categories) : '-' }}</td>
							<td>{{ $product->sku }}</td>
							<td>{{ ($product->seller) ? $product->seller->name : '' }}</td>
							<td>
								@if($product->status == 'active')
								<span class="text-success">Active</span> 
								@else
								<span class="text-danger">InActive</span> 
								@endif
							</td>
							<td nowrap>
								<span class="dropdown">
									<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
										<i class="la la-ellipsis-h"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
										<a class="dropdown-item" href="{{ route('seller.products.edit', [App\Helpers\Helper::encrypt($product->id)]) }}">Edit</a>
										<a class="dropdown-item delete-product" href="javascript::void(0)" data-url="{{ route('seller.products.destroy', [App\Helpers\Helper::encrypt($product->id)]) }}">Delete</a>
									</div>
								</span>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			{{ $products->appends(\Request::all())->render() }}
		</div>
		<script>
			jQuery(document).ready(function() {
				$('.delete-product').click(function(e){
					var url = $(this).data('url');
					bootbox.confirm("Are you sure you want to delete this product ?", function(result){
						if(result == true){
							$.ajax({
								type:'delete',
								url:url,
								data:{},
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								success: function(response){
									$(window).scrollTop(0);
									window.location.reload();
								}
							});
						}
					});
				}); 
			});  
		</script>

		@endsection
