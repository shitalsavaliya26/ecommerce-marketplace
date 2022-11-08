<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::get('/sub-category', 'HomeController@subCategory')->name('subCategory');
Route::get('/view-shop', 'HomeController@viewShop')->name('viewShop');

/******************** customer routes ********************/


Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::middleware(['localization', 'checkstatus'])->group(function () {
    Auth::routes();

    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/loginwithphone', 'Auth\LoginController@showLoginWithPhone')->name('login.phone');
    Route::post('/sponsorUserExits', 'Auth\RegisterController@sponsorUserExits')->name('sponsorUserExits');
    Route::get('/showProduct/{slug}', 'HomeController@showProduct')->name('show-product');
    Route::post('/ipaycallback', 'PaymentCallbackController@ipaycallback')->name('ipaycallback');
    Route::post('/thankyou', 'OrderContoller@thankyou')->name('thankyou');
    Route::get('/verify-otp/{id}', 'Auth\RegisterController@verifyOtp')->name('verifyOtp');
    Route::post('/confirm-otp', 'Auth\RegisterController@confirmOtp')->name('confirmOtp');

    Route::middleware(['intended'])->group(function () {
        Route::get('/bundleDeals', 'HomeController@bundleDeals')->name('bundleDeals');
        Route::get('/notification', 'HomeController@notification')->name('notification');
        Route::get('/helpCenter', 'HomeController@helpCenter')->name('helpCenter');
        Route::get('/checkoutNew', 'HomeController@checkoutNew')->name('checkoutNew');
        Route::get('/reviewRating', 'HomeController@reviewRating')->name('reviewRating');
        Route::get('/', 'HomeController@index')->name('home');
        Route::get('/maxShopMall', 'HomeController@maxShopMall')->name('maxshopmall');
        Route::get('/searchFilter', 'HomeController@searchFilter')->name('searchfilter');
        Route::get('/category/{catslug?}', 'HomeController@searchFilter')->name('show-category');
        Route::post('/addtocart', 'CartController@addtocart')->name('addtocart');

        Route::middleware(['auth'])->group(function () {

            /* profile route */
            Route::get('/profile', 'ProfileController@index')->name('user.profile');
            Route::get('/orders', 'ProfileController@orders')->name('user.orders');
            Route::post('/upload_image', 'ProfileController@uploadImage')->name('user.upload_image');
            Route::post('/set_default_address', 'ProfileController@setDefaultAddress')->name('user.set_default_address');
            Route::post('/add_address', 'ProfileController@addAddress')->name('user.add_address');
            Route::post('/change_password', 'ProfileController@changePassword')->name('user.change_password');
            Route::post('/delete_address', 'ProfileController@deleteAddress')->name('user.delete_address');
            Route::post('/edit_profile', 'ProfileController@editProfile')->name('user.edit_profile');
            Route::post('/submit_review', 'ProfileController@submitReview')->name('user.submit_review');
            Route::post('/get_user_address', 'ProfileController@getAddress')->name('user.get_address');
            Route::post('/update_address', 'ProfileController@updateAddress')->name('user.update_address');
            Route::get('/wallet', 'ProfileController@wallet')->name('user.wallet');
            Route::post('/addamount', 'ProfileController@addamount')->name('user.addamount');
            Route::get('/pv_point_withdraw', 'ProfileController@pvPointWithdraw')->name('user.pv_point_withdraw');
            Route::post('/convert_pv_point', 'ProfileController@convertPvPoint')->name('user.convert_pv_point');
            Route::get('/coin_history', 'ProfileController@coinHistory')->name('user.coin_history');
            Route::get('/my_vouchers', 'ProfileController@myVouchers')->name('user.my_vouchers');
            
            //Withdraw 
            Route::post('/wallet_withdraw', 'ProfileController@walletWithdraw')->name('user.wallet_withdraw');

            /* wishlist */
            Route::get('/wishlist', 'WishlistController@index')->name('user.wishlist');
            Route::post('/wishlistaddremove', 'WishlistController@wishlistaddremove')->name('removewishlistproduct');
            Route::post('/moveToCart', 'WishlistController@moveToCart')->name('moveToCart');

            /* cart api */
            Route::post('/addalltocart', 'CartController@addAllToCart')->name('addalltocart');
            Route::post('/getVariation', 'HomeController@getVariation')->name('getVariation');
            Route::get('/viewcart', 'CartController@viewcart')->name('viewcart');
            Route::post('/deletecartproduct', 'CartController@deletecartproduct')->name('removecartproduct');
            Route::put('/updatecart', 'CartController@updatecart')->name('updatecart');
            Route::put('/addvoucherurl', 'CartController@addvoucherurl')->name('addvoucherurl');
            Route::post('/validatecart', 'ApiController@validatecart');
            Route::put('/getsellervoucher', 'CartController@getSellerVoucher')->name('getSellerVoucher');
            Route::put('/setsellervoucher', 'CartController@setSellerVoucher')->name('setSellerVoucher');
            Route::put('/checkcoin', 'CartController@checkCoin')->name('checkcoin');
            Route::put('/getproductvoucher', 'ApiController@getProductVoucher')->name('getproductvoucher');
            Route::put('/getproductvoucherincheckout', 'ApiController@getProductVoucherInCheckout')->name('getproductvoucherincheckout');
            Route::put('/getuseraddress', 'CartController@getUserAddress')->name('getuseraddress');

            /* wishlist */
            Route::post('/movetowishlist', 'CartController@movetowishlist')->name('movetowishlist');

            /* order */
            Route::get('/orders/detail/{order_id}', 'OrderContoller@viewOrderDetail')->name('user.orders.view');
            Route::get('/orders/edit/{order_id}/{updated?}', 'OrderContoller@editOrder')->name('user.order.edit');
            Route::put('/orders/updateqty', 'OrderContoller@updateqty')->name('user.order.updateqty');
            Route::get('/orders/pay/{order_id}', 'OrderContoller@payByWallet')->name('user.order.payByWallet');
            Route::post('/submitVote', 'HomeController@submitVote')->name('submitVote');
            Route::get('/shockingsale', 'HomeController@shockingsale')->name('shockingsale');

            Route::post('/changecart', 'OrderContoller@changecart')->name('changecart');
            Route::get('/checkout', 'OrderContoller@checkout')->name('checkout');
            Route::get('/add_balance', 'OrderContoller@add_balance')->name('add_balance');
            Route::post('/cancelorder', 'OrderContoller@cancelorder')->name('cancelorder');
            Route::put('/getaddresshtml', 'OrderContoller@getaddresshtml')->name('getaddresshtml');
            Route::put('/checkcheckoutshipping', 'OrderContoller@checkCheckoutShipping')->name('checkcheckoutshipping');
            Route::post('/placeorder', 'OrderContoller@placeorder')->name('placeorder');
            Route::put('/changeShippingMethod', 'OrderContoller@changeShippingMethod')->name('changeShippingMethod');
            Route::get('/view-notification', 'HomeController@viewNotification')->name('viewNotification');
            Route::put('/getproduct', 'OrderContoller@getProduct')->name('getproduct');
            Route::post('/submitReview', 'OrderContoller@submitReview')->name('submitReview');
            Route::get('/getvoucherdata', 'OrderContoller@getVoucherData')->name('getvoucherdata');
            Route::put('/claimvoucher', 'PromotionController@claimvoucher')->name('claimvoucher');
            Route::put('/redeemVoucher', 'PromotionController@redeemVoucher')->name('redeemVoucher');

            /* help and support */
            Route::resource('help-support', 'SupportTicketController');
            Route::get('help-support-replay/{id}', 'SupportTicketController@supportReplay')->name('supportReplay');
            Route::get('help-support-close/{slug}', 'SupportTicketController@supportClose')->name('supportClose');
            Route::post('help-support-replay-message', 'SupportTicketController@supportReplayPost')->name('supportReplayPost');

            Route::post('/updateFollower', 'OrderContoller@updateFollower')->name('updateFollower');

            /* agent commission */
            Route::get('commission', 'AgentController@commission')->name('user.commission');
            Route::get('/network', 'AgentController@network')->name('user.network');

        });
    Route::post('/addKeyword', 'HomeController@addKeyword')->name('addKeyword');
    Route::get('/contact-us', 'HomeController@contactUs')->name('contactUs');
    Route::post('/contact-us/send', 'HomeController@contactUsSend')->name('contactUs.send');
    Route::get('/{slug}', 'HomeController@productDetail')->name('productDetail');
    Route::get('page/{slug}','HomeController')->name('page');
    Route::get('shop/{slug}','HomeController@shopDetail')->name('shopDetail');
    Route::get('shopCategoryProduct/{id}','HomeController@shopCategoryProduct')->name('shopCategoryProduct');

    Route::get('sellers/{seller}/{id}','HomeController@sellerMall')->name('seller.mall');
    /* promotion */
    Route::get('/promotion/{slug}', 'PromotionController@view')->name('promotion');
    });
Route::post('/filterReview', 'HomeController@filterReview')->name('filterReview');

});