@extends('seller.layouts.main')
@section('title', 'Product add')

@section('content')
<link rel="stylesheet" href="{{asset('css/tagsinput/tagsinput.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/cropper.min.css')}}">
<link rel="stylesheet" href="{{ asset('summernote/css/summernote.min.css') }}"/>

<style type="text/css">
    div#width-error {
        color: #de5353;
    }
    .bootstrap-tagsinput {
        width: 100%;
        height: 100px;
    }
    .label {
        line-height: 2 !important;
    }
    .bootstrap-tagsinput .tag{
        background-color:#4b49ac;
        border-radius: 10px;
        padding-left: 10px;
        padding-right: 10px;
    }
    .bootstrap-tagsinput {
        line-height: 34px;
    }
</style>
<!-- BEGIN: Subheader -->
<div class="m-subheader ">
    <div class="d-flex align-items-center">
        <div class="mr-auto">
            <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                <li class="m-nav__item m-nav__item--home">
                    <a href="{{ url('/seller') }}" class="m-nav__link m-nav__link--icon">
                        <i class="m-nav__link-icon la la-home"></i>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="{{ route('seller.products.index') }}" class="m-nav__link">
                        <span class="m-nav__link-text">Products</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Add product</span>
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
                        Add product
                    </h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="m-portlet__body">
                <!--begin: Form Wizard-->
                <div class="m-wizard m-wizard--5 m-wizard--warning" id="m_wizard">
                    <!--begin: Message container -->
                    <div class="m-portlet__padding-x">
                        <!-- Here you can put a message or alert -->
                    </div>
                    <!--end: Message container -->
                    <!--begin: Form Wizard Head -->
                    <div class="m-wizard__head m-portlet__padding-x" style="    margin-top: -31px;">
                        <div class="row">
                            <div class="col-xl-12 ">
                                <!--begin: Form Wizard Nav -->
                                <div class="m-wizard__nav">
                                    <div class="m-wizard__steps">
                                        <div class="m-wizard__step m-wizard__step--current"
                                        m-wizard-target="m_wizard_form_step_1"
                                        style="padding-bottom: 10px; !important">
                                        <div class="m-wizard__step-info">
                                            <a href="#" class="m-wizard__step-number">
                                                <span class="m-wizard__step-label">
                                                    Product information
                                                </span>
                                                <span class="m-wizard__step-icon">
                                                    <i class="la la-check"></i>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_2"
                                    style="padding-bottom: 10px; !important">
                                    <div class="m-wizard__step-info">
                                        <a href="#" id="showprice" class="m-wizard__step-number">
                                            <span class="m-wizard__step-seq"></span>
                                            <span class="m-wizard__step-label">
                                                Price Details
                                            </span>
                                            <span class="m-wizard__step-icon"><i
                                                class="la la-check"></i>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_3"
                                style="padding-bottom: 10px; !important">
                                <div class="m-wizard__step-info">
                                    <a href="#" id="showchinese" class="m-wizard__step-number">
                                        <span class="m-wizard__step-seq"></span>
                                        <span class="m-wizard__step-label">
                                            Chinese
                                        </span>
                                        <span class="m-wizard__step-icon"><i
                                            class="la la-check"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_4"
                            style="padding-bottom: 10px; !important">
                            <div class="m-wizard__step-info">
                                <a href="#" class="m-wizard__step-number">
                                    <span class="m-wizard__step-seq"></span>
                                    <span class="m-wizard__step-label">
                                        Malay
                                    </span>
                                    <span class="m-wizard__step-icon"><i
                                        class="la la-check"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                        <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_5"
                        style="padding-bottom: 10px; !important">
                        <div class="m-wizard__step-info">
                            <a href="#" class="m-wizard__step-number">
                                <span class="m-wizard__step-seq"></span>
                                <span class="m-wizard__step-label">
                                    Vietnamese
                                </span>
                                <span class="m-wizard__step-icon"><i
                                    class="la la-check"></i>
                                </span>
                            </a>
                        </div>
                    </div>
                    <div class="m-wizard__step" m-wizard-target="m_wizard_form_step_6"
                    style="padding-bottom: 10px; !important">
                    <div class="m-wizard__step-info">
                        <a href="#" class="m-wizard__step-number">
                            <span class="m-wizard__step-seq"></span>
                            <span class="m-wizard__step-label">
                                Thai
                            </span>
                            <span class="m-wizard__step-icon"><i
                                class="la la-check"></i>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end: Form Wizard Nav -->
    </div>
</div>
</div>
<!--end: Form Wizard Head -->

