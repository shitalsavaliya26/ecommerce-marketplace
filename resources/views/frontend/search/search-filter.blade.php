@extends('layouts.main')
@section('title', 'Search')
@section('content')
    <section class="bg-gray py-4">
        <div class="container">
            <!-- <div class="row">
                <div class="col-12">
                    <img src="assets/images/banner img.png" class="img-fluid br-15" alt="">
                </div>
            </div> -->

            <!-- <div class="row mt-4 bg-white br-15 p-4 px-xl-5 mx-0 align-items-center overflow-hidden shadow">
                <div class="col-12">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/images/mall.png')}}" class="img-fluid max-w-70px mr-3" alt="">
                        <h4 class="text-black font-18 font-GilroyBold mb-0">Maxshop Mall</h4>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/sony.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/Nike.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/sony.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/Nike.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/sony.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/Nike.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/sony.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/Nike.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/sony.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/Nike.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/sony.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/Nike.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>


                <div class="col-12 mt-5 mb-2">
                    <h4 class="text-black font-18 font-GilroyBold">Shop By Brands</h4>
                </div>

                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/headphones.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/headphones.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/headphones.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/headphones.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/headphones.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 text-center mt-3">
                    <div>
                        <img src="{{asset('assets/images/headphones.png')}}" class="img-fluid max-w-100px" alt="">
                    </div>
                </div>
            </div> -->

            <!--  <div class="row mt-4 bg-white br-15 p-4 pb-5 px-xl-5 mx-0 align-items-center overflow-hidden shadow">
                <div class="col-12">
                    <h4 class="text-black font-18 font-GilroyBold mb-0">Featured Collection</h4>
                </div>

                <div class="col-12 col-sm-6 col-md-4 col-xl-auto text-center mt-4">
                    <img src="assets/images/Featured1.png" class="img-fluid max-w-150px" alt="">
                    <h4 class="text-black font-14 font-GilroySemiBold mt-3">Up to 60% OFF</h4>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-xl-auto text-center mt-4">
                    <img src="assets/images/Featured2.png" class="img-fluid max-w-150px" alt="">
                    <h4 class="text-black font-14 font-GilroySemiBold mt-3">Free Shipping</h4>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-xl-auto text-center mt-4">
                    <img src="assets/images/Featured3.png" class="img-fluid max-w-150px" alt="">
                    <h4 class="text-black font-14 font-GilroySemiBold mt-3">Coins Cashback</h4>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-xl-auto text-center mt-4">
                    <img src="assets/images/Featured4.png" class="img-fluid max-w-150px" alt="">
                    <h4 class="text-black font-14 font-GilroySemiBold mt-3">Below RM25</h4>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-xl-auto text-center mt-4">
                    <img src="assets/images/Featured5.png" class="img-fluid max-w-150px" alt="">
                    <h4 class="text-black font-14 font-GilroySemiBold mt-3">Fullfill by Maxshop</h4>
                </div>
            </div> -->

            <div class="row mt-4">
                <div class="col-12 col-lg-4 col-xl-3">
                    <div class="row mr-lg-4 mx-0 br-15 shadow overflow-hidden">
                        <div class="col-12 bg-dark-blue py-3 text-center">
                            <h4 class="text-white font-24 mb-0 font-GilroyBold">{{trans('label.search_filter')}}</h4>
                        </div>
                        <?php
                                $brandId = [];
                                $searchParam = [];
                                $prices = [];
                                $categoryId = [];
                                $brandId = (request()->get('brands') && gettype(request()->get('brands')) == 'array') ? array_values(request()->get('brands')) : [];
                                $searchParam = (request()->get('searchParam') && gettype(request()->get('searchParam')) == 'array') ? array_values(request()->get('searchParam')) : [];
                                $prices = (request()->get('prices') && gettype(request()->get('prices')) == 'array') ? array_values(request()->get('prices')) : [];
                                $categoryId = (request()->get('categories') && gettype(request()->get('categories')) == 'array') ? array_values(request()->get('categories')) : [];
                            ?>
                        <div class="col-12 bg-white">
                            <form id="price-range-form">
                                <div class="px-2 py-3">
                                    <h4 class="text-black font-18 font-GilroyBold">{{trans('label.price_range')}}</h4>
                                    <div class="d-flex">
                                        <input type="number" class="form-control price-range-border rounded-0 bg-transparent text-center cus-input-ph" name="min_price" id="min_price" placeholder="RM MIN" min="1" value="{{request()->get('min_price') ? app('request')->input('min_price') : ($prices && count($prices) > 0 ? $prices[0] : 1) }}">
                                        <div class="mx-2 price-range-line"></div>
                                        <input type="number" class="form-control price-range-border rounded-0 bg-transparent text-center cus-input-ph" name="max_price" id="max_price" placeholder="RM MAX" min="1" value="{{request()->get('max_price') ? app('request')->input('max_price') : ($prices && count($prices) > 0 ? $prices[1] : 10000) }}">
                                    </div>
                                </div>
                                <div class="errorTxt"></div>
                                <input name="search" type="hidden" value="{{request()->get('search') ? app('request')->input('search') : ($searchParam && count($searchParam) > 0 ? $searchParam[0] : '') }}">
                                <button class="btn btn-block bg-orange orange-btn text-white br-8 font-16 py-1 mb-4 font-GilroyMedium">{{trans('label.apply')}}</button>
                            </form>
                        </div>
                    </div>
                    <div class="row mr-lg-4 mx-0 px-2 py-3 br-15 bg-white shadow overflow-hidden mt-3">
                        <div class="col-12">
                            <h4 class="text-black font-18 font-GilroyBold">{{trans('label.brands')}}</h4>
                        </div>
                        <div class="col-12 mt-1" id="myBrand">
                            @foreach($brands as $brand)
                                <div class="custom-control custom-checkbox searchFilter-checkbox mt-2 brandList">
                                    <input type="checkbox" class="custom-control-input" id="{{$brand->name}}_{{$brand->id}}" name="brands[]" value="{{$brand->id}}"
                                        @if (count($brandId) > 0 && in_array($brand->id, $brandId[0]) || (isset($_GET['search']) && ($_GET['search'] == $brand->name || $_GET['search'] == $brand->name)) ) checked @endif>
                                    <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                        for="{{$brand->name}}_{{$brand->id}}">{{$brand->name}}</label>
                                </div>
                            @endforeach
                            @if($brands && count($brands) > 4)
                            <div class="" id="MoreBrand">
                                <div class="d-flex align-items-center mt-3 ml-3 cursor-pointer">
                                    <h4 class="text-black2 font-16 font-GilroySemiBold mb-0">{{trans('label.more')}}</h4>
                                    <img src="assets/images/down-arrow.png" class="img-fluid max-w-10px ml-3 mt-1"
                                        alt="">
                                </div>
                            </div>
                            <div class="d-none" id="LessBrand">
                                <div class="d-flex align-items-center mt-3 ml-3 cursor-pointer">
                                    <h4 class="text-black2 font-16 font-GilroySemiBold mb-0">{{trans('label.less')}}</h4>
                                    <img src="assets/images/down-arrow.png"
                                        class="img-fluid max-w-10px ml-3 mt-1 rotate-180" alt="">
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mr-lg-4 mx-0 px-2 py-3 br-15 bg-white shadow overflow-hidden mt-3">
                        <div class="col-12">
                            <h4 class="text-black font-18 font-GilroyBold">{{trans('label.by_categories')}}</h4>
                        </div>
                        <div class="col-12 mt-1" id="myCategory">
                            @php $dashes = ' &nbsp;&nbsp;&nbsp; ' @endphp
                            @foreach($categories as $category)
                                <div class="custom-control custom-checkbox searchFilter-checkbox mt-2 categoryList">
                                    <input type="checkbox" class="custom-control-input" id="category_{{$category->id}}" name="categories[]" value="{{$category->id}}" @if(isset($_GET['search']) && ($_GET['search'] == $category->slug || $_GET['search'] == $category->name) || $slug == $category->slug) checked @endif
                                    @if (count($categoryId) > 0 && in_array($category->id, $categoryId[0])) checked @endif>
                                    <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                        for="category_{{$category->id}}">{{$category->name}}</label>
                                    @php $newDashes = $dashes . '  &nbsp;&nbsp;&nbsp; ' @endphp
                                    @foreach ($category->subs as $sub)
                                        @include('frontend/search/subcategories', ['cat' => $sub, 'dashes' => $newDashes,'parent_id' => ''] )
                                    @endforeach
                                </div>
                            @endforeach
                            <div class="" id="MoreCategory">
                                <div class="d-flex align-items-center mt-3 ml-3 cursor-pointer">
                                    <h4 class="text-black2 font-16 font-GilroySemiBold mb-0">{{trans('label.more')}}</h4>
                                    <img src="assets/images/down-arrow.png" class="img-fluid max-w-10px ml-3 mt-1"
                                        alt="">
                                </div>
                            </div>
                            <div class="d-none" id="LessCategory">
                                <div class="d-flex align-items-center mt-3 ml-3 cursor-pointer">
                                    <h4 class="text-black2 font-16 font-GilroySemiBold mb-0">{{trans('label.less')}}</h4>
                                    <img src="assets/images/down-arrow.png"
                                        class="img-fluid max-w-10px ml-3 mt-1 rotate-180" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mr-lg-4 mx-0 px-2 py-3 br-15 bg-white shadow overflow-hidden mt-3">
                        <div class="col-12">
                            <h4 class="text-black font-18 font-GilroyBold">{{trans('label.services_promotion')}}</h4>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="RM15">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="RM15">RM15 {{trans('label.free_delivery')}}</label>
                            </div>
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="RM10">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="RM10">10% {{trans('label.cashback')}} </label>
                            </div>
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="RM25">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="RM25">25% {{trans('label.cashback')}} </label>
                            </div>
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="RMN">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="RMN">{{trans('label.next_day_delivery')}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mr-lg-4 mx-0 br-15 shadow overflow-hidden mt-3">
                        <div class="col-12 px-0">
                            <img src="{{asset('assets/images/adidas-logo.png')}}" class="img-fluid w-100" alt="">
                        </div>
                    </div>

                    <div class="row mr-lg-4 mx-0 px-2 py-3 br-15 bg-white shadow overflow-hidden mt-3">
                        <div class="col-12">
                            <h4 class="text-black font-18 font-GilroyBold">{{trans('label.payment_options')}}</h4>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="cash">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="cash">{{trans('label.cash_on_delivery')}}</label>
                            </div>
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="installment">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="installment">{{trans('label.installment')}}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mr-lg-4 mx-0 px-2 py-3 br-15 bg-white shadow overflow-hidden mt-3">
                        <div class="col-12">
                            <h4 class="text-black font-18 font-GilroyBold">{{trans('label.shipping_options')}}</h4>
                        </div>
                        <div class="col-12 mt-1">
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="standard">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="standard">{{trans('label.standard_delivery')}}</label>
                            </div>
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="economy">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="economy">{{trans('label.economy_delivery')}}</label>
                            </div>
                            <div class="custom-control custom-checkbox searchFilter-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="self">
                                <label class="custom-control-label text-gray font-GilroyMedium font-16 pl-2"
                                    for="self">{{trans('label.self_collection')}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8 col-xl-9 mt-4 mt-lg-0 pl-xl-0">
                    <div class="">
                        <p class="text-black-2 font-18 mb-0 font-GilroyMedium">{{trans('label.search_result_for')}} <span
                            class="text-orange font-GilroyBold">‘{{request()->get('search') ? app('request')->input('search') : ($searchParam && count($searchParam) > 0 ? $searchParam[0] : '') }}’</span></p>
                        <div id="search-data" class="col-12">
                            @include('frontend.search.table',$products)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
    let searchParams = new URLSearchParams(window.location.search)
    let param = searchParams.get('search');

    $('#MoreCategory').click(function () {
        data = {!! str_replace("'", "\'", json_encode($categories)) !!};
        $('#myCategory .categoryList:lt('+ data.length+')').show();
        $(this).addClass('d-none');
        $('#LessCategory').removeClass('d-none');
    });
            
    $.validator.addMethod("greaterThan", function (value, element, param) {
        var $min = $(param);
        return parseInt(value) > parseInt($min.val());
    }, "Max price must be greater than min price");

    $('#price-range-form').validate({
        rules: {
            max_price: {
                greaterThan: '#min_price'
            }
        },
        errorElement : 'div',
        errorLabelContainer: '.errorTxt'
    });

    $("#price-range").click(function(){
        // var minPrice = $('#min_price').val();
        // var maxPrice = $('#max_price').val();

        // var data;

        // data = {
        //     'min_price' : minPrice,
        //     'max_price' : maxPrice,
        //     'search'   : param
        // }
        // serachData(data);
        filterData()
    });

    var brands = [];
    $("input[name='brands[]']").change(function() {
        var checked = $(this).val();

        if ($(this).is(':checked')) {
            brands.push(checked);
        }else{
            brands.splice($.inArray(checked, brands),1);
        }
        filterData();

    });

    var categories = [];
    $("input[name='categories[]']").change(function() {
        var checked = $(this).val();
        if ($(this).is(':checked')) {
            categories.push(checked);
        }else{
            categories.splice($.inArray(checked, categories),1);
        }
        filterData();
    });

    function filterData(){
        var data = {};
        var minPrice = $('#min_price').val();
        var maxPrice = $('#max_price').val();

        if(categories.length > 0){
            data['categories'] = {
                'categories' : categories,
            }
        }
        if(brands.length > 0){
            data['brands'] = {
                'brands' : brands,
            }
        }
        if(minPrice != '' && maxPrice != ''){
            data['prices'] = {
                'min_price' : minPrice,
                'max_price' : maxPrice,
            }
        }
        if(param != ''){
            data['searchParam'] = {
                'searchParam'   : param
            }
        }
        serachData(data);
    }

    function serachData(data){
        var spinner = $('#loader');
        spinner.show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url  : '{{route("searchfilter")}}',
            type : 'GET',
            data : data,
            success: (response) => {
				$('#search-data').html(response);
                spinner.hide();
            },
            error: function(response){
                spinner.hide();
            }
        });
    }
</script>
@endsection
