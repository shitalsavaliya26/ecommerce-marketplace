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
						<span class="m-nav__link-text">Vouchers</span>
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
					<h3 class="m-portlet__head-text"> Vouchers</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<div class="col col-md-3  m--align-right">
					<a href="{{ route('seller.vouchers.create') }}" class="btn btn-primary  m-btn m-btn--sm ">
						<span class="font12">Add Voucher</span>
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
			<div class="table-responsive">
				<table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="m_table_1">
					<thead>
						<tr>
							<th width="10%">Type</th>
							<th width="15%">Name</th>
							<th width="10%">Code</th>
							<th width="20%">Date Period</th>
							<th width="15%">Display Voucher Early</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@if(count($vouchers) == 0)
						<tr>
							<td colspan="6" style="text-align:center;">No record found</td>
						</tr>
						@else
                            @foreach($vouchers as $voucher)
                                <tr>
                                    <td> {{ $voucher->type == 'seller' ? 'Seller Voucher' : 'Product Voucher' }} </td>
                                    <td> {{ $voucher->name }} </td>
                                    <td> {{ $voucher->code }} </td>

									<?php
									$toDate = date_create($voucher->to_date);
									$fromDate = date_create($voucher->from_date);
									$diff1 = date_diff($toDate,$fromDate);
									$daysdiff = $diff1->format("%R%a");
									$daysdiff = abs($daysdiff); 
									?>
									<td>{{ ($voucher->from_date != '') ? date('d-m-Y H:i', strtotime($voucher->from_date)) : ''}} {{ ($voucher->to_date != '') ? '- '. date('d-m-Y H:i', strtotime($voucher->to_date)) : '' }} 
										<br>
										Days - {{$daysdiff}}</td>
                                    <td> {{ $voucher->display_voucher_early != '0' ? 'Yes' : 'No'}} </td>
                                    <td>
                                        <span class="dropdown">
                                            <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
                                                <i class="la la-ellipsis-h"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
                                                <a class="dropdown-item" href="{{ route('seller.vouchers.edit', [$voucher->id]) }}">Edit</a>
                                                <a class="dropdown-item delete-voucher" href="javascript::void(0)" data-url="{{ route('seller.vouchers.destroy', [$voucher->id]) }}">Delete</a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
					</tbody>
				</table>
			</div>
			{{ $vouchers->appends(\Request::all())->render()}}
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	jQuery(document).ready(function() {
		$('.delete-voucher').click(function(e){
			var url = $(this).data('url');
			bootbox.confirm("Are you sure you want to delete this voucher?", function(result){
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
