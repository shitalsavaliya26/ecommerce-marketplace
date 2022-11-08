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
						<span class="m-nav__link-text">Followers</span>
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
					<h3 class="m-portlet__head-text"> Followers</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools"></div>
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
							<th width="10%">User Name</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody>
						@if(count($followers) == 0)
						<tr>
							<td colspan="6" style="text-align:center;">No record found</td>
						</tr>
						@else
                            @foreach($followers as $follower)
                                <tr>
                                    <td> {{ $follower->user->name }} </td>
                                    <td>
                                        <span class="dropdown">
                                                <a class="dropdown-item delete-follower" href="javascript::void(0)" data-url="{{ route('seller.followers.destroy', [$follower->id]) }}">Remove Follower</a>
                                            </div>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
					</tbody>
				</table>
			</div>
			{{ $followers->appends(\Request::all())->render()}}
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	jQuery(document).ready(function() {
		$('.delete-follower').click(function(e){
			var url = $(this).data('url');
			bootbox.confirm("Are you sure you want to remove this follower?", function(result){
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
