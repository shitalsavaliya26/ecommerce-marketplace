@extends('layouts.front.main')

@section('content')

<style>

.btn-brand {
    color: #fff;
    background-color: purple;
    border-color: purple;
}

</style>
<div class="m-content">
    <div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Products
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
               
            </div>
        </div>
        <div class="m-portlet__body">
        @if (\Session::has('success'))
            <div class="col-xl-12 m-section__content">
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
        <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="m-portlet m-portlet--mobile dataTables_wrapper dt-bootstrap4 m-portlet--rounded-force">
                    <div class="m-portlet__head m-portlet__head--fit" style="border-bottom: none;" >
                        <div class="m-portlet__head-caption">
                            <!-- <div class="m-portlet__head-action">
                                <button type="button" class="btn btn-sm m-btn--pill  btn-brand">Blog</button>
                            </div> -->
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        <div class="m-widget19">
                            <div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px">
                                <img src="{{ $product->images[0]->image }}" alt="" height="250" >
                                <h3 class="m-widget19__title m--font-light">
                                     
                                </h3>
                                <div class="m-widget19__shadow"></div>
                            </div>
                            <div class="m-widget19__content">
                                <div class="m-widget19__header">
                                    <div class="m-widget19__info">
                                    <!-- {{ route('product_detail', [$product->id]) }} -->
                                        <a href="{{ route('product_detail', [$product->id]) }}" class="m-widget19__username" style="font-size: 1.2rem;color:black;text-decoration: none !important;">
                                                {{ $product->name}} 
                                        </a>
                                    </div>
                                    <div class="m-widget19__stats">
                                        <span class="m-widget19__number m--font-brand" style="font-size: 1.2rem;width: 105px;" >
                                            RM {{ number_format($product->sell_price,2) }}
                                        </span>
                                        
                                        <!-- <button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--hover-brand m-btn--custom">View Detail</button> -->
                                    </div>
                                </div>
                                <div class="m-widget19__body" style="min-height: 75px;">
                                   {{ substr($product->description,0,100) }}
                                </div>
                            </div>
                            <form method="post" action="{{ route('add_to_cart') }}">
                                {{ csrf_field() }}
                                <div class="m-widget19__action">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}" >
                                    <input type="number" name="qty" placeholder="Qty" value="1" min="1" class="btn m-btn btn-secondary " style="width: 40%;"/>
                                    <button type="submit" class="btn m-btn--pill    btn-brand"  style=" width: 58%;" >Add to Cart</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
