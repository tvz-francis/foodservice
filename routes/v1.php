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

Route::get('/', 'GetController@getShop');

Route::get('/home', 'UserController@home');

Route::get('/summary', 'UserController@summary');

Route::get('/history', 'UserController@history');

Route::post('/bill-out', 'UserController@billOut');

Route::post('/bill-out-cancel', 'UserController@billoutCancel');

Route::group(['prefix' => 'verify'], function() {
	Route::any('/host_name','LaunchController@verifyIP');
	// Route::post('/','LaunchController@verifyIP');
});

Route::group(['prefix' => 'get'], function() {
	Route::get('/shop', 'GetController@getShop');

	Route::post('/seat', 'GetController@getSeat');

	Route::post('/category', 'GetController@getCategory');

	Route::post('/subcategory', 'GetController@getSubCategory');

	Route::post('/menu', 'GetController@getMenu');
	
	Route::post('/categoryNm', 'GetController@getCategoryID');

	Route::post('/pricegender', 'GetController@getPriceGender');

	Route::post('/groupcategory', 'GetController@getGroupCategory');

	// 

	Route::post('/name', 'GetController@getItemName');

	Route::post('/gender', 'GetController@getGender');
	
	Route::get('/status', 'GetController@getStatus');
	
	Route::get('/gender/status', 'GetController@getGenderStatus');
});

Route::group(['prefix' => 'cart'], function() {
	// Route::post('/forget', 'CartController@deleteCart');
	Route::post('/view', 'CartController@getDetails');

	Route::post('/forget', 'CartController@deleteCart');

	Route::post('/delete/{item_id}', 'CartController@deleteToCart');

	Route::post('/menu/{item_id}/read', 'CartController@readCartItem');

	Route::post('/add/{item_id}/{quantity}', 'CartController@addToCart');
	// Route::post('/add_test', 'TestController@testFunction');

	Route::post('/order', 'CartController@placeOrder');
	Route::post('/order_food', 'CartController@placeOrderFood');
	Route::get('/check', 'CartController@checkOrder');
	Route::get('/history', 'CartController@historyCart');

	Route::get('/forget_test', 'TestController@deleteCart');

});


// Route::post('/getShop', 'GetController@getShop');

// Route::post('/getMenu', 'GetController@getMenu');

Route::post('/testEncryptDecrypt', 'TestController@testEncryptDecrypt');
Route::get('/testSessions', 'TestController@testSessionData');
Route::get('/check-session', 'TestController@checkSession');
Route::get('/testGender', 'TestController@getGender');

Route::post('/test', [
	'uses' => 'TestController@testFunction',
	'as' => 'testFunction'
]);

Route::get('/devtest', 'UserController@index');