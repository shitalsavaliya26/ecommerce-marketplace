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
					<a href="" class="m-nav__link">
						<span class="m-nav__link-text">Attribute Variation</span>
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
						Attribute Variation
					</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<div class="col col-md-3  m--align-right">
					<a href="{{ route('variations.create') }}" class="btn btn-primary  m-btn m-btn--sm ">
						<span class="font12">Add Attribute Variation</span>
					</a>
				</div>
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
			<form method="get" id="searchForm" action="{{ route('variations.index') }}">
				<div class="row">

				</div>
			</form>
			<div class="table-responsive">
				<table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
					<thead>
						<tr>
							<th>Product</th>
							<th>Attribute</th>
							<th>Variation</th>
							<th>Price</th>
						</tr>
					</thead>
					<tbody>
						@if(count($variations) == 0)
						<tr>
							<td colspan="6" style="text-align:center;">No record found</td>
						</tr>
						@endif
						@foreach($variations as $variation)
						<tr>
							<td>{{ $variation->product->name}}</td>
							<td>{{ $variation->attribute->name}}</td>
							<td>{{ $variation->variation_value}}</td>
							<td>{{ $variation->price}}</td>
							<td nowrap>
								<span class="dropdown">
									<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
										<i class="la la-ellipsis-h"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
										{{--   @if(Auth::user()->role_id == 1) --}}
										<a class="dropdown-item" href="{{ route('variations.edit', [$variation->id]) }}">Edit</a>
										<a class="dropdown-item delete-variation" href="javascript::void(0)" data-url="{{ route('variations.destroy', [$variation->id]) }}">Delete</a>
										{{--  @endif --}}
									</div>
								</span>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			{{ $variations->appends(\Request::all())->render() }}
		</div>
		<script>
			jQuery(document).ready(function() {
				$('.delete-variation').click(function(e){
					var url = $(this).data('url');
					bootbox.confirm("Are you sure you want to delete this variation ?", function(result){
						if(result == true){
							$.ajax({
								type:'DELETE',
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
	</div>
</div>

@endsection
