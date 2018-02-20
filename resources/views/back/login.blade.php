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

Route::get('/', 'GetController@getShop');

Route::get('/home', 'UserController@home');

Route::get('/summary', 'UserController@summary');

Route::get('/history', 'UserController@history');

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
	Route::get('/history', 'CartController@historyCart');

	Route::get('/forget_test', 'TestController@deleteCart');

});


// Route::post('/getShop', 'GetController@getShop');

// Route::post('/getMenu', 'GetController@getMenu');

Route::post('/testEncryptDecrypt', 'TestController@testEncryptDecrypt');
Route::get('/testSessions', 'TestController@testSessionData');

Route::post('/test', [
	'uses' => 'TestController@testFunction',
	'as' => 'testFunction'
]);

Route::get('/devtest', 'UserController@index');