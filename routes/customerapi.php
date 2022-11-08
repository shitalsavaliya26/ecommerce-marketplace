<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::group(['namespace' => 'V1','prefix' => 'v1', 'localization'], function () {

    /* Auth Routes */
    Route::get('getStates','CommonController@getStates');
    Route::post('login','AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::post('forgot-password', 'AuthController@forgotPassword');
    Route::post('verify_agent', 'AuthController@verifyAgent');

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::get('logout', 'AuthController@logout');

        /* cart */
        Route::post('addtocart', 'CartController@addtocart');
        Route::get('viewcart', 'CartController@viewcart');
        Route::post('updatecart', 'CartController@updatecart');
        Route::post('deletecartproduct', 'CartController@deletecartproduct');

        /* wishlist */
        Route::post('move_to_wishlist', 'CartController@moveToWishlist');
        Route::post('wishlistaddremove', 'WishlistController@wishlistaddremove');
        Route::get('get_wishlist', 'WishlistController@getWishlist');
        Route::post('move_to_cart', 'WishlistController@moveToCart');

        /* vouchers */
        Route::post('getproductvoucher', 'CheckoutController@getProductVoucher');
        Route::post('use_product_voucher', 'CheckoutController@useProductVoucher');
        Route::post('getsellervoucher', 'CheckoutController@getSellerVoucher');
        Route::post('use_seller_voucher', 'CheckoutController@useSellerVoucher');

    });

    /* pages */
    Route::get('home', 'PageController@home');
    Route::post('search', 'PageController@search');
    Route::get('getsearchfilter', 'PageController@getSearchfilter');
    Route::post('product_detail', 'PageController@productDetail');
    Route::post('product_variations', 'PageController@productVariations');

});
