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
                    <a href="{{ route('products')}}" class="m-nav__link">
                        <span class="m-nav__link-text">Products</span>
                    </a>
                </li>
                <li class="m-nav__separator">-</li>
                <li class="m-nav__item">
                    <a href="" class="m-nav__link">
                        <span class="m-nav__link-text">Products Import</span>
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
                        Import Products
                    </h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="row" id="app_massges">
                @if (\Session::has('success'))
                <div class="col-xl-12 m-section__content toast-container ">
                    <div class="m-alert m-alert--outline alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        </button>
                        <strong> {!! \Session::get('success') !!}</strong>
                    </div>
                </div>
                @endif
                @if (\Session::has('error'))
                <div class="col-xl-12 m-section__content">
                    <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        </button>
                        <strong> {!! \Session::get('error') !!}</strong>
                    </div>
                </div>
                @endif
                @if($errors->any())
                @foreach($errors->all() as $error)
                <div class="col-xl-12 m-section__content">
                    <div class="m-alert m-alert--outline alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        </button>
                        <strong>{{ $error }} </strong>
                    </div>
                </div>
                @endforeach
                @endif

            </div>
            <form method="post" id="prdImportFrm" action="{{route('importProducts')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="name">Import Product File <span class="colorred">*</span></label>
                                <input type="file" name="products" class="form-control" placeholder="Please select file">
                                <span class="help-block text-danger">{{$errors->first('products')}}</span>
                                <span class="help-block"><strong>Note:</strong>Only .csv,.xls and .xlsx files are allowed to import</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-send-request font12">Import</button>
                                    <!-- <a href="{{ route('attributes.index')}}" class="btn btn-secondary font12">Cancel</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form method="post" id="variationImportFrm" action="{{route('importProductVariations')}}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="m-portlet__body">
                    <div class="form-group m-form__group row">
                        <div class="col-lg-6">
                            <div class="form-group m-form__group">
                                <label for="name">Import Product Variation File <span class="colorred">*</span></label>
                                <input type="file" name="variations" class="form-control" placeholder="Please select file">
                                <span class="help-block text-danger">{{$errors->first('variations')}}</span>
                                <span class="help-block"><strong>Note:</strong>Only .csv,.xls and .xlsx files are allowed to import</span>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
                        <div class="m-form__actions m-form__actions--solid">
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary btn-send-request font12">Import</button>
                                    <!-- <a href="{{ route('attributes.index')}}" class="btn btn-secondary font12">Cancel</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script type="text/javascript">
            $(document).ready(function(){

                $( "#prdImportFrm" ).validate({
                    rules: {
                        products: {
                            required: true,
                            extension: "csv|xlsx|xls"
                        },
                    }, 
                    messages: {
                        "products" :{
                            required: "Please choose a file",
                            extension: 'Only .csv,.xls and .xlsx files are allowed to   ',
                        }
                    }
                });
                $( "#variationImportFrm" ).validate({
                    rules: {
                        variations: {
                            required: true,
                            extension: "csv|xlsx|xls"
                        },
                    }, 
                    messages: {
                        "variations" :{
                            required: "Please choose a file",
                            extension: 'Only .csv,.xls and .xlsx files are allowed to import',
                        }
                    }
                });
            });
        </script>
    </div>
</div>

@endsection