<!--begin: Form Wizard Form-->
<div class="m-wizard__form">
    <form class="m-form m-form--label-align-left- m-form--state-" method="POST"
    action="{{ route('seller.products.store') }}" enctype="multipart/form-data" id="m_form">
    {{ csrf_field() }}
    <!--begin: Form Body -->
    <div class="m-portlet__body" style="margin-top:-30px;">
        <!--begin: Form Wizard Step 1-->
        <div class="m-wizard__form-step m-wizard__form-step--current" id="m_wizard_form_step_1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-form__section m-form__section--first">
                        <div class="form-group m-form__group row">
                            <div class="col-lg-12 form-group m-form__group "></div>
                            <div class="col-lg-4 form-group m-form__group">
                                <label for="name">Product name</label>
                                <div class="m-input-icon m-input-icon--right">
                                    <input type="text" class="form-control m-input" id="name"
                                    name="name" placeholder="Enter product name"
                                    value="{{ old('name') }}" autofocus>
                                    @if ($errors->has('name'))
                                    <span class="helpBlock">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 form-group m-form__group ">
                                <label for="qty">Category </label>
                                <div class="m-input-icon m-input-icon--right">
                                    <select
                                    class="form-control m-bootstrap-select m_selectpicker"
                                    data-live-search="true" multiple="multiple"
                                    name="category[]" id="category">
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 form-group m-form__group ">
                            <label for="sku">SKU code </label>
                            <div class="m-input-icon m-input-icon--right">
                                <input type="text" class="form-control m-input" id="sku"
                                name="sku" placeholder="Enter sku code"
                                value="{{ old('sku') }}" autofocus>
                                @if ($errors->has('sku'))
                                <span class="helpBlock">
                                    <strong>{{ $errors->first('sku') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group m-form__group row">
                        <div class="col-lg-12 form-group m-form__group ">
                            <label for="description">Description </label>
                            <div class="m-input-icon m-input-icon--right">

                                <textarea type="text"
                                class="form-control m-input txarea-height summernote"
                                id="description" name="description"
                                placeholder="Enter description"
                                autofocus>{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                <span class="helpBlock">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="seller_id" value="{{ $userseller->id }}">
                   <!--  <div class="form-group m-form__group row">
                        <div class="col-lg-6 form-group m-form__group ">
                            <label for="seller">Seller </label>
                            <select class="form-control m-bootstrap-select m_selectpicker" name="seller_id" class="seller_id" id="seller_id">
                                @foreach ($sellers as $seller)
                                <option value="{{ $seller->id }}" @if($seller->id == 1) selected @endif>{{ $seller->name }}({{ $seller->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div> -->
                                                <!-- <div class="form-group m-form__group row ">
                                                    <div class="col-lg-12 form-group m-form__group ">

                                                        <h5>Customer price tire </h5>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group " id="daynamic_customer_price">
                                                    <div class="row col-lg-12 ">
                                                        <div class="col-lg-4 form-group m-form__group pt15">
                                                            <label for="daynamic_qty">Qty</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control m-input"
                                                                id="customer_qty" name="customer_qty[]"
                                                                placeholder="Enter Quantity of product" min="2"
                                                                autofocus>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 form-group m-form__group ">
                                                            <label for="daynamic_qty">Price / Quantity</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">RM</span>
                                                                </div>
                                                                <input type="text" class="form-control m-input"
                                                                id="customer_daynamic_price"
                                                                name="customer_daynamic_price[]"
                                                                placeholder="Enter customer price" min="1"
                                                                autofocus>

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="col-lg-4 form-group m-form__group">
                                                    <label for=""></label>
                                                    <div class="input-group">
                                                        <button type="button" name="add" id="add"
                                                        class="btn btn-primary">Add More</button>
                                                    </div>

                                                </div> -->
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-3">
                                                        <br /><br /><br />
                                                        <label class="col-form-label">Product gallery</label>
                                                    </div>
                                                    <div class="col-lg-9 col-md-9 col-sm-12">
                                                        <div class="m-dropzone dropzone m-dropzone--primary"
                                                        id="productDropZonenew" action="/" method="post">
                                                        <div class="m-dropzone__msg dz-message needsclick">
                                                            <h3 class="m-dropzone__msg-title">Drop image here</h3>
                                                            <span class="m-dropzone__msg-desc">Allowed only image
                                                            files</span>
                                                        </div>
                                                        <div id="image_data"></div>
                                                        <div id="image-holder"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- bigin : Product video --}}
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4">
                                                    {{-- <div id="space"><br/><br/><br/></div> --}}
                                                    <label class="col-form-label">Product video</label><br>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="type"
                                                        id="videolink" value="videolink">
                                                        <label class="form-check-label" for="link">Link</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="type"
                                                        id="videoupload" value="videoupload">
                                                        <label class="form-check-label" for="videoupload">Video
                                                        Upload</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="type"
                                                        id="none" value="none" checked>
                                                        <label class="form-check-label" for="none">None</label>
                                                    </div>
                                                    <div id="type-error" class="form-control-feedback"></div>
                                                    @if ($errors->has('type'))
                                                    <span class="helpBlock">
                                                        <strong>{{ $errors->first('type') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                                <div id="url_place" class="col-lg-4 col-md-4 col-sm-12 mt-4 d-none">
                                                    <label class="col-form-label">Video Url(Must add embed url)</label><br>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="url" class="form-control m-input" id="video_url"
                                                        name="video_url" placeholder="Enter video url"
                                                        value="{{ old('video_url') }}" autofocus>
                                                        @if ($errors->has('video_url'))
                                                        <span class="helpBlock">
                                                            <strong>{{ $errors->first('video_url') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div id="video_place" class="col-lg-4 col-md-4 col-sm-12 mt-4 d-none">
                                                    <label class="col-form-label">Video</label><br>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="file" class="form-control m-input" id="video_file" name="video_file">
                                                        @if ($errors->has('video_file'))
                                                        <span class="helpBlock">
                                                            <strong>{{ $errors->first('video_file') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                {{-- <div id="video_thumb" class="col-lg-4 col-md-4 col-sm-12 mt-4 d-none">
                                                    <label class="col-form-label">Video Thumb</label><br>
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <input type="file" class="form-control m-input" id="video_thumb" name="video_thumb">
                                                        @if ($errors->has('video_thumb'))
                                                        <span class="helpBlock">
                                                            <strong>{{ $errors->first('video_thumb') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div> --}}
                                            </div>
                                            {{-- end : Product video --}}

                                            {{-- bigin : Product zip --}}
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-3 col-md-3 col-sm-12 mt-4">
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <label class="col-form-label">ZIP file of photos</label><br>
                                                        <input type="file" class="form-control m-input" id="photos_zip_file"
                                                        name="photos_zip_file" accept=".zip,application/octet-stream,application/zip,application/x-zip,application/x-zip-compressed">
                                                        @if ($errors->has('photos_zip_file'))
                                                        <span class="helpBlock">
                                                            <strong>{{ $errors->first('photos_zip_file') }}</strong>
                                                        </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                           <!--  <div class="form-group m-form__group row">
                                                <div class="col-lg-9 col-md-9 col-sm-12 mt-4">
                                                    <div class="m-input-icon m-input-icon--right">
                                                        <label class="col-form-label">Sale by</label><br>
                                                        <div class="col-lg-9 col-md-9 col-sm-12 mt-2">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="sell_by_agent"
                                                                id="Agent" value="1" checked>
                                                                <label class="form-check-label" for="Agent">Agent</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="sell_by_staff"
                                                                id="Staff" value="1" checked>
                                                                <label class="form-check-label" for="Staff">
                                                                Staff</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" name="sell_by_customer"
                                                                id="Customer" value="1" checked>
                                                                <label class="form-check-label" for="Customer">
                                                                Customer</label>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('sell_by'))
                                                        <span class="helpBlock">
                                                            <strong>{{ $errors->first('sell_by') }}</strong>
                                                        </span>
                                                        @endif
                                                        <div id="sell_by-error" style="color: #f4516c;font-size: .85rem;"></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            {{-- end : Product zip --}}

                                            {{-- bigin : status change --}}
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-3 form-group m-form__group ">
                                                    <label for="status">Status</label>
                                                    <select class="form-control m-input" name="status">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">InActive</option>
                                                    </select>
                                                </div>
                                                {{-- <div class="col-lg-3">
                                                    <label for="status"></label>
                                                    <div class="m-checkbox-inline">
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" value="true" name="is_new"> New
                                                            arrival
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div> --}}
                                                <!-- <div class="col-lg-3 mt-5 mx-5">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tag"
                                                        id="new_arrival" value="new_arrival">
                                                        <label class="form-check-label" for="new_arrival">New arrival</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tag"
                                                        id="pwp" value="pwp">
                                                        <label class="form-check-label" for="pwp">
                                                        PWP</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="tag"
                                                        id="none" value="" checked>
                                                        <label class="form-check-label" for="none" >
                                                        None</label>
                                                    </div>
                                                </div> -->
                                              <!--   <div class="col-lg-2 mt-2">
                                                    <label for="status"></label>
                                                    <div class="m-checkbox-inline">
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" value="1" name="is_featured"> Is
                                                            featured product
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-2">
                                                    <label for="status"></label>
                                                    <div class="m-checkbox-inline">
                                                        <label class="m-checkbox">
                                                            <input type="checkbox" value="1" name="is_other"> Is other product
                                                            <span></span>
                                                        </label>
                                                    </div>
                                                </div> -->
                                            </div>
                                            {{-- end : status change --}}
                                            <!-- <div class="form-group m-form__group row">
                                                <div class="col-lg-3 form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="cod" name="cod" value="1">
                                                        <label class="form-check-label mx-3" for="cod">  Allow COD?</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 form-group" id="displaycheckbox" >
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="displayhomescreen" name="displayhomescreen" value="1">
                                                        <label class="form-check-label mx-3" for="displayhomescreen">Is display home screen?</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="free_shipping" name="free_shipping" value="1">
                                                        <label class="form-check-label mx-3" for="free_shipping">Allow free shipping?</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 form-group" id="agent_wallet">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="deduct_agent_wallet" name="deduct_agent_wallet" value="1">
                                                        <label class="form-check-label mx-3" for="deduct_agent_wallet">Deduct from agent wallet?</label>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end: Form Wizard Step 1-->

                        <!--begin: Form Wizard Step 2-->
                        <div class="m-portlet__body" style="margin-top:-30px;">
                            <div class="m-wizard__form-step" id="m_wizard_form_step_2">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="m-form__section m-form__section--first">
                                            <div class="form-group m-form__group row">
                                                <div class="col-lg-4 form-group m-form__group ">
                                                    <div class="form-group m-form__group">
                                                        <label for="is_variation">Prouct Type <span class="colorred">*</span></label>
                                                        <select class="form-control " name="is_variation" id="is_variation">
                                                            <option value="0">Simple</option>
                                                            <option value="1">Variable</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="simple">
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-6 form-group m-form__group ">
                                                        <label for="weight">Product weight (KG)</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <input type="text" class="form-control m-input" id="weight"
                                                            name="weight" placeholder="Enter weight" autofocus>
                                                            @if ($errors->has('weight'))
                                                            <span class="helpBlock">
                                                                <strong>{{ $errors->first('weight') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 form-group m-form__group " style="padding-top: 0px;">
                                                        <label for="length">Product dimension (length * width *
                                                        height)</label>
                                                        <div class="m-input-icon m-input-icon--right">
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control m-input"
                                                                    id="length" name="length" placeholder="Length" autofocus>
                                                                    @if ($errors->has('length'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('length') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control m-input"
                                                                    id="width" name="width" placeholder="Width" autofocus>
                                                                    @if ($errors->has('width'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('width') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>

                                                                <div class="col-lg-4">
                                                                    <input type="text" class="form-control m-input"
                                                                    id="pheight" name="pheight" placeholder="Height" autofocus>
                                                                    @if ($errors->has('pheight'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('pheight') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group m-form__group row">
                                                    <div class="col-lg-12 form-group m-form__group ">
                                                        <h5>Price tire </h5>
                                                    </div>
                                                    <div class="col-lg-4 form-group m-form__group ">
                                                        <label for="customer_price">Customer</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">RM</span>
                                                            </div>
                                                            <input type="text" class="form-control m-input"
                                                            id="customer_price" name="customer_price"
                                                            placeholder="Enter customer price"
                                                            min="0" autofocus>
                                                            @if ($errors->has('customer_price'))
                                                            <span class="helpBlock">
                                                                <strong>{{ $errors->first('customer_price') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 form-group m-form__group ">
                                                        <label for="sell_price">Selling Price</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">RM</span>
                                                            </div>
                                                            <input type="text" class="form-control m-input"
                                                            id="sell_price" name="sell_price"
                                                            placeholder="Enter selling price"
                                                            min="0" autofocus>
                                                            @if ($errors->has('sell_price'))
                                                            <span class="helpBlock">
                                                                <strong>{{ $errors->first('sell_price') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if (in_array(Auth::user()->role_id, [1, 9, 16]))
                                                    <div class="col-lg-4 form-group m-form__group " >
                                                        <label for="customer_cost_price">Cost</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">RM</span>
                                                            </div>
                                                            <input type="text" class="form-control m-input"
                                                            id="customer_cost_price" name="customer_cost_price"
                                                            placeholder="Enter customer cost price"
                                                            value="{{ old('customer_cost_price') }}"
                                                            min="0" autofocus>
                                                            @if ($errors->has('customer_cost_price'))
                                                            <span class="helpBlock">
                                                                <strong>{{ $errors->first('customer_cost_price') }}</strong>
                                                            </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                                    <!-- <div class="col-lg-4 form-group m-form__group " >
                                                                        <label for="staff_price">Staff price</label>
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text">RM</span>
                                                                            </div>
                                                                            <input type="text" class="form-control m-input"
                                                                                id="staff_price" name="staff_price"
                                                                                placeholder="Enter staff price"
                                                                                min="0" autofocus>
                                                                            @if ($errors->has('staff_price'))
                                                                            <span class="helpBlock">
                                                                                <strong>{{ $errors->first('staff_price') }}</strong>
                                                                            </span>
                                                                            @endif
                                                                        </div>
                                                                    </div> -->
                                                                    @endif

                                                            <!-- <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="ex_price">Executive</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">RM</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                        id="ex_price" name="ex_price" placeholder="Enter executive price"
                                                                        min="0" autofocus>
                                                                    @if ($errors->has('ex_price'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('ex_price') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="si_price">Silver</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">RM</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                        id="si_price" name="si_price"
                                                                        placeholder="Enter silver price"
                                                                        min="0" autofocus>
                                                                    @if ($errors->has('si_price'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('si_price') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="go_price">Gold</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">RM</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                        id="go_price" name="go_price"
                                                                        placeholder="Enter gold price"
                                                                        min="0" autofocus>
                                                                    @if ($errors->has('go_price'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('go_price') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="pl_price">Platinum</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">RM</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                        id="pl_price" name="pl_price"
                                                                        placeholder="Enter platinum price"
                                                                        min="0" autofocus>
                                                                    @if ($errors->has('pl_price'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('pl_price') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="di_price">Diamond</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">RM</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                        id="di_price" name="di_price"
                                                                        placeholder="Enter diamond price"
                                                                        min="0" autofocus>
                                                                    @if ($errors->has('di_price'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('di_price') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div> -->
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="qty">Quantity </label>
                                                                <div class="m-input-icon m-input-icon--right">
                                                                    <input type="text" class="form-control m-input" id="qty"
                                                                    name="qty" placeholder="Enter quantity"
                                                                    value="{{ old('qty') }}" min="0" autofocus>
                                                                    @if ($errors->has('qty'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('qty') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                       <!--  <div class="form-group m-form__group row">
                                                            <div class="col-lg-12 form-group m-form__group ">
                                                                <h5>PV Points </h5>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="executive_pv_point">Executive</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                    id="executive_pv_point" name="executive_pv_point" placeholder="Enter executive pv points" autofocus>
                                                                    @if ($errors->has('executive_pv_point'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('executive_pv_point') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="silver_pv_point">Silver</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                    id="silver_pv_point" name="silver_pv_point"placeholder="Enter silver pv points" autofocus>
                                                                    @if ($errors->has('silver_pv_point'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('silver_pv_point') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="golden_pv_point">Gold</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                    id="golden_pv_point" name="golden_pv_point" placeholder="Enter gold pv points" autofocus>
                                                                    @if ($errors->has('golden_pv_point'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('golden_pv_point') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="platinum_pv_point">Platinum</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                    id="platinum_pv_point" name="platinum_pv_point" placeholder="Enter platinum pv points" autofocus>
                                                                    @if ($errors->has('platinum_pv_point'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('platinum_pv_point') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group ">
                                                                <label for="diamond_pv_point">Diamond</label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                    id="diamond_pv_point" name="diamond_pv_point" placeholder="Enter diamond pv points" autofocus>
                                                                    @if ($errors->has('diamond_pv_point'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('diamond_pv_point') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 form-group m-form__group">
                                                                <label for="staff_pv_point">Staff </label>
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">%</span>
                                                                    </div>
                                                                    <input type="text" class="form-control m-input"
                                                                    id="staff_pv_point" name="staff_pv_point" placeholder="Enter staff pv points" autofocus>
                                                                    @if ($errors->has('staff_pv_point'))
                                                                    <span class="helpBlock">
                                                                        <strong>{{ $errors->first('staff_pv_point') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                    </div>
                                                    <div class="form-group m-form__group row" id ="add-attribute-div">
                                                        <div class="col-lg-6">
                                                        </div>
                                                        <div class="col-lg-4"></div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group m-form__group">
                                                                <label></label>
                                                                <div class="form-group m-form__group">
                                                                    <button type="button" name="add" id="add" class="btn btn-primary add-button">
                                                                        Add Attribute   <img src="{{asset('backend/images/plus-16.png')}}" style="width: 15px; height: 15px">
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="dynamic_option">
                                                        <div id="basic">
                                                            <div class="form-group m-form__group row dynamic_option" id="basic">
                                                                <div class="col-lg-3">
                                                                    <div class="form-group m-form__group">
                                                                        <label for="attribute">Attribute <span class="colorred">*</span></label>
                                                                        <select class="form-control " name="attribute[]" id="attribute">
                                                                            @foreach ($attributes as $attribute)
                                                                            <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <div id="attribute-error" class="form-control-feedback attribute-error"></div>
                                                                        <span class="help-block text-danger">{{ $errors->first('attribute') }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <div class="form-group m-form__group">
                                                                        <label for="variation">Variation <span class="colorred">*</span></label>
                                                                        <input type="text" data-role="tagsinput" id="variation" name="variation[]" class="form-control dynamic-tags">
                                                                        <span class="help-block text-danger">{{ $errors->first('variation') }}</span>
                                                                    </div>
                                                                    <div id="variation-error" class="form-control-feedback variation-error"></div>
                                                                </div>
                                                                <div class="col-lg-2"></div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group m-form__group">
                                                                        <button type="button" name="remove" id="remove" class="btn btn-primary remove-button btn_remove">
                                                                            <img src="{{asset('backend/images/minus-2-16.png')}}" style="width: 15px; height: 15px">
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2" id="set-variation-div">
                                                        <div class="form-group m-form__group">
                                                            <label></label>
                                                            <div class="form-group m-form__group">
                                                                <button type="button" name="set" id="set" class="btn btn-primary set-button" hidden="hidden">
                                                                    Set Variation
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="attribute-pricing-row" style="margin-top: 15px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 2-->

                                <!--begin: Form Wizard Step 3-->
                                <div class="m-portlet__body" style="margin-top:-30px;">
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_3">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Name (Chinese)</label>
                                                            <input type="text" name="chinese_name" class="form-control m-input"
                                                            placeholder="Enter name in chinese">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12 form-group m-form__group ">
                                                            <label for="description">Description (Chinese)</label>
                                                            <div class="m-input-icon m-input-icon--right">
                                                                <textarea type="text"
                                                                class="form-control m-input txarea-height "
                                                                id="description_chinese" name="description_chinese"
                                                                placeholder="Enter description in chinese">{{ old('description_chinese') }} </textarea>
                                                                @if ($errors->has('description_chinese'))
                                                                <span class="helpBlock">
                                                                    <strong>{{ $errors->first('description_chinese') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 3-->

                                <!--begin: Form Wizard Step 4-->
                                <div class="m-portlet__body" style="margin-top:-30px;">
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_4">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Name (Malay)</label>
                                                            <input type="text" name="malay_name"
                                                            class="form-control m-input"
                                                            placeholder="Enter name in malay">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12 form-group m-form__group ">
                                                            <label for="description">Description (Malay) </label>
                                                            <div class="m-input-icon m-input-icon--right">
                                                                <textarea type="text"
                                                                class="form-control m-input txarea-height "
                                                                id="description_malay" name="description_malay"
                                                                placeholder="Enter description in malay">{{ old('description_malay') }} </textarea>
                                                                @if ($errors->has('description_malay'))
                                                                <span class="helpBlock">
                                                                    <strong>{{ $errors->first('description_malay') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 4-->

                                <!--begin: Form Wizard Step 5-->
                                <div class="m-portlet__body" style="margin-top:-60px;">
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_5">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Name (Vietnamese)</label>
                                                            <input type="text" name="vietnamese_name"
                                                            class="form-control m-input"
                                                            placeholder="Enter name in vietnamese">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12 form-group m-form__group ">
                                                            <label for="description">Description (Vietnamese) </label>
                                                            <div class="m-input-icon m-input-icon--right">
                                                                <textarea type="text"
                                                                class="form-control m-input txarea-height "
                                                                id="description_vietnamese"
                                                                name="description_vietnamese"
                                                                placeholder="Enter description in vietnamese">{{ old('description_vietnamese') }} </textarea>
                                                                @if ($errors->has('description_vietnamese'))
                                                                <span class="helpBlock">
                                                                    <strong>{{ $errors->first('description_vietnamese') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 5-->

                                <!--begin: Form Wizard Step 6-->
                                <div class="m-portlet__body" style="margin-top:-30px;">
                                    <div class="m-wizard__form-step" id="m_wizard_form_step_6">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="m-form__section m-form__section--first">
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12">
                                                            <label class="form-control-label">Name (Thai)</label>
                                                            <input type="text" name="thai_name"
                                                            class="form-control m-input"
                                                            placeholder="Enter name in thai">
                                                        </div>
                                                    </div>
                                                    <div class="form-group m-form__group row">
                                                        <div class="col-lg-12 form-group m-form__group ">
                                                            <label for="description">Description (Thai) </label>
                                                            <div class="m-input-icon m-input-icon--right">
                                                                <textarea type="text"
                                                                class="form-control m-input txarea-height "
                                                                id="description_thai" name="description_thai"
                                                                placeholder="Enter description in thai">{{ old('description_thai') }} </textarea>
                                                                @if ($errors->has('description_thai'))
                                                                <span class="helpBlock">
                                                                    <strong>{{ $errors->first('description_thai') }}</strong>
                                                                </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 6-->
                            </div>
                            <!--end: Form Body -->

                            <!--begin: Form Actions -->
                            <div class="">
                                <div class="m-form__actions m-form__actions">
                                    <div class="row">
                                        <div class="col-lg-1"></div>
                                        <div class="col-lg-4 m--align-left">
                                            <a href="#" class="btn btn-secondary m-btn m-btn--custom m-btn--icon"
                                            data-wizard-action="prev">
                                            <span>
                                                <i class="la la-arrow-left"></i>&nbsp;&nbsp;
                                                <span>Back</span>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="col-lg-6 m--align-right">
                                        <a href="#" data-wizard-action="submit">
                                            <input type="submit" name="submit" class="btn btn-primary m-btn m-btn--custom">
                                        </a>
                                        <a href="#" class="btn btn-primary btn-send-request font12"
                                        data-wizard-action="next">
                                        <span>
                                            <span>Next</span>&nbsp;&nbsp;
                                        </span>
                                    </a>
                                </div>
                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                    </div>
                    <!--end: Form Actions -->
                </form>
            </div>
            <!--end: Form Wizard Form-->
        </div>
        <!--end: Form Wizard-->
    </div>
</div>
</div>
</div>
<script type="text/javascript" src="{{asset('js/bootstrap-tagsinput.min.js')}}"></script>
<script src="{{ asset('summernote/js/summernote-bs4.js') }}"></script>

<script src="{{asset('js/cropper.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $("#agent_wallet").addClass("d-none")

        $(document).on("change", "input[name=type]", function(e) {
            var valcheck = $('input[name="type"]:checked').val();
            if (valcheck == "videolink") {
                $("#video_place").addClass("d-none")
                $("#video_thumb").removeClass("d-none")

                $("#url_place").removeClass("d-none")
            } else {
                $("#url_place").addClass("d-none");
                $("#video_thumb").removeClass("d-none")

                $("#video_place").removeClass("d-none")
            }
        });

        $('.m_selectpicker').selectpicker();

        var postURL = "<?php echo url('addmore'); ?>";
        // var i = 1;

        // $('#add').click(function() {
        //     i++;
        //     $('#daynamic_customer_price').append('<div class="row col-lg-12 dynamic-added" id="row' +
        //         i +
        //         '"><div class="col-lg-4 form-group m-form__group pt15"><label for="daynamic_qty">Qty</label><div class="input-group"><input type="text" class="form-control m-input" id="customer_qty' +
        //         i +
        //         '" name="customer_qty[]" placeholder="Enter Quantity of product"   min="2" autofocus ></div></div><div class="col-lg-4 form-group m-form__group "><label for="daynamic_qty">Customer price</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">RM</span></div><input type="text" class="form-control m-input" id="customer_daynamic_price' +
        //         i +
        //         '" name="customer_daynamic_price[]" placeholder="Enter customer price" min="2" autofocus ></div></div><div class="col-lg-4 form-group m-form__group"><label for=""></label><div class="input-group"><button type="button" name="remove" id="' +
        //         i + '" class="btn btn-danger btn_remove">Remove</button></div></div></div>');
        // });

        // $(document).on('click', '.btn_remove', function() {
        //     var button_id = $(this).attr("id");
        //     $('#row' + button_id + '').remove();
        // });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#submit').click(function() {
            $.ajax({
                url: postURL,
                method: "POST",
                data: $('#add_name').serialize(),
                type: 'json',
                success: function(data) {
                    if (data.error) {
                        printErrorMsg(data.error);
                    } else {
                        i = 1;
                        $('.dynamic-added').remove();
                        $('#add_name')[0].reset();
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display', 'block');
                        $(".print-error-msg").css('display', 'none');
                        $(".print-success-msg").find("ul").append(
                            '<li>Record Inserted Successfully.</li>');
                    }
                }
            });
        });

        function printErrorMsg(msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display', 'block');
            $(".print-success-msg").css('display', 'none');
            $.each(msg, function(key, value) {
                $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
            });
        }
    });

    $('#free_shipping').change(function() {
        if(this.checked) {
            $("#agent_wallet").removeClass("d-none")
        }else{
            $("#agent_wallet").addClass("d-none")
        }
    });
</script>

<script type="text/javascript">
    Dropzone.autoDiscover = false;
    $(document).ready(function() {
        $(".summernote").summernote({
            followingToolbar: false,
            height: 300,
            toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["strikethrough", "superscript", "subscript"]],
            ["fontsize", ["fontsize"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["height", ["height"]],
            ["insert", ["link", "picture", "video"]],
            ["view", ["fullscreen", "codeview"]]
            ],
            maximumImageFileSize: 524288, // 512 MB
            callbacks: {
                onImageUpload: function (image) {
                    var sizeKB = image[0]["size"] / 1000;
                    var tmp_pr = 0;
                    if (sizeKB > 512) {
                        tmp_pr = 1;
                        alert("Please, select less then 512kb image.");
                    }
                    if (tmp_pr == 0) {
                        var file = image[0];
                        var reader = new FileReader();
                        reader.onloadend = function () {
                            var image = $("<img>").attr("src", reader.result);
                            $(".summernote").summernote(
                                "insertNode",
                                image[0]
                                );
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
        $("#add-attribute-div").hide();
        $("#dynamic_option").hide();
        $("#set-variation-div").hide();
        var dropzone_image_id = 0;
        window.Cropper;
        var c = 0;

        var cropped = false;
        var myDropzone = new Dropzone("#productDropZonenew",{
            autoQueue: false,
            maxFilesize: 20,
            acceptedFiles: "jpeg,.jpg,.png,.gif",
            uploadMultiple: false,
            parallelUploads: 5,
            paramName: "file",
            addRemoveLinks: true,
            dictFileTooBig: 'Image is larger than 20MB',
            timeout: 10000,
            // queueLimit:1,
            maxFiles:1,
            init: function() {
                this.on("success", function(file, responseText) {

                });
                this.on("removedfile", function(file) {
                    $(".remove_image_" + file.name.replace(/[\. ,:-]+/g, "_").replace(
                        /[&\/\\#,+()$~%.'":*?<>{}]/g, '_')).first().remove();
                });
                this.on("addedfile", function(file) {
                    var _this = this,
                    reader = new FileReader();
                    reader.onload = function(event) {
                        base64 = event.target.result;
                        _this.processQueue();
                        var hidden_field =
                        "<input hidden type='text' class='remove_image_" + file.name
                        .replace(/[\. ,:-]+/g, "_").replace(
                            /[&\/\\#,+()$~%.'":*?<>{}]/g, '_') +
                        "' name='form[file][" + dropzone_image_id + "]' value=" +
                        base64 + ">";
                        var image = "<img  name='" + file.name + "' src='" + base64 +
                        "' height=100>"
                        $("#image_data").append(hidden_field);

                        dropzone_image_id++;
                    };
                    reader.readAsDataURL(file);
                });
            },
            accept: function(file, done) {

                done();
            }
        });

        myDropzone.on('addedfile', function(file) {
            var _this = myDropzone,
            reader = new FileReader();
            reader.onload = function(event) {
                base64 = event.target.result;
                var image = new Image();

            //Set the Base64 string return from FileReader as source.
            image.src = event.target.result;

            //Validate the File Height and Width.
            image.onload = function () {
                var height = this.height;
                var width = this.width;
                if(height != width){
                    _this.removeFile(file);
                    // cropper(file);
                    alert('Image must be square (1:1 ratio).');
                }
                if(height < 200){
                    alert('Image height must be greater than or equal to 200px.');
                }
            };
        };
        reader.readAsDataURL(file);
        //   if (!cropped) {
        //     myDropzone.removeFile(file);
        //     cropper(file);
        // } else {
        //     cropped = false;
        var previewURL = URL.createObjectURL(file);
        var dzPreview = $(file.previewElement).find('img');
        dzPreview.attr("src", previewURL);
        // }
    });

        var cropper = function(file) {
          var fileName = file.name;
          var loadedFilePath = getSrcImageFromBlob(file);
    // @formatter:off
    var modalTemplate =
    '<div class="modal fade" tabindex="-1" role="dialog">' +
    '<div class="modal-dialog" role="document">' +
    '<div class="modal-content">' +
    '<div class="modal-header">' +
    '<button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>' +
    '</div>' +
    '<div class="modal-body">' +
    '<div class="cropper-container">' +
    '<img id="img-' + ++c + '" src="' + loadedFilePath + '" data-vertical-flip="false" data-horizontal-flip="false">' +
    '</div>' +
    '</div>' +
    '<div class="modal-footer">' +
    '<button type="button" class="btn btn-warning rotate-left"><span class="la la-rotate-left"></span></button>' +
    '<button type="button" class="btn btn-warning rotate-right"><span class="la la-rotate-right"></span></button>' +
    '<button type="button" class="btn btn-warning scale-x" data-value="-1"><span class="la la-arrows-h"></span></button>' +
    '<button type="button" class="btn btn-warning scale-y" data-value="-1"><span class="la la-arrows-v"></span></button>' +
    '<button type="button" class="btn btn-warning reset"><span class="la la-refresh"></span></button>' +
    '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>' +
    '<button type="button" class="btn btn-primary crop-upload">Crop & upload</button>' +
    '</div>' +
    '</div>' +
    '</div>' +
    '</div>';
    // @formatter:on

    var $cropperModal = $(modalTemplate);

    $cropperModal.modal('show').on("shown.bs.modal", function() {
      var $image = $('#img-' + c);
      console.log($image);
      var cropper = $image.cropper({
        autoCropArea: 1,
        aspectRatio: 16 / 16,
        cropBoxResizable: false,
        movable: true,
        rotatable: true,
        scalable: true,
        viewMode: 2,
        minContainerWidth: 250,
        maxContainerWidth: 250
    })
      .on('hidden.bs.modal', function() {
        $image.cropper('destroy');
    });

      $cropperModal.on('click', '.crop-upload', function() {
          // get cropped image data
          $image.cropper('getCroppedCanvas', {
            width: 160,
            height: 160,
            minWidth: 256,
            minHeight: 256,
            fillColor: '#fff',
            imageSmoothingEnabled: false,
            imageSmoothingQuality: 'high'
        }).toBlob(function(blob) {
            var croppedFile = blobToFile(blob, fileName);
            croppedFile.accepted = true;
            var files = myDropzone.getAcceptedFiles();
            for (var i = 0; i < files.length; i++) {
              var file = files[i];
              if (file.name === fileName) {
                myDropzone.removeFile(file);
            }
        }
        cropped = true;

        myDropzone.files.push(croppedFile);
        myDropzone.emit('addedfile', croppedFile);
            myDropzone.createThumbnail(croppedFile); //, width, height, resizeMethod, fixOrientation, callback)
            $cropperModal.modal('hide');
        });
    })
      .on('click', '.rotate-right', function() {
        $image.cropper('rotate', 90);
    })
      .on('click', '.rotate-left', function() {
        $image.cropper('rotate', -90);
    })
      .on('click', '.reset', function() {
        $image.cropper('reset');
    })
      .on('click', '.scale-x', function() {
        if (!$image.data('horizontal-flip')) {
          $image.cropper('scale', -1, 1);
          $image.data('horizontal-flip', true);
      } else {
          $image.cropper('scale', 1, 1);
          $image.data('horizontal-flip', false);
      }
  })
      .on('click', '.scale-y', function() {
        if (!$image.data('vertical-flip')) {
          $image.cropper('scale', 1, -1);
          $image.data('vertical-flip', true);
      } else {
          $image.cropper('scale', 1, 1);
          $image.data('vertical-flip', false);
      }
  });
  });
};


function getSrcImageFromBlob(blob) {
    var urlCreator = window.URL || window.webkitURL;
    return urlCreator.createObjectURL(blob);
}

function blobToFile(theBlob, fileName) {
    theBlob.lastModifiedDate = new Date();
    theBlob.name = fileName;
    return theBlob;
}
});

    //== Class definition
    var WizardDemo = function() {
        //== Base elements
        var wizardEl = $('#m_wizard');
        var formEl = $('#m_form');
        var validator;
        var wizard;
        var stepsWizard;

        //== Private functions
        var initWizard = function() {
            //== Initialize form wizard
            wizard = new mWizard('m_wizard', {
                startStep: 1,
                manualStepForward: true
            });
            //== Validation before going to next page
            /* wizard.on('beforeNext', function(wizardObj) {
                if (validator.form() !== true) {
                        wizardObj.stop();  // don't go to the next step
                    }
                })*/

            //== Change event
            wizard.on('change', function(wizard) {
                mUtil.scrollTop();
            });

            //== Change event
            wizard.on('change', function(wizard) {
                if (wizard.getStep() === 1) {

                }
            });

            /* wizard.on('onTabClick', function(wizard) {
                console.log("here");
                 	console.log("here");
                console.log("here");
            });*/
        }
        
        function isRequiredBySelection() {
            var selectedVal = $('#is_variation :selected').val();
            return selectedVal == 0;
        }

        var initValidation = function() {
            validator = formEl.validate({
                //== Validate only visible fields
                /* ignore: ":hidden",*/

                //== Validation rules
                rules: {
                    name: {
                        required: true,
                        maxlength: 30,
                    },
                    category: {
                        required: true,
                    },
                    sku: {
                        required: true,
                        maxlength: 30,
                    },
                    description: {
                        // required: true,
                        maxlength: 500,
                    },
                    qty: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        number: true,
                        maxlength: 30,
                    },
                    customer_price: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        number: true,
                        maxlength: 30,
                    },
                    sell_price: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        number: true,
                        maxlength: 30,
                    },
                    customer_cost_price: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        number: true,
                        maxlength: 30,
                    },
                    // staff_price: {
                    //     required: {
                    //         depends: isRequiredBySelection
                    //     },
                    //     number: true,
                    //     maxlength: 30,
                    // },
                    // ex_price: {
                    //     required: {
                    //         depends: isRequiredBySelection
                    //     },
                    //     number: true,
                    //     maxlength: 30,
                    //     // max: function() {
                    //     //     return parseInt($('#customer_price').val());
                    //     // },
                    // },
                    // go_price: {
                    //     required: {
                    //         depends: isRequiredBySelection
                    //     },
                    //     number: true,
                    //     maxlength: 30,
                    //     // max: function() {
                    //     //     return parseInt($('#si_price').val());
                    //     // },
                    // },
                    // si_price: {
                    //     required: {
                    //         depends: isRequiredBySelection
                    //     },
                    //     number: true,
                    //     maxlength: 30,
                    //     // max: function() {
                    //     //     return parseInt($('#ex_price').val());
                    //     // },
                    // },
                    // pl_price: {
                    //     required: {
                    //         depends: isRequiredBySelection
                    //     },
                    //     number: true,
                    //     maxlength: 30,
                    //     // max: function() {
                    //     //     return parseInt($('#go_price').val());
                    //     // },
                    // },
                    // di_price: {
                    //     required: {
                    //         depends: isRequiredBySelection
                    //     },
                    //     number: true,
                    //     maxlength: 30,
                    //     // max: function() {
                    //     //     return parseInt($('#pl_price').val());
                    //     // },
                    // },
                    length: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        min: 0,
                    },
                    width: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        min: 0,
                    },
                    pheight: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        min: 0,
                    },
                    weight: {
                        required: {
                            depends: isRequiredBySelection
                        },
                        min: 0,
                        number: true,
                    },
                    // sell_by: {
                    //     required: true,
                    // },
                    type: {
                        // required: true,
                    },
                    video_url: {
                        url: true,
                        // required: function() {
                        //     return $('input[name="type"]:checked').val() == "videolink";
                        // }
                    },
                    video_file: {
                        extension: "ogg|ogv|avi|mpe?g|mov|wmv|flv|mp4",
                        // required: function() {
                        //     return $('input[name="type"]:checked').val() == "videoupload";
                        // }
                    },
                    video_thumb: {
                        extension: "jpeg|jpg|png|gif",
                        // required: function() {
                        //     return ($('input[name="type"]:checked').val() == "videoupload" || $('input[name="type"]:checked').val() == "videolink");
                        // }
                    },
                    /*//=== Client Information(step 2)
                    //== Account Details
                    chinese_name: {
                        required: true,
                        maxlength: 30,
                    },
                    description_chinese: {
                        required: true,
                        noSpace: true,
                        maxlength: 500,
                    },*/
                    /* //=== Client Information(step 3)
                        //== Billing Information
                        malay_name: {
                        required: true,
                        maxlength: 30,
                        },
                        description_malay: {
                        required: true,
                        noSpace: true,
                        maxlength: 500,
                    },*/

                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "sell_by") {
                        $('#sell_by-error').html(error);
                    } else {
                        error.insertAfter(element)
                    }
                },
                messages: {
                //     "ex_price": {
                //         max: "Value must be smaller then customer price"
                //     },
                //     "si_price": {
                //         max: "Value must be smaller then executive price"
                //     },
                //     "go_price": {
                //         max: "Value must be smaller then silver price"
                //     },
                //     "pl_price": {
                //         max: "Value must be smaller then gold price"
                //     },
                //     "di_price": {
                //         max: "Value must be smaller then platinum price"
                //     },
                    // "type": {
                    //     required: "Please select atleast one.",
                    // },
                    "video_url": {
                        url: "Enter valid url.",
                        // required: "Please enter video url",
                    },
                    "video_file": {
                        // required: "Please upload video",
                        extension: "Please select a video with a valid extension.",
                    },
                    "sell_by": {
                        // required: "Please upload video",
                        required: "Please select at least one.",
                    },
                },

                //== Display error
                    //== Display error
                //== Display error
                invalidHandler: function(event, validator) {
                    mUtil.scrollTop();
                    wizard.goFirst();
                    return false;
                },

                //== Submit valid form
                submitHandler: function(form) {
                    var imgsrc = $('.dz-image img').attr('src');
                    if (imgsrc == undefined) {
                        alert('Please upload product image before submit');
                    } else {

                        form[0].submit();
                    }

                }
            });
}

var initSubmit = function() {
    var btn = formEl.find('[data-wizard-action="submit"]');

    btn.on('click', function(e) {
    });
}

return {
            // public functions
            init: function() {
                wizardEl = $('#m_wizard');
                formEl = $('#m_form');

                initWizard();
                initValidation();
                initSubmit();
            }
        };
    }();

    jQuery(document).ready(function() {
        WizardDemo.init();

    });

    // function deselectableRadios(rootElement) {
    // if(!rootElement) rootElement = document;
    // if(!window.radioChecked) window.radioChecked = {};
    // window.radioClick = function(e) {
    //     const obj = e.target, name = obj.name || "unnamed";
    //     if(e.keyCode) return obj.checked = e.keyCode!=32;
    //     obj.checked = window.radioChecked[name] != obj;
    //     window.radioChecked[name] = obj.checked ? obj : null;
    // }
    // rootElement.querySelectorAll("input[type='radio']").forEach( radio => {
    //     radio.setAttribute("onclick", "radioClick(event)");
    //     radio.setAttribute("onkeyup", "radioClick(event)");
    // });
    // }

    // deselectableRadios();
    // $("#is_variation").click(function() {
    //     if($(this).is(":checked")) {
    //         $("#add-attribute-div").show();
    //         $("#dynamic_option").show();
    //         $("#set-variation-div").show();
    //     } else {
    //         $("#add-attribute-div").hide();
    //         $("#dynamic_option").hide();
    //         $("#set-variation-div").hide();
    //     }
    // });

    $("#is_variation").change(function () {
        var end = $('#is_variation :selected').val();
        if(end == 1) {
            $("#simple").addClass('hidden').hide();
            $("#add-attribute-div").show();
            $("#dynamic_option").show();
            $("#set-variation-div").show();
            $("#attribute-pricing-row").show();
        } else {
            $("#simple").show();
            $("#add-attribute-div").addClass('hidden').hide();
            $("#dynamic_option").addClass('hidden').hide();
            $("#set-variation-div").addClass('hidden').hide();
            $("#attribute-pricing-row").addClass('hidden').hide();
        }
    });


    var j = 0;
    $('#add').click(function() {
        j++;
        var clone = $("#basic").clone();
        clone.find('#basic').attr('id', 'basic'+j);
        clone.find('#attribute').attr('id', 'attribute'+j);
        clone.find('#variation').attr('id', 'variation'+j);
        clone.find('#variation-error').attr('id', 'variation-error'+j);
        clone.find("#variation"+j).val('');
        clone.find('#remove').attr('id', j);
        $("#dynamic_option").append(clone);
        $('.dynamic-tags').tagsinput();
        $(".bootstrap-tagsinput").nextAll().remove();
    });
    $(document).on('click', '.btn_remove', function() {
      var button_id = $(this).attr("id");
      $('#basic' + button_id).remove();
      $(button_id).remove();
  });

    $(document).on('click', '.copyButton', function(e) {
        var id = $(this).attr('id');
        var newArray = id.split("-");
        var previousId = 0;
        $('#lengths-'+newArray[1]).val($('#lengths-'+previousId).val());
        $('#widths-'+newArray[1]).val($('#widths-'+previousId).val());
        $('#heights-'+newArray[1]).val($('#heights-'+previousId).val());
        $('#weights-'+newArray[1]).val($('#weights-'+previousId).val());
        $('#customer_cost_prices-'+newArray[1]).val($('#customer_cost_prices-'+previousId).val());
        $('#customer_prices-'+newArray[1]).val($('#customer_prices-'+previousId).val());
        $('#sell_prices-'+newArray[1]).val($('#sell_prices-'+previousId).val());
        // $('#staff_prices-'+newArray[1]).val($('#staff_prices-'+previousId).val());
        // $('#ex_prices-'+newArray[1]).val($('#ex_prices-'+previousId).val());
        // $('#si_prices-'+newArray[1]).val($('#si_prices-'+previousId).val());
        // $('#go_prices-'+newArray[1]).val($('#go_prices-'+previousId).val());
        // $('#pl_prices-'+newArray[1]).val($('#pl_prices-'+previousId).val());
        // $('#di_prices-'+newArray[1]).val($('#di_prices-'+previousId).val());
        $('#qtys-'+newArray[1]).val($('#qtys-'+previousId).val());
        $('#statuses-'+newArray[1]).val($('#statuses-'+previousId).find(":selected").val());
        $('#executive_pv_points-'+newArray[1]).val($('#executive_pv_points-'+previousId).val());
        $('#silver_pv_points-'+newArray[1]).val($('#silver_pv_points-'+previousId).val());
        $('#golden_pv_points-'+newArray[1]).val($('#golden_pv_points-'+previousId).val());
        $('#platinum_pv_points-'+newArray[1]).val($('#platinum_pv_points-'+previousId).val());
        $('#diamond_pv_points-'+newArray[1]).val($('#diamond_pv_points-'+previousId).val());
        $('#staff_pv_points-'+newArray[1]).val($('#staff_pv_points-'+previousId).val());

        // console.log(val('#weight'[previousId]));
    }); 
    function checkIfArrayIsUnique(myArray) {
      return myArray.length === new Set(myArray).size;
  }

  $('#set').click(function() {
        // $("#m_form input[name^='weights[]']").each(function() {
        //     $(this).rules("add", { required: true });
        // }); 
        var attributeArray = $("[name='attribute[]']").map(function(){return $(this).val();}).get();
        var variationArray = $("[name='variation[]']").map(function(){return $(this).val();}).get();

        $.each(variationArray, function( key, value ) {
            key == 0 ? key = '' : key = key;
            if(value == ''){
                $('#variation-error'+key).addClass("variation-error form-control-feedback");
                $('#variation-error'+key).html('Please enter atleast one variation');
            }
            else{
                $('#variation-error'+key).removeClass("variation-error form-control-feedback");
                $('#variation-error'+key).html('');
            }
        });

        if(checkIfArrayIsUnique(attributeArray) == false){
         $('#attribute-error').html('Please select unique attribute');
     }else{
         $('#attribute-error').html('');
     }
     if (($(".variation-error").length > 0) || (checkIfArrayIsUnique(attributeArray) == false)) {
        $('#attribute-pricing-row').html('');
        return;
    }else{
        pricing(attributeArray, variationArray);
        $(':input[type="submit"]').prop('disabled', false);
    }

        // $('[name=="weights[]"]').each(function() {
        // $(this).rules('add', {
        //     required: true,
        // });
        // });
        // $('[name^="weights"]').each(function() {
        //         $(this).rules('add', {
        //             required: true,
        //             messages: {
        //                 required: "Enter something else"
        //             }
        //         });
        //     });
    });

  function pricing(attributeArray, variationArray){
      var url = "{{ route('seller.variations.pricing') }}";
      $.ajax({
         type:'post',
         url:url,
         data:{
            'attributeArray': attributeArray,
            'variationArray': variationArray,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response){
            $('#attribute-pricing-row').html(response.view);
        }
    });
  }

  $(document).on('itemAdded', '.dynamic-tags', function(e) {
    $("#set").click();
});

  $(document).on('itemRemoved', '.dynamic-tags', function(e) {
    $("#set").click();
});

</script>
@endsection
