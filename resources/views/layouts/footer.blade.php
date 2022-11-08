<section class="bg-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-3">
                <h4 class="text-black font-18 font-GilroyBold">{{trans('label.customer_services')}}</h4>
                <ul class="list-unstyled">
                    @if($customerService && count($customerService) > 0)
                        @foreach($customerService as $service)
                            <li class="mt-2">
                                <a href="{{ route('page', ['slug' => $service->cmsPage->slug]) }}" class="text-gray font-GilroyMedium font-16 text-decoration-none">{{$service->cmsPage->title}}</a>
                            </li>                            
                        @endforeach
                    @endif
                    <li class="mt-2">
                        <a href="{{ route('contactUs') }}" class="text-gray font-GilroyMedium font-16 text-decoration-none">{{trans('label.contact_us')}}</a>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <h4 class="text-black font-18 font-GilroyBold">{{trans('label.about_maxshop')}}</h4>
                <ul class="list-unstyled">
                    @if($aboutMaxshop && count($aboutMaxshop) > 0)
                        @foreach($aboutMaxshop as $maxshop)
                            <li class="mt-2">
                                <a href="{{ route('page', ['slug' => $maxshop->cmsPage->slug]) }}" class="text-gray font-GilroyMedium font-16 text-decoration-none" target="_blank">{{ucfirst($maxshop->cmsPage->title)}}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div>
                    <h4 class="text-black font-18 font-GilroyBold mb-0">{{trans('label.payment')}}</h4>
                    <img src="{{ asset('assets/images/Payment-options.png') }}" class="img-fluid" alt="">
                </div>
                <div>
                    <h4 class="text-black font-18 font-GilroyBold mb-0">{{trans('label.logistic')}}</h4>
                    <img src="{{ asset('assets/images/Logistics-Logo.png') }}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <h4 class="text-black font-18 font-GilroyBold mb-0">{{trans('label.maxshop_app_download')}}</h4>
                <div class="d-flex align-items-center mt-2">
                    <div>
                        <img src="{{ asset('assets/images/QR-Code.png') }}" class="img-fluid max-w-100px" alt="">
                    </div>
                    <div class="ml-2">
                        <img src="{{ asset('assets/images/appStore.png') }}" class="img-fluid d-block max-w-90px"
                            alt="">
                        <img src="{{ asset('assets/images/googlePlay.png') }}"
                            class="img-fluid d-block max-w-90px mt-2 pt-1" alt="">
                        <img src="{{ asset('assets/images/appGallery.png') }}"
                            class="img-fluid d-block max-w-90px mt-2 pt-1" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="bg-dark-blue py-3">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <p class="text-white mb-0 font-14 font-GilroyMedium">© {{date('Y')}} {{trans('label.maxshop')}}. {{trans('label.all_rights_reserved')}}.</p>
            </div>
        </div>
    </div>
</section>