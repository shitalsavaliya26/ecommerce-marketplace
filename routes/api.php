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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('agent/v1')->group(function () {
    Route::post('/login', 'Api\Agent\V1\LoginController@login');
    Route::post('/categories', 'Api\Agent\V1\CategoryController@getCategory');
    Route::post('/categoryProducts', 'Api\Agent\V1\CategoryController@getCategoryProducts');
    Route::post('/agents', 'Api\Agent\V1\AgnetController@getAgents');
});
