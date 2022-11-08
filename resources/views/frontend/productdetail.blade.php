@extends('layouts.main')
@section('title', $product->name)
@section('content')
<section class="bg-gray pt-4 pb-5">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="row bg-white mx-0 br-15 shadow overflow-hidden {{(!$product->shocking_sell) ? 'py-5' : ''}}">
                  @if($product->shocking_sell)
                  <div class="col-12 col-lg-12 pb-5">
                    <div class="col-12 bg-orange p-3">
                        <div class="d-flex flex-column flex-md-row align-items-center">
                            <h4 class="text-white font-22 font-GilroySemiBold mb-0 mr-4">Shocking Sales Ends In </h4>
                            <div class="flipper" data-reverse="true" data-datetime="{{$product->shockingsale->end_date}}" data-template="dd|HH|ii|ss" data-labels="" id="myFlipper"></div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-12">
                            <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ ($product->images->count() > 0) ? $product->images[0]->image : '' }}" class="img-fluid" id="thumb" alt="">
                            <video class="img-fluid" id="video" style="display:none;" controls>
                              <source src="{{$product->video}}" type="video/mp4">
                                  <source src="{{$product->video}}" type="video/ogg">
                                    {{trans('label.your_browser_does_not_support_the_video_tag')}}
                                </video>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 col-12 d-flex flex-wrap">
                                <?php $i = 0; ?>
                                @foreach($product->images as $image)
                                <a href="javascript:void(0)" class="col-6 text-center thumb @if($i == 0) thumb-outline @endif">
                                    <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $image->thumb }}" data-src="{{ $image->image }}" class="img-fluid" alt="">
                                </a>
                                <?php $i++; ?>
                                @endforeach
                            </div>
                            @if($product->video != '')
                            <a href="javascript:void(0)" class="col-6 text-center video thumb @if($i == 0) thumb-outline @endif">
                                <video class="img-fluid" controls>
                                    <source src="{{$product->video}}" type="video/mp4">
                                        <source src="{{$product->video}}" type="video/ogg">
                                            {{trans('label.your_browser_does_not_support_the_video_tag')}}
                                        </video>
                                    </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 col-lg-7 mt-4 mt-lg-0">
                                <form action="{{route('addtocart')}}" method="post" id="addtocart">
                                    {{ csrf_field() }}
                                    <div id="variation">

                                        <div class="row">
                                            <div class="col-12">

                                                <h1 class="text-black font-30 font-GilroyBold">{{$product->name}}</h1>
                                                <?php $cp = ($product->is_variation == '1' && $product->variation) ? $product->variation->sell_price : $product->sell_price; ?>
                                                <h1 class="text-orange font-28 font-GilroyBold mt-3">RM{{ number_format($cp,2) }} (CP) 
                                                    <?php $rsp = ($product->is_variation == '1' && $product->variation) ? $product->variation->customer_price : $product->customer_price; ?>
                                                    @if($rsp > $cp)
                                                    <del class="text-light-gray font-16 font-GilroyMedium">RM{{ number_format($rsp, 2) }} (RSP)</del>
                                                    @else
                                                    <span class="text-light-gray font-16 font-GilroyMedium">RM{{ number_format($rsp, 2) }} (RSP)</span>
                                                    @endif
                                                </h1>

                                                <div class="d-flex flex-wrap" id="ratewishlistdetail">
                                                    <div class="border-rating rounded-pill d-flex align-items-center px-3 mt-4">
                                                        <img src="{{ asset('assets/images/star.png') }}" class="img-fluid max-w-14px mr-1" alt="">
                                                        <span class="text-black font-16 font-GilroySemiBold">{{number_format($product->avgReviewRating(),1)}}</span>
                                                    </div>
                                                    <div class="ml-3 mt-4">
                                                        <span class="text-black font-16 font-GilroySemiBold">{{$product->countReviewRating() }} {{trans('label.ratings')}}</span>
                                                    </div>
                                                    @if($product->sold > 0)
                                                    <div class="ml-3 mt-4">
                                                        <span class="text-light-gray font-18">|</span>
                                                    </div>
                                                    <div class="ml-3 mt-4">
                                                        <span class="text-black font-16 font-GilroySemiBold"> {{($product->sold > 1000) ? ceil($product->sold/1000).'K' : $product->sold}} {{trans('label.sold')}} </span>
                                                    </div>
                                                    @endif
                                                    <div class="ml-3 mt-4">
                                                        <span class="text-light-gray font-18">|</span>
                                                    </div>
                                                    <div class="d-flex align-items-center px-3 mt-4 btn wishlist " data-slug="{{App\Helpers\Helper::encrypt($product->id)}}">
                                                        @if($product->wishlist)
                                                        <img src="{{ asset('assets/images/filled.png') }}" class="img-fluid max-w-14px" alt="">
                                                        @else
                                                        <img src="{{ asset('assets/images/outlined.png') }}" class="img-fluid max-w-14px" alt="">
                                                        @endif

                                                    </div>
                                                    <div class="mt-4">
                                                        <span class="text-black font-16 font-GilroySemiBold">{{trans('label.favorite')}} ({{($product->favorite > 1000) ? ceil($product->favorite/1000).'K' : $product->favorite}})</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                 <!--                 <div class="row mt-5 align-items-center">
                                        <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                                            <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">Shop Vouncher</p>
                                        </div>
                                        <div class="col-12 col-sm-8 col-lg-7 col-xl-8 mt-3 mt-sm-0">
                                            <div class="bg-light-pink px-3 py-2 d-inline-block">
                                                <p class="text-orange font-GilroySemiBold font-16 mb-0">8% Coins Cashback</p>
                                            </div>
                                        </div>
                                    </div> -->

                                    @if($product->is_variation == '1' && $product->variation)
                                    <hr class="mt-4" />
                                    <?php $i = 0;?>
                                    <div class="row mt-3 align-items-center">
                                        <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                                            <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">{{trans('label.variation')}}</p>
                                        </div>
                                        @foreach($product->attributes as $variation)
                                        @if($i != 0)
                                        <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                                            <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block"></p>
                                        </div>
                                        @endif
                                        <div class="col-12 col-sm-8 col-lg-7 col-xl-8">
                                            {{$variation->name}}:
                                            <div class="radio_container">
                                                @foreach($variation->variations as $value)
                                                <?php //dd($value->id); ?>
                                                <input class="d-none" type="radio" value="{{$value->id}}" name="variation[{{$variation->id}}]" id="{{$value->id}}" @if(in_array($value->id, $product->variation->variation_value)) checked @endif>
                                                <label for="{{$value->id}}" >{{$value->variation_value}}</label>
                                                @endforeach
                                            </div>
                                        </div>
                                        <?php $i++; ?>
                                        @endforeach
                                    </div>
                                    @endif
                                    <?php $pvpoint = ($product->is_variation == '1' && $product->variation) ? $product->get_product_pv_point($user, $product->id, $product->variation->id) : $product->get_product_pv_point($user, $product->id, $variation_id = null); ?>
                                    @if($user && $user->role_id != 7 && $pvpoint > 0)
                                    <div class="row mt-4 align-items-center">
                                        <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                                            <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">{{trans('label.pv_points')}}</p>
                                        </div>
                                        <div class="col-12 col-sm-8 col-lg-7 col-xl-8 mt-3 mt-sm-0 d-flex align-items-center">
                                            <div class="bg-light-pink px-3 py-2 d-inline-block">
                                                <p class="text-orange font-GilroySemiBold font-16 mb-0">
                                                {{$pvpoint}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mt-4 align-items-center">
                                        <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                                            <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">{{trans('label.quantity')}}</p>
                                        </div>
                                        <div class="col-12 col-sm-8 col-lg-7 col-xl-8 mt-3 mt-sm-0 d-flex align-items-center">
                                            <div class="d-flex align-items-center">
                                                <div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer">
                                                    <span class="text-gray font-GilroyMedium font-16" id="minus">-</span>
                                                </div>
                                                <input type="hidden" name="product_id" id="product_id" value="{{ App\Helpers\Helper::encrypt($product->id) }}">
                                                <input type="hidden" name="qty" id="qty" value="1">
                                                <div class="text-gray font-16 mx-4" id="increment">
                                                 1
                                             </div>
                                             <div class="shadow br-8 bg-white h-30px w-30px d-flex align-items-center justify-content-center cursor-pointer">
                                                <span class="text-gray font-GilroyMedium font-16 " id="plus">+</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-gray font-GilroySemiBold font-14 mb-0">{{($product->is_variation == '1' && $product->variation) ? $product->variation->qty : $product->qty}} {{trans('label.pieces_available')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 align-items-center">
                                <div class="col-12 col-sm-6">
                                    <button type="submit" class="btn btn-block bg-orange orange-btn font-GilroyBold text-white font-16 mt-4">
                                        {{trans('label.add_to_cart')}}
                                    </button>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <button type="button" class="btn btn-block orange-btn-outline font-GilroyBold text-white font-16 mt-4" id="buynow">
                                        {{trans('label.buy_now')}}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="row mt-4 align-items-center">
                            <div class="col-12 col-sm-4 col-lg-5 col-xl-4">
                                <p class="text-gray font-GilroyBold font-16 mb-0 d-inline-block">{{trans('label.share')}}</p>
                            </div>
                            <div class="col-12 col-sm-8 col-lg-7 col-xl-8 mt-3 mt-sm-0">
                                <ul class="list-unstyled mb-0 d-flex flex-wrap align-items-center">
                                    @foreach($sociallinks as $key=>$link)
                                    <li class="mx-1">
                                        <a href="{{$link}}">
                                            <img src="{{ asset('assets/images/'.$key.'-colored.png') }}" class="img-fluid max-w-24px"
                                            alt="">
                                        </a>
                                    </li>
                                    @endforeach
                                    <!-- <li class="mx-1">
                                        <a href="">
                                            <img src="{{ asset('assets/images/facebook-colored.png') }}"
                                            class="img-fluid max-w-24px" alt="">
                                        </a>
                                    </li>
                                    <li class="mx-1">
                                        <a href="">
                                            <img src="{{ asset('assets/images/Telegram-icon.png') }}" class="img-fluid max-w-24px"
                                            alt="">
                                        </a>
                                    </li>
                                    <li class="mx-1">
                                        <a href="">
                                            <img src="{{ asset('assets/images/whatsapp.png') }}" class="img-fluid max-w-24px"
                                            alt="">
                                        </a>
                                    </li>
                                    <li class="mx-1">
                                        <a href="">
                                            <img src="{{ asset('assets/images/twitter-colored.png') }}"
                                            class="img-fluid max-w-24px" alt="">
                                        </a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row bg-white mx-0 br-15 py-4 px-sm-4 mt-4 shadow overflow-hidden">
                    <div class="col-12 col-lg-4">
                        <h4 class="text-black font-22 font-GilroyBold">{{trans('label.product_details')}}</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-xl-12">
                                {!! nl2br($product->description) !!}
                            </div>
                        </div>
                            <!-- <div class="row">
                                <div class="col-12 col-sm-3 col-xl-2">
                                    <p class="text-gray font-14 font-GilroyMedium mb-0">Delivery Time</p>
                                </div>
                                <div class="col-12 col-sm-9 col-xl-10 mt-2 mt-sm-0">
                                    <div class="d-flex">
                                        <p class="text-gray font-14 font-GilroyMedium mb-0">Klang Valley:</p>
                                        <p class="text-gray font-14 font-GilroyMedium mb-0 ml-3">3-5 Working Days</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="text-gray font-14 font-GilroyMedium mb-0">Peninsular:</p>
                                        <p class="text-gray font-14 font-GilroyMedium mb-0 ml-3">3-5 Working Days</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-sm-3 col-xl-2">
                                    <p class="text-gray font-14 font-GilroyMedium mb-0">Courier Fee</p>
                                </div>
                                <div class="col-12 col-sm-9 col-xl-10 mt-2 mt-sm-0">
                                    <div class="d-flex">
                                        <p class="text-gray font-14 font-GilroyMedium mb-0">Klang Valley:</p>
                                        <p class="text-gray font-14 font-GilroyMedium mb-0 ml-3">Free Delivery</p>
                                    </div>
                                    <div class="d-flex">
                                        <p class="text-gray font-14 font-GilroyMedium mb-0">Peninsular:</p>
                                        <div>
                                            <p class="text-gray font-14 font-GilroyMedium mb-0 ml-3">First 6 Bottles (RM30.00)</p>
                                            <p class="text-gray font-14 font-GilroyMedium mb-0 ml-3">Additional 6 Bottles (RM20.00)
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    @if($bundleDealProducts && count($bundleDealProducts) > 0)
                    <div class="row mt-4 bg-white br-15 p-3 pt-md-5 mx-0 shadow align-items-center">
                        <div class="col-9">
                            <p class="text-gray font-GilroySemiBold">{{trans('label.bundle_deals_buy_it_with_and_get')}} {{$bundleDeal->discount}}% {{trans('label.small_discount')}} </p>
                        </div>
                        <div class="col-3">
                            <button type="button" class="btn btn-block orange-btn-outline font-GilroyBold text-white font-16 " id="buyall" data-id="{{$bundleDeal->id}}">
                                {{trans('label.add_all_to_cart')}}
                            </button>
                        </div>
                        <?php $dataId = []; ?>
                        @foreach($bundleDealProducts as $key=>$deal)
                        <a href="{{ route('productDetail',$deal->product->slug) }}" class="col-12 col-md-6 col-xl-3 mt-3 append-product" name="append-product">
                            <div class="">
                                <img onerror="this.src='{{asset('images/product/product-placeholder.png')}}'" src="{{ $deal->product->images[0]->thumb }}" class="img-fluid prd-image" alt="">
                            </div>
                            <div class="py-2">
                                <h4 class="text-black font-16 font-GilroyBold mb-0">{{$deal->product->name}}</h4>
                                <div class="d-flex flex-wrap align-items-center">
                                    <button class="btn local-seller-btn py-1 px-2 mr-2 mt-2">{{$deal->product->seller->name}}</button>
                                    @if($deal->product->cod)
                                    <button class="btn cod-btn py-1 px-2 mr-3 mt-2">COD</button>
                                    @endif
                                    <div class="mt-2">
                                        <img src="{{asset('assets/images/Location.png')}}" class="img-fluid w-7px" alt="">
                                        <span class="text-light-gray font-10">{{$deal->product->seller->state}}</span>
                                    </div>
                                </div>
                                <h4 class="text-orange font-14 mt-1 font-GilroyBold">RM{{($deal->product->is_variation == '1' && $deal->product->variation) ? number_format($deal->product->variation->sell_price,2) : number_format($deal->product->sell_price, 2) }} (CP) 
                                    <span class="text-light-gray font-10 font-weight-normal">RM{{($deal->product->is_variation == '1' && $deal->product->variation) ? number_format($deal->product->variation->customer_price,2) : number_format($deal->product->customer_price, 2) }} (RSP)</span>
                                </h4>
                                <h4 class="text-light-gray font-12 font-weight-normal"><span
                                    class="text-black mr-1"><img src="{{asset('assets/images/Review.png')}}"
                                    class="img-fluid w-7px mb-1" alt=""> 0</span>
                                    (162) @if($deal->product->sold > 0). {{($deal->product->sold > 1000) ? ceil($deal->product->sold/1000).'K' : $product->sold}} {{trans('label.sold')}} @endif 
                                </h4>
                            </div>
                        </div>
                    </a>
                    <?php $dataId[] = $deal->product->id ?>
                    @if(!$loop->last)
                    <img src="{{asset('assets/images/add.png')}}" style="height: 20px;width: 20px;margin-top: 140px;">
                    @endif
                    @endforeach
                </div>
                @endif
                <div class="row bg-white mx-0 br-15 py-4 px-sm-4 mt-4 shadow overflow-hidden">
                    <div class="col-12 col-lg-4">
                        <h4 class="text-black font-22 font-GilroyBold">{{trans('label.product_rating')}}</h4>
                    </div>

                    <div class="col-12">
                        <div class="row bg-product-rating br-8 p-2 p-sm-4">
                            <div class="col-12 col-md-3">
                                <div>
                                    <h1 class="text-orange mb-0 font-GilroyBold">{{number_format($product->avgReviewRating(),1)}} <span
                                        class="text-gray font-18 font-GilroyBold">/5</span></h1>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        @for ($i = 0; $i < 5; $i++)
                                        @if (floor($product->avgReviewRating()) - $i >= 1)
                                        <img src="{{ asset('assets/images/star.png') }}" class="img-fluid max-w-14px" alt="">
                                        @elseif ($product->avgReviewRating() - $i > 0)
                                        <img src="{{ asset('assets/images/half-star.png') }}" class="img-fluid ml-1 max-w-14px" alt="">
                                        @else
                                        <img src="{{ asset('assets/images/star-grey.png') }}" class="img-fluid ml-1 max-w-14px" alt="">
                                        @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="col-12 col-md-9 mt-3 mt-md-0">
                                    <div class="radio_container">
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="one1" data-id="all" checked>
                                        <label for="one1" class="px-4">All</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="two2" data-id="5">
                                        <label for="two2">5 {{trans('label.star')}} ({{$product->getRateCount($product->id, 5)}})</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="three3" data-id="4">
                                        <label for="three3">4 {{trans('label.star')}} ({{$product->getRateCount($product->id, 4)}})</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="four" data-id="3">
                                        <label for="four">3 {{trans('label.star')}} ({{$product->getRateCount($product->id, 3)}})</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="five" data-id="2">
                                        <label for="five">2 {{trans('label.star')}} ({{$product->getRateCount($product->id, 2)}})</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="six" data-id="1">
                                        <label for="six">1 {{trans('label.star')}} ({{$product->getRateCount($product->id, 1)}})</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="seven" data-id="comment">
                                        <label for="seven">{{trans('label.with_comments')}} ({{$product->getRateCount($product->id, 'comment')}})</label>
                                        <input class="d-none radioRating" type="radio" name="radioRating" id="eight" data-id="media">
                                        <label for="eight">{{trans('label.with_media')}} ({{$product->getRateCount($product->id, 'media')}})</label>
                                    </div>
                                </div>
                            </div>

                            <div id="review-div"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-12 mt-4 mt-lg-0 pt-4">
                    <div class="row mx-0 br-15 bg-dark-blue p-3 p-xl-4 shadow overflow-hidden">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-sm-1">
                                    <img src="{{ asset('assets/images/Glenfarclas.png') }}" class="img-fluid rounded-circle" alt="">
                                </div>
                                <div class="col-12 col-sm-3">
                                    <h4 class="text-white font-22 mb-0 font-GilroyBold">{{$product->seller->name}}</h4>
                                    <!-- <p class="text-white font-14 mb-0 font-GilroyMedium">{{trans('label.active_13_hours_ago')}}</p> -->
                                    <div class="d-flex align-items-center mt-2">
                                        <p class="text-white font-14 mb-0"><img src="{{ asset('assets/images/Location-white.png') }}"
                                            class="img-fluid max-w-14px font-GilroyMedium" alt=""> {{$product->seller->state}}</p>
                                                <!-- <span class="ml-4">
                                                    <img src="{{ asset('assets/images/chat.png') }}" class="img-fluid max-w-24px" alt="">
                                                </span> -->
                                    </div>
                                </div>
                                    <!--  <div class="row mt-4">
                                        <div class="col-6">
                                            <h4 class="text-white font-16 mb-0 font-GilroyBold">99%</h4>
                                            <p class="text-white font-14 mb-0 font-GilroyMedium">Rating</p>
                                        </div>
                                        <div class="col-6">
                                            <h4 class="text-white font-16 mb-0 font-GilroyBold">Within Hours</h4>
                                            <p class="text-white font-14 mb-0 font-GilroyMedium">Response Time</p>
                                        </div>
                                    </div> -->
                                <div class="col-12 col-sm-8 row" id="follow-list">
                                    <div class="col-2  col-sm-2">
                                        <h4 class="text-white font-16 mb-0 font-GilroyBold">{{$product->seller->products->count()}}</h4>
                                        <p class="text-white font-14 mb-0 font-GilroyMedium">{{trans('label.products')}}</p>
                                    </div>
                                    <div class="col-2 col-sm-2">
                                        <h4 class="text-white font-16 mb-0 font-GilroyBold">{{\Carbon\Carbon::parse($product->seller->created_at)->diffForHumans()}}</h4>
                                        <p class="text-white font-14 mb-0 font-GilroyMedium">{{trans('label.joined')}}</p>
                                    </div>
                                    <div class="col-2 follower-count">
                                        <h4 class="text-white font-16 mb-0 font-GilroyBold">{{$product->seller->followers->count()}}</h4>
                                        <p class="text-white font-14 mb-0 font-GilroyMedium">{{trans('label.followers')}}</p>
                                    </div>
                                    <div class="col-3">
                                        @if(Helper::isFollowing($product->seller->id) == false)
                                        <label class="btn btn-block font-GilroyBold font-16 mb-0 follow-button" data-id="{{$product->seller->id}}" style="background-color:white">
                                            <img src="assets/images/add.png" data-id="{{$product->seller->id}}" style="height: 20px;width: 20px;"> &nbsp; {{trans('label.follow')}}</label>
                                            @else
                                            <label class="btn btn-block font-GilroyBold font-16 mb-0 follow-button" data-id="{{$product->seller->id}}" style="background-color:white">
                                                <img src="assets/images/yes.png" data-id="{{$product->seller->id}}" style="height: 20px;width: 20px;"> &nbsp; {{trans('label.following')}}</label>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <a target="_blank" href="{{ route('shopDetail', $product->seller->user->referal_code) }}">
                                            <label class="btn btn-block font-GilroyBold font-16 mb-0" data-id="{{$product->seller->id}}" style="background-color:white">
                                            <img src="assets/images/cart.png"  style="height: 20px;width: 20px;"> &nbsp; {{trans('label.view_shop')}}</label>
                                        </a>
                                    </div>
                                </div>
                                     <!--  <div class="row mt-3">
                            <div class="col-6">
                                <h4 class="text-white font-16 mb-0 font-GilroyBold">99%</h4>
                                <p class="text-white font-14 mb-0 font-GilroyMedium">Chat Response</p>
                            </div>
                            <div class="col-6">
                                <h4 class="text-white font-16 mb-0 font-GilroyBold">4.7k</h4>
                                <p class="text-white font-14 mb-0 font-GilroyMedium">Followers</p>
                            </div>
                        </div> -->

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4 bg-white br-15 p-3 pt-md-5 mx-0 shadow">
        <div class="col-12">
            <p class="text-gray font-GilroySemiBold">{{trans('label.from_the_same_shop')}}</p>
        </div>
        @include('frontend.categoryproducts',['categoryProducts'=>$sameSellerProducts])

        <div class="col-12 mt-4">
            <p class="text-gray font-GilroySemiBold">{{trans('label.you_may_also_like')}}</p>
        </div>

        @include('frontend.categoryproducts')
    </div>
</div>
</section>
@endsection
@section('script')
<script src="{{ asset('js/jquery.flipper-responsive.js') }}"></script>
<script>
    jQuery(function ($) {
        $('#myFlipper').flipper('init');
    });
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();

</script>

<script type="text/javascript">
    var movetowishlist = "{{route('removewishlistproduct')}}";
    $(document).on('click','.thumb',function(e){

        if($(this).hasClass('video')){
            $("#thumb").hide();
            $("#video").show();
        }else{
            $("#video").hide();
            $("#thumb").show();
            $("#thumb").attr("src",$(this).children().attr('data-src'));
        }
        $('.thumb').removeClass('thumb-outline');
        $(this).addClass('thumb-outline');
    });
    $(document).on('click','.follow-button',function(e){
        var sellerId = $(this).data("id");
        var url = "{{ route('updateFollower') }}";
        $.ajax({
            type:'POST',
            url:url,
            data:{
                'seller_id': sellerId,
            },
            success: function(response){
                if(response.success == true){
                    $("#follow-list").load(location.href+" #follow-list>*","");
                }
                $('#variation').html(response.view);
            }
        });

    });
    $(document).on('click','#plus',function(e){
        var currentvalue = parseInt($('#increment').text());
        var value = currentvalue + 1;
        $('#increment').text(value);
        $('#qty').val(value);
    });

    $(document).on('click','#minus',function(e){
        var currentvalue = parseInt($('#increment').text());
        if(currentvalue > 1){
            var value = currentvalue - 1;

            $('#increment').text(value);
            $('#qty').val(value);

        }

    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).on('click','#buynow',function(e){
        $("#addtocart").append("<input type='hidden' name='buy' value='1'/>");
        $('#addtocart').submit();
    });
    $(document).on('change','input[name^="variation"]',function(e){
        var variation = [];
        $('input[name^="variation"]:checked').each(function() {
            variation.push($(this).val());
        });

        var url = "{{ route('getVariation') }}";
        $.ajax({
            type:'POST',
            url:url,
            data:{
                'product_id': $('#product_id').val(),
                'variation': variation,
            },
            success: function(response){
                $('#variation').html(response.view);
            }
        });
    });

    $(document).on('click','.vote',function(e){
        reviewId = $(this).attr("data-reviewid");
        userId = $(this).attr("data-userid");
        check = $(this).attr("data-check");

        var url = "{{ route('submitVote') }}";
        $.ajax({
            type:'POST',
            url:url,
            data:{
                'reviewId': reviewId,
                'userId': userId,
                'check': check,
            },
            success: function(response){
                divName = "review_"+response.review_id;
                $("#"+divName).empty();

                if(response.status == 'delete'){
                    $("#"+divName).prepend('<img src="{{ asset('assets/images/thumb.png') }}" class="img-fluid max-w-14px vote" alt="" data-userid="'+response.user_id+'" data-reviewid="'+response.review_id+'"> <span class="text-gray font-16 font-GilroyBold ml-2">'+response.count+'</span>')
                }else{
                    $("#"+divName).prepend('<img src="{{ asset('assets/images/blue-thumb.png') }}" class="img-fluid max-w-14px vote" alt="" data-userid="'+response.user_id+'"  data-reviewid="'+response.review_id+'"> <span class="text-gray font-16 font-GilroyBold ml-2">'+response.count+'</span>')
                }

            }
        });
    });

    $(document).on('click','.radioRating',function(e){
        filter = $(this).attr("data-id");
        filterReview(filter);
    });

    $(document).on('click','#buyall',function(e){
        var productData = @json(@$dataId);
        var dealId = $(this).attr("data-id");

        var url = "{{ route('addalltocart') }}";
        $.ajax({
            type:'POST',
            url:url,
            data:{productData,dealId },
            success: function(response){
                $(".cus-cart").load(location.href+" .cus-cart>*","");
                toastr.success(response.message);
            }
        });
    });

    function filterReview(filter){
        var url = "{{ route('filterReview') }}";
        $.ajax({
            type:'POST',
            url:url,
            data:{
                'filter': filter,
                'product_id': $('#product_id').val(),
            },
            success: function(response){
                $('#review-div').html(response.view);
            }
        });
    }

    $( document ).ready(function() {
        filterReview('all');
    });
    $(document).on('click','.wishlist',function(e){
        @if(!auth()->check())
        location.href = "{{route('login')}}";
        return;
        @endif
        var $this = $(this);
        $.ajax({
            type:'POST',
            url:movetowishlist,
            data:{
                'slug':  $this.data('slug'),
            },
            success: function(response){
                $("#ratewishlistdetail").load(location.href + " #ratewishlistdetail");

                 // $this.toggleClass('bg-orange');
             }
         });
    })
</script>
@endsection
