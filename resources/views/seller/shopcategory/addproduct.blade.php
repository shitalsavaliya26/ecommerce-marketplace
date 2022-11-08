@extends('seller.layouts.main')
@section('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endsection
@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="{{ url('/') }}" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="{{ route('seller.shop_categories.index')}}" class="m-nav__link">
                            <span class="m-nav__link-text">Display category</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">-</li>
                    <li class="m-nav__item">
                        <a href="" class="m-nav__link">
                            <span class="m-nav__link-text">Display category product</span>
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
                            Add display category product
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="row" id="app_massges">
                    @if (\Session::has('success'))
                        <div class="col-xl-12 m-section__content toast-container ">
                            <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show"
                                role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                </button>
                                <strong> {!! \Session::get('success') !!}</strong>
                            </div>
                        </div>
                    @endif
                    @if (\Session::has('error'))
                        <div class="col-xl-12 m-section__content">
                            <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show"
                                role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                </button>
                                <strong> {!! \Session::get('error') !!}</strong>
                            </div>
                        </div>
                    @endif
                </div>
                <form action="{{ route('seller.shop-categories.store-product')}} " method="post" id="add_category_product_form">
                    {{ csrf_field() }}
                    <input type="hidden" name="categoryId" id="categoryId" value="{{ $categoryId }}">
                    <div class="m-portlet__body">
                        <div class="form-group m-form__group row">
							<div class="col-lg-6 form-group m-form__group " id="product-div">
								<label for="qty">Products </label>
								<div class="m-input-icon m-input-icon--right">
									<select class="form-control m-bootstrap-select m_selectpicker"
										data-live-search="true" multiple="multiple"
										name="product[]" id="product">
										@foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            @if (in_array($product->id, $productIdsOfCategory)) selected="selected"  @endif>{{ $product->name }}
                                        </option>
										@endforeach
									</select>
								</div>
                                <div id="div-error"></div>
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
                                        <a href="{{ route('seller.shop_categories.index')}}" class="btn btn-secondary font12">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="m-portlet__body m_datatable m-datatable m-datatable--default m-datatable--loaded  ">
            <div style="height: 40px;">
                <button style="display:none" class="btn btn-primary btn-send-request font12 delete_all" >Delete All Selected</button>
            </div>
            <div class="table-responsive">
                <table class="table table-striped- table-hover table-checkable dataTable no-footer dtr-inline collapsed " id="sortable">
                    <thead>
                        <tr class="row_name">
                            @if(count($productsOfCategory) > 0)
                                <th width="3%">
                                    <input type="checkbox" id="master" class="cat_chk">
                                </th>
                            @endif
                            <th width="10%">Name</th>
                            <th width="10%">Price</th>
                            <th width="10%">Qty</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="row_position">
                        @if(count($productsOfCategory) > 0)
                            @foreach($productsOfCategory as $category)
                                @if($category->product )
                                    <tr>
                                        <td> <input type="checkbox" class="sub_chk cat_chk" data-id="{{$category->id}}"> </td>
                                        <td> {{ $category->product->name }}</td>
                                        <td> {{($category->product->is_variation == '1' && $category->product->variation) ? number_format($category->product->variation->sell_price,2) : number_format($category->product->sell_price, 2) }} </td>
                                        <td> {{($category->product->is_variation == '1' && $category->product->variation) ? $category->product->variation->qty : $category->product->qty }} </td>
                                        <td nowrap>
                                            <span class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" id="deleteProduct" data-id="{{App\Helpers\Helper::encrypt($category->id)}}">
                                                <i class="la la-close"></i>
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" style="text-align:center;">No record found</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function() {
		$('.m_selectpicker').selectpicker();

        $("#add_category_product_form").validate({
            rules: {
                "product[]": {
                    required: true,
                }
            },
            messages: {
                "product[]": {
                    required: "Please select product."
                },
            },
            errorPlacement: function(error, element) {
                error.appendTo('#div-error');
            }
        });

        $(document).on('click', '#deleteProduct', function() {
            id = $(this).data('id');
            bootbox.confirm("Are you sure you want to delete this product from this shop category ?", function(result){
                if(result == true){
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ route('seller.shop_categories.delete_product') }}",
                        data: {'id': id},
                        success: function(response){
                            $(".row_position").load(location.href+" .row_position>*","");
                            $("#product-div").load(location.href+" #product-div>*","");
                        }
                    });
                }
            });
        });
	});

    $(document).on('click', '#master', function() {
        if($(this).is(':checked',true)){
            $(".sub_chk").prop('checked', true);
        } else {
            $(".sub_chk").prop('checked',false);
        }
    });

    $(document).on('change', '.cat_chk', function() {
        var totalCheckboxes = $('.sub_chk').length;
        var allVals = [];

        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });

        var totalCheckedCheckboxes = allVals.length;

        if(allVals.length > 0){
            $('.delete_all').css('display','block');
        }else{
            $('.delete_all').css('display','none');
        }
        if(totalCheckedCheckboxes == totalCheckboxes){
            $("#master").prop('checked', true);
        }else{
            $("#master").prop('checked', false);
        }
    });

    $(document).on('click', '.delete_all', function() {
        var allVals = [];
        var categoryId = "{{isset($categoryId) ? $categoryId : ''}}";

        $(".sub_chk:checked").each(function() {
            allVals.push($(this).attr('data-id'));
        });

        bootbox.confirm("Are you sure you want to delete these products from this shop category ?", function(result){
            if(result == true){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{route('seller.shop_categories.delete_product')}}",
                    data:{
                        product_ids:allVals,
                        categoryId:categoryId,
                        type: 'multi'
                    },
                    success: (response) => {
                        $(".row_position").load(location.href+" .row_position>*","");
                        $("#product-div").load(location.href+" #product-div>*","");
                        $(".row_name").load(location.href+" .row_name>*","");
                        $('.delete_all').css('display','none');
                    },
                    error: function (data) {
                        $(".row_position").load(location.href+" .row_position>*","");
                        $("#product-div").load(location.href+" #product-div>*","");
                        $(".row_name").load(location.href+" .row_name>*","");
                        $('.delete_all').css('display','none');
                    }
                });
            }
        });
       
    });

    $(document).ajaxComplete(function() {
		$('.m_selectpicker').selectpicker('refresh');
	});
</script>
@endsection
