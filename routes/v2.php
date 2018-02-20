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
Route::get('test_hello', function () {
    return 'Hello World';
});

Route::get('/', 'v2\GetController@getShop');

Route::get('/home', 'v2\UserController@home');

Route::get('/summary', 'v2\UserController@summary');

Route::get('/history', 'v2\UserController@history');

Route::post('/bill-out', 'v2\UserController@billOut');

Route::post('/bill-out-cancel', 'v2\UserController@billoutCancel');

Route::group(['prefix' => 'verify'], function() {
	Route::any('/host_name','v2\LaunchController@verifyIP');
	// Route::post('/','LaunchController@verifyIP');
});

Route::group(['prefix' => 'get'], function() {
	Route::get('/shop', 'v2\GetController@getShop');

	Route::post('/seat', 'v2\GetController@getSeat');

	Route::post('/category', 'v2\GetController@getCategory');

	Route::post('/subcategory', 'v2\GetController@getSubCategory');

	Route::post('/menu', 'v2\GetController@getMenu');
	
	Route::post('/categoryNm', 'v2\GetController@getCategoryID');

	Route::post('/pricegender', 'v2\GetController@getPriceGender');

	Route::post('/groupcategory', 'v2\GetController@getGroupCategory');

	Route::post('/checkbillout','v2\GetController@checkPendingBillOut'); // check billout

	Route::post('/name', 'v2\GetController@getItemName');

	Route::post('/gender', 'v2\GetController@getGender');
	
	Route::get('/status', 'v2\GetController@getStatus');
	
	Route::get('/gender/status', 'v2\GetController@getGenderStatus');
	
	Route::get('/item/status', 'v2\GetController@getItemStatus');
});

Route::group(['prefix' => 'cart'], function() {
	// Route::post('/forget', 'CartController@deleteCart');
	Route::post('/view', 'v2\CartController@getDetails');

	Route::post('/forget', 'v2\CartController@deleteCart');

	Route::post('/delete/{item_id}', 'v2\CartController@deleteToCart');

	Route::post('/menu/{item_id}/read', 'v2\CartController@readCartItem');

	Route::post('/add', 'v2\CartController@addToCart'); 
	// Route::post('/add/{item_id}/{quantity}', 'v2\CartController@addToCart');
	// Route::post('/add_test', 'TestController@testFunction');

	Route::post('/order', 'v2\CartController@placeOrder');
	Route::post('/order_food', 'v2\CartController@placeOrderFood');
	Route::get('/check', 'v2\CartController@checkOrder');
	Route::get('/history', 'v2\CartController@historyCart');

	Route::get('/forget_test', 'v2\TestController@deleteCart');

});

Route::post('/testEncryptDecrypt', 'v2\TestController@testEncryptDecrypt');
Route::get('/testSessions', 'v2\TestController@testSessionData');
Route::get('/check-session', 'v2\TestController@checkSession');
Route::get('/testGender', 'v2\TestController@getGender');

Route::post('/test', [
	'uses' => 'v2\TestController@testFunction',
	'as' => 'testFunction'
]);

Route::get('/devtest', 'v2\UserController@index');