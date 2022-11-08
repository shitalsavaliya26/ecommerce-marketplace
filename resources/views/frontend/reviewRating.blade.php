@extends('layouts.main')
@section('title', 'Review Rating')
@section('css')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection
@section('content')

<div class="py-5">
    <button type="button" class="btn orange-btn text-white bg-orange" data-toggle="modal"
        data-target=".bd-example-modal-lg">Review Rating</button>
</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="exampleModalLabel">Rate Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 position-relative">
                        <img src="assets/images/dollor-orange.png" class="img-fluid max-w-20px review-dropdown-img" alt="">
                        <select
                            class="form-control shadow-none text-black font-GilroySemiBold border-orange bg-yellow-light pl-5"
                            id="exampleFormControlSelect1">
                            <option>Submit a review and & get up to 5 coins! T&Cs apply.</option>
                            <option>Submit a review and & get up to 5 coins! T&Cs apply.</option>
                            <option>Submit a review and & get up to 5 coins! T&Cs apply.</option>
                            <option>Submit a review and & get up to 5 coins! T&Cs apply.</option>
                            <option>Submit a review and & get up to 5 coins! T&Cs apply.</option>
                        </select>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="d-flex flex-column flex-sm-row mt-3">
                            <div class="mr-sm-3">
                                <img src="assets/images/image.png" class="img-fluid max-w-60px br-15" alt="">
                            </div>
                            <div class="mt-3 mt-sm-0">
                                <h4 class="text-black font-GilroyBold font-16 mb-0">Glenfarclas 21 Years (700mL)</h4>
                                <p class="text-medium-gray font-GilroyMedium font-12 mb-0">Variation:Grey/Black,Freesize
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3 text-center">
                        <div class="star-rating">
                            <input id="star-5" type="radio" name="rating" value="star-5" />
                            <label for="star-5" title="5 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-4" type="radio" name="rating" value="star-4" />
                            <label for="star-4" title="4 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-3" type="radio" name="rating" value="star-3" />
                            <label for="star-3" title="3 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-2" type="radio" name="rating" value="star-2" />
                            <label for="star-2" title="2 stars">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                            <input id="star-1" type="radio" name="rating" value="star-1" />
                            <label for="star-1" title="1 star">
                                <i class="active fa fa-star" aria-hidden="true"></i>
                            </label>
                        </div>

                        <div class="review_radio_container">
                            <input class="d-none" type="radio" name="radio" id="Online1" checked>
                            <label for="Online1">Good product quality</label>
                            <input class="d-none" type="radio" name="radio" id="Online2">
                            <label for="Online2">Good value for money</label>
                            <input class="d-none" type="radio" name="radio" id="Online3">
                            <label for="Online3">Fast delivery</label>
                            <input class="d-none" type="radio" name="radio" id="Online4">
                            <label for="Online4">Good product quality</label>
                            <input class="d-none" type="radio" name="radio" id="Online5">
                            <label for="Online5">Good product quality</label>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <div class="bg-product-rating p-3">
                            <textarea class="form-control border-rating text-medium-gray font-GilroyMedium bg-white font-14" id="exampleFormControlTextarea1" rows="4" placeholder="Tell others why you loved this poduct."></textarea>
                            <div class="d-flex flex-column flex-sm-row align-itmes-center mt-3">
                                <div>
                                    <input type="file" id="camera-img" class="d-none">
                                    <label class="border-orange font-GilroySemiBold text-orange bg-white font-14 py-2 cursor-pointer px-4" for="camera-img">
                                        <img src="assets/images/camera.png" class="img-fluid mr-2" alt=""> Add Photo</label>
                                </div>
                                <div class="ml-sm-2">
                                    <input type="file" id="video-img" class="d-none">
                                    <label class="border-orange font-GilroySemiBold text-orange bg-white font-14 py-2 cursor-pointer px-4" for="video-img">
                                        <img src="assets/images/video.png" class="img-fluid mr-2" alt=""> Add Video</label>
                                </div>
                            </div>
                            <p class="text-right text-medium-gray font-GilroyMedium font-16 mb-0">Add 50 Characters with 1 photo and 1 video to earn 5 coins</p>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="custom-control custom-checkbox review-checkbox mt-2 ml-2">
                            <input type="checkbox" class="custom-control-input" id="reviewCheck">
                            <label class="custom-control-label text-black font-GilroySemiBold font-16 pl-2" for="reviewCheck">Leave your review anonymously</label>
                            <p class="text-medium-gray font-GilroyMedium font-14 mb-0 pl-2">Your user name will be shown as |*****1</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn bg-transparent text-black shadow-none"
                    data-dismiss="modal">Cancel</button>
                <button type="button"
                    class="btn orange-btn text-white bg-orange rounded-0 px-4 shadow-none">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection