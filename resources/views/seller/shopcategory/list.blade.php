@extends('seller.layouts.main')
@section('css')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style>
	.trigger {
		cursor: pointer;
	}
	.trigger .editIcon {
		display: none;
	}
	.trigger:hover .editIcon {
		display: inline;
		position: relative;
	}
</style>
@endsection
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
						<span class="m-nav__link-text">Shop Categories</span>
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
					<h3 class="m-portlet__head-text"> Shop Categories</h3>
				</div>
			</div>
			<div class="m-portlet__head-tools">
				<span class="font12" style="margin-right: 10px;">
					<a href="{{ route('shopDetail', auth()->user()->referal_code) }}" target="_blank" class="btn btn-primary  m-btn m-btn--sm ">
						<span class="font12">
							<i class="la la-eye"></i> Preview
						</span>
					</a>
				</span>
				<span class="font12">
					<button class="btn btn-primary m-btn m-btn--custom m-btn--air"
						data-toggle="modal" data-target="#modalShopCategoryForm">
						<span class="font12">
							<i class="la la-plus"></i>Add Shop Category
						</span>
					</button>
				</span>
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
				<table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="sortable">
					<thead>
						<tr class="ui-state-default">
							<th width="10%">Category Display Name</th>
							<th width="10%">Products</th>
							<th width="10%">Display On/Off</th>
							<th width="10%">Actions</th>
						</tr>
					</thead>
					<tbody class="row_position">
						@if(count($shopCategories) == 0)
						<tr>
							<td colspan="6" style="text-align:center;">No record found</td>
						</tr>
						@else
                            @foreach($shopCategories as $category)
                                <tr data-id="{{$category->id}}">
                                    <!-- <td> {{ $category->display_name }} </td> -->
									<td class="trigger" id="trigger_{{$category->id}}">
										<span id="td_{{$category->id}}">
											{{ $category->display_name }}
										</span>
										<span class="editIcon" id="{{$category->id}}">
											<i class="la la-pencil"></i>
										</span>
										<span class="display_input" id="cat_{{$category->id}}" style="display: none;">
											<input type="text" name="display_name" id="category_{{$category->id}}" value="{{$category->display_name}}" >
											<i id="update_name" class="la la-check" data-id="{{$category->id}}"></i>
											<i id="close_update_name" class="la la-close" data-id="{{$category->id}}"></i>
										</span>
									</td>
                                    <td> {{$category->products && count($category->products) > 0 ? count($category->products) : 0}}</td>
									<td>
										<input data-id="{{$category->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="On" data-off="Off" {{ $category->display == '1' ? 'checked' : '' }}
										{{$category->products && count($category->products) <= 0 ? 'disabled': ''}}>
									</td>
									<td nowrap>
										<span class="dropdown">
											<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="false">
												<i class="la la-ellipsis-h"></i>
											</a>
											<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 5px, 0px);" x-out-of-boundaries="">
												<a class="dropdown-item" href="{{ route('seller.shop-categories.add-product', [Helper::encrypt($category->id)]) }}">Add Products</a>
												<a class="dropdown-item delete-category" href="javascript::void(0)" data-url="{{ route('seller.shop-categories.destroy', [App\Helpers\Helper::encrypt($category->id)]) }}">Delete</a>
											</div>
										</span>
									</td>
								</tr>
                            @endforeach
                        @endif
					</tbody>
				</table>
			</div>
			{{ $shopCategories->appends(\Request::all())->render()}}
		</div>
	</div>
</div>

