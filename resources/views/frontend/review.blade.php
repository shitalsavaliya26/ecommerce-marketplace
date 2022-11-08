@if($reviews)
    @foreach($reviews as $key=>$review)
        @if($key != 0) <hr /> @endif
        <div class="row mt-3 mb-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-6 col-md-2 order-1">
                        <img  onerror="this.src='{{asset('assets/images/User.png')}}'" src="{{ $review->user->image }}" class="img-fluid rounded-circle max-w-60px" alt="">
                    </div>
                    <div class="col-12 col-md-9 order-3 order-md-2">
                        <div>
                            <h1 class="text-black mb-0 font-GilroySemiBold font-20">{{$review->user->name}}</h1>
                        </div>
                        <div class="d-flex align-items-center">
                            @for ($i = 0; $i < 5; $i++)
                                @if (floor($review->rate) - $i >= 1)
                                    <img src="{{ asset('assets/images/star.png') }}" class="img-fluid max-w-14px" alt="">
                                @elseif ($review->rate - $i > 0)
                                    <img src="{{ asset('assets/images/half-star.png') }}" class="img-fluid ml-1 max-w-14px" alt="">
                                @else
                                    <img src="{{ asset('assets/images/star-grey.png') }}" class="img-fluid ml-1 max-w-14px" alt="">
                                @endif
                            @endfor
                        </div>

                        <div class="mt-2">
                            <p class="text-light-gray font-16 mb-0 font-GilroyMedium">
                                {{$review->description}}
                            </p>
                        </div>

                        <div class="d-flex flex-wrap align-items-center">
                            @if($review->reviewRatingImages)
                                @foreach($review->reviewRatingImages as $image)
                                    <img src="{{ $image->image }}"
                                    class="img-fluid mr-2 max-w-90px mt-3" alt="">
                                @endforeach
                            @endif
                        </div>
                        <p class="text-light-gray font-12 mb-0 mt-1">{{$review->created_at->format('d-m-Y H:i')}}</p>

                        @if(($review->reply != null) && ($review->reply != ''))
                        <div class="bg-gray-light br-8 p-3 mt-2">
                            <h1 class="text-black mb-0 font-GilroyBold font-24">{{trans('label.seller_response')}}:
                            </h1>
                            <p class="text-light-gray font-18 mt-2 mb-0 font-GilroyRegular">{{$review->reply}}</p>
                        </div>
                        @endif
                    </div>
                    <div class="col-6 col-md-1 order-2 order-md-3">
                        <div class="d-flex align-items-center justify-content-end justify-content-md-start" id="review_{{$review->id}}">
                            @if(auth()->user())
                                @if (array_search(auth()->user()->id, array_column($review->reviewRatingVotes->toArray(), 'user_id')) !== FALSE)
                                    <img src="{{ asset('assets/images/blue-thumb.png') }}" class="img-fluid max-w-14px vote" alt="" data-userid="{{Auth::user()->id}}" data-reviewid="{{$review->id}}" data-check="true">
                                @else
                                    <img src="{{ asset('assets/images/thumb.png') }}" class="img-fluid max-w-14px vote" alt="" data-userid="{{Auth::user()->id}}" data-reviewid="{{$review->id}}" data-check="false">
                                @endif
                            @else
                                <img src="{{ asset('assets/images/thumb.png') }}" class="img-fluid max-w-14px" alt="">
                            @endif
                            <span class="text-gray font-16 font-GilroyBold ml-2">{{count($review->reviewRatingVotes)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif