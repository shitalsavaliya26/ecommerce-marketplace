@extends('layouts.main')
@section('title', 'Sub Category')
@section('content')

<section class="bg-gray py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="position-relative">
                    <div class="bg-follow"></div>
                    <div class="bg-follow-black"></div>
                    <div class="cus-follow-content-pos">
                        <div class="d-flex">
                            <div>
                                <img src="{{asset('assets/images/adidas-logo.png')}}" class="cus-follow-img-style"
                                    alt="">
                                <img src="{{asset('assets/images/mall.png')}}" class="w-35px d-block mx-auto mt-n3"
                                    alt="">
                            </div>
                            <div class="mt-3 pl-3">
                                <h4 class="text-white font-18 font-GilroyBold mb-1">Celovis Official Store</h4>
                                <h4 class="text-light-gray font-12 font-GilroySemiBold mb-0">Active 2 hours ago</h4>
                            </div>
                        </div>
                        <div class="d-flex mt-3">
                            <button type="button" class="btn cus-btn-outline-light font-GilroySemiBold font-12 py-1 rounded-0 w-50 mr-2"> + FOLLOW</button>
                            <button type="button" class="btn cus-btn-outline-light font-GilroySemiBold font-12 py-1 rounded-0 w-50">
                                <img src="{{asset('assets/images/msg.png')}}" class="img-fluid mr-2"
                                    alt=""> CHAT
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="#" target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Products.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Products: <span class="text-orange">810</span>
                    </h4>
                </a>
                <a href="#" target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Following.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Following: <span class="text-orange">2</span>
                    </h4>
                </a>
                <a href="#" target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/ChatNew.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Chat Performance: <span class="text-orange">96%(Within Hours)</span>
                    </h4>
                </a>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <a href="#" target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Followers.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Followers: <span class="text-orange">226k</span>
                    </h4>
                </a>
                <a href="#" target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Rating.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Rating: <span class="text-orange">4.9(40.6k Rating)</span>
                    </h4>
                </a>
                <a href="#" target="_blank" class="d-flex align-items-center mt-3">
                    <img src="{{asset('assets/images/Joined.png')}}" class="img-fluid mr-2 mb-1" alt="">
                    <h4 class="text-black font-14 font-GilroyRegular mb-0">
                        Joined: <span class="text-orange">5 Years Ago</span>
                    </h4>
                </a>
            </div>
        </div>

        <div class="row mt-5 mx-0 br-15 bg-dark-blue shadow overflow-hidden">
            <div class="col-12 px-0">
                <nav class="profile-tabs">
                    <div class="nav nav-tabs border-0 flex-column flex-md-row justify-content-start" id="nav-tab"
                        role="tablist">
                        <a class="nav-item font-GilroySemiBold nav-link active" id="home-tab" data-toggle="tab"
                            href="#home" role="tab" aria-controls="home" aria-selected="true">Home</a>
                        <a class="nav-item font-GilroySemiBold nav-link" id="products-tab" data-toggle="tab"
                            href="#products" role="tab" aria-controls="products" aria-selected="false">All Products</a>
                        <a class="nav-item font-GilroySemiBold nav-link" id="buy-tab" data-toggle="tab" href="#buy"
                            role="tab" aria-controls="buy" aria-selected="false">Buy 1 Free 1</a>
                    </div>
                </nav>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="slider-grid-4 pb-4">
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
                        <img src="{{asset('assets/images/clearanceSale.png')}}" class="img-fluid w-100" alt="">
                    </div>

                    <div class="tab-pane fade" id="buy" role="tabpanel" aria-labelledby="buy-tab">
                        <div class="slider-grid-4 pb-4">
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                            <a href="http://localhost/mr.who-customer/hgagfg">
                                <div class="overflow-hidden bg-white h-100">
                                    <div class="position-relative">
                                        <img src="https://maxshop.s3.us-east-2.amazonaws.com/images/product/thumb/16651360621827148513.png"
                                            class="img-fluid imgprd" alt="">
                                    </div>
                                    <div class="py-2 px-3">
                                        <h4 class="text-black font-16 font-GilroyBold">hgagfg</h4>
                                        <div class="d-flex align-items-center flex-wrap">
                                            <button class="btn local-seller-btn py-1 px-2">shital</button>
                                            <div class="ml-3">
                                                <img src="http://localhost/mr.who-customer/assets/images/Location.png"
                                                    class="img-fluid w-7px" alt="">
                                                <span class="text-light-gray font-10">Selangor</span>
                                            </div>
                                        </div>
                                        <h4 class="text-orange font-14 mt-1 font-GilroyBold">
                                            RM100.00 (CP) <span
                                                class="text-light-gray font-10 font-weight-normal">RM100.20
                                                (RSP)
                                            </span>
                                        </h4>
                                        <h4 class="text-light-gray font-12 font-weight-normal">
                                            <span class="text-black mr-1">
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection