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

Route::get('/', function () { 
	// return View::make('auth.login');
	return redirect()->route('login');
});

Route::get('/image/{image_name}', [
	'uses' => 'BACK_ItemController@imageView',
	'as' => 'imageView'
]); 

Route::group(['middleware' => 'auth'], function(){
	
	Route::get('/home', 'HomeController@index')->name('home');
	
	Route::get('/dashboard', 'BACK_UserController@viewDashboard');

	Route::get('/services', 'BACK_UserController@viewServices');

	Route::get('/shops', 'BACK_UserController@viewShops');

	Route::get('/switchshop', 'BACK_UserController@viewSwitchShop');

	Route::get('/categories', 'BACK_UserController@viewCategories');
	
	Route::get('/users', 'BACK_UserController@viewUsers');

	Route::get('/items', 'BACK_UserController@viewItem');

	Route::get('/redirect_url','BACK_Redirect@redirectMe');

});

Auth::routes();

Route::group(['prefix' => 'fs'], function () {

	Route::post('/verify/{encrypt}', 'BACK_VerifyController@verifyUserShops');

	Route::group(['prefix' => 'back'], function () {
		Route::group(['prefix' => 'get'], function () {
			Route::post('/shoplist', 'BACK_GetController@shopList');

			Route::post('/switchshoplist', 'BACK_GetController@switchShopList');

			Route::post('/categorieslist', 'BACK_GetController@categoriesList');

			Route::post('/userslist', 'BACK_GetController@usersList');

			Route::post('/serviceslist', 'BACK_GetController@servicesList');
			
			
			Route::get('/catlist/{parent_flg}', 'BACK_ItemController@getCategory');
			
			Route::get('/itemslist/{category_id}', 'BACK_ItemController@getItem');
			
			Route::get('/fooditemlist/{category_id}/{sub_category_id}', 'BACK_ItemController@getFooditem');
			
			Route::get('/item-dtl', 'BACK_ItemController@getitemDtl');
			
			Route::get('/item/{item_id}', 'BACK_ItemController@getItemInfo');
		});

		Route::group(['prefix' => 'create'], function () {

			Route::post('/user', 'BACK_CreateController@createUser');

			/* SHOP */
			Route::post('/shop', 'BACK_CreateController@createShop');

			/* CATEGORIES */
			Route::post('/category', 'BACK_CreateController@createCategory');

			/* SERVICES PAGE */
			Route::post('/servicesitem', 'BACK_CreateController@createServicesItem');
			
			Route::post('/item-seq', 'BACK_ItemController@itemSequence');
			
			Route::post('/item', 'BACK_ItemController@createItem');

			/* USERS */
			Route::post('/user','BACK_CreateController@createUser');

		});

		Route::group(['prefix' => 'update'], function () {

			/* SHOP */
			Route::post('/shop', 'BACK_UpdateController@updateShop');
			Route::post('/shop/delete', 'BACK_UpdateController@updateShopDeleteFlag'); // update MST_SHOP.DELETE_FLG
			Route::post('/shop/lockunlock', 'BACK_UpdateController@updateLockFlag'); // update MST_SHOP.LOCK_FLG

			/* CATEGORY */
			Route::post('/category', 'BACK_UpdateController@updateCategory');
			Route::post('/category/view', 'BACK_UpdateController@updateCategoryViewFlag');

			/* SERVICE */
			Route::post('/service', 'BACK_UpdateController@updateService');
			Route::post('/service/view', 'BACK_UpdateController@updateServiceViewFlag');

			/* USER */
			Route::post('/user', 'BACK_UpdateController@updateUser');
			Route::post('/user/lockunlock', 'BACK_UpdateController@updateUserLockFlag'); // update MST_USER.LOCK_FLG

			/* FOOD and ITEM */
			Route::post('/item/view', 'BACK_ItemController@UpdateFoodAndItemFlag');

		});

		Route::group(['prefix' => 'delete'], function () {

			/* SHOP */
			Route::post('/shop', 'BACK_DeleteController@deleteShop');

			/* CATEGORY */
			Route::post('/category', 'BACK_DeleteController@deleteCategory');

			/* SERVICE */
			Route::post('/service', 'BACK_DeleteController@deleteService');

			/* USER */
			Route::post('/user', 'BACK_DeleteController@deleteUser');

		});

		Route::group(['prefix' => 'action'], function () {

			Route::post('/switchshop', 'BACK_LoadShop@loadShop');
			
			Route::group(['prefix' => 'get'], function () {
				/* SHOP */
				Route::post('/shopno/{no}', 'BACK_ActionGetController@checkShopFcNo');
				Route::post('/shopinfo/{no}', 'BACK_ActionGetController@getShopInfo');

				/* CATEGORY */
				Route::post('/parentcategory', 'BACK_ActionGetController@getParentCategory');
				Route::post('/parentcategoryinfo', 'BACK_ActionGetController@getParentCategoryInfo'); // get category info
				Route::post('/checkitems', 'BACK_ActionGetController@getCheckItems'); // check for items

				/* SERVICES */
				Route::post('/servicecategory', 'BACK_ActionGetController@getServicesCategory');
				Route::post('/infoservice/{no}', 'BACK_ActionGetController@getInfoService');

				/* Switch shop */
				Route::post('/servicecategory', 'BACK_ActionGetController@getServicesCategory');
				Route::post('/infoservice/{no}', 'BACK_ActionGetController@getInfoService');

				/* Users */
				Route::post('/user', 'BACK_ActionGetController@getUser');
				// Route::post('/usershoplist', 'BACK_ActionGetController@getUserShopList');

			});
	
		});
		
		
		Route::group(['prefix' => 'delete'], function () {
			
			Route::post('/item', 'BACK_ItemController@deleteItem');
		});
		
	});

	Route::group(['prefix' => 'schema'], function() {
		Route::post('/c', 'BACK_DBSchema@createDBSchema');
		Route::post('/d', 'BACK_DBSchema@deleteDBSchema');
	});

	

});