<div class="modal fade" id="modalShopCategoryForm" tabindex="-1" role="dialog" aria-labelledby="newticketsLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title inline" id="exampleModalLabel">{{trans('label.add_category')}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" id="address-form">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <div class="form-group">
                                <div class="from-inner-space">
                                    <label class="mb-2 bmd-label-static">
                                        {{trans('label.category_display_name')}}: <span class="text-red">*</span>
                                    </label>
                                    <div class="form-element">
                                        <input class="form-control" type="text" placeholder="{{trans('label.enter_category_display_name')}}"
                                        name="name" id="name" title="{{trans('label.please_enter_full_name')}}" autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group row">
                        <div class="col-lg-12 form-group-sub">
                            <button type="submit" class="cus-width-auto cus-btn cus-btnbg-red btn btn-primary"
                            id="address-button">{{trans('label.save')}}</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script>
   	$(function() {
		$('.toggle-class').change(function() {
			var display = $(this).prop('checked') == true ? 1 : 0;
			var category_id = $(this).data('id');
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "{{ route('seller.shop_categories.update_display') }}",
				data: {'display': display, 'category_id': category_id},
			});
		})
	});

	$('.delete-category').click(function(e){
		var url = $(this).data('url');
		bootbox.confirm("Are you sure you want to delete this shop category ?", function(result){
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

	$(document).on('click', '.editIcon', function() {
		id = $(this).attr('id');
		document.getElementById(id).style.display = 'none';
		showText = 'cat_'+id;
		document.getElementById(showText).style.display = 'block';
		hideTd = 'td_'+id;
		document.getElementById(hideTd).style.display = 'none';
	});

	$(document).on('click', '#update_name', function() {
		id = $(this).attr('data-id');
		inputName = 'category_'+id;
		var displayName = $('#'+inputName).val();
		$.ajax({
			type: "GET",
			dataType: "json",
			url: "{{ route('seller.shop_categories.update_display_name') }}",
			data: {'id': id, 'displayName': displayName},
		});
		loadTD ='#trigger_'+id;
		$(loadTD).load(location.href+" "+loadTD+">*","");
	});

	$(document).on('click', '#close_update_name', function() {
		id = $(this).attr('data-id');
		loadTD ='#trigger_'+id;
		$(loadTD).load(location.href+" "+loadTD+">*","");
	});

	$("#address-form").validate({
		rules: {
			name: {
				required: true,
				maxlength: 40
			},
		},
		messages: {
			name: {
				required: "Please enter Category Display Name",
				maxlength: "You can enter maximum 40 characters."
			},
		},
		submitHandler: function (form) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var postData = $(form).serializeArray();
			$.ajax({
				type: "POST",
				url: "{{route('seller.shop-categories.store')}}",
				data: postData,
				success: (response) => {
					if (response) {
						$(".row_position").load(location.href+" .row_position>*","");
					}
				},
				error: function (data) {
					$(".row_position").load(location.href+" .row_position>*","");
				}
			});
			$('#modalShopCategoryForm').modal('hide');

			$('#modalShopCategoryForm').on('hidden.bs.modal', function () {
				$(this).find('form').trigger('reset');
			})
		}
	});

	$(document).ajaxComplete(function() {
		$('input[type=checkbox][data-toggle^=toggle]').bootstrapToggle();
	});

	$('#modalShopCategoryForm').on('hidden.bs.modal', function () {
		$(this).find('form').trigger('reset');
	});

	$("#sortable tbody").sortable({
		cursor: "move",
		placeholder: "sortable-placeholder",
		helper: function(e, tr)
		{
			var $originals = tr.children();
			var $helper = tr.clone();
			$helper.children().each(function(index)
			{
			// Set helper cell sizes to match the original sizes
			$(this).width($originals.eq(index).width());
			});
			return $helper;
		},
		update  : function(event, section) {
			var category_ids = new Array();
			$('.row_position>tr').each(function() {
				category_ids.push($(this).data("id"));
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': '{{ csrf_token() }}'
				}
			});

			$.ajax({
				url:'{{route('seller.shop_categories.update_sequence_of_shop_category')}}',
				method:"POST",
				data:{
					category_ids:category_ids,
				},
				success:function(data){

				}
			});
		}
	}).disableSelection();
</script>
@endsection
