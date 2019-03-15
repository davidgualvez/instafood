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

// front
Route::get('/groups',                               'PageController@groups');
Route::get('/groups/category',                      'PageController@category');
Route::get('/groups/category/items',                'PageController@items');
Route::get('/groups/category/items/item',           'PageController@item');
Route::get('/', function () {
    return view('home');
});

// api
Route::post('/costumer', 					        'CustomerController@store');

Route::get('/login',    					        'LoginController@show');
Route::post('/login',   					        'LoginController@login');

Route::post('/groups',                              'PartLocationController@groups');
Route::post('/groups/{gid}/category',               'ProductCategoryController@getByGroupCode');
Route::post('/groups/category/items',               'PartLocationController@items');

Route::post('/products', 					        'PartLocationController@lists');
Route::post('/products/group', 				        'PartLocationController@groups');
Route::post('/products/group/category/{id}',        'ProductCategoryController@getByGroupCode');

Route::post('/product/{pid}/components',	        'PartLocationController@getComponents');
Route::get('/products/group/{id}', 			        'PartLocationController@getByGroup');

Route::post('/sales-order',                         'SalesOrderController@store');
Route::post('/customer/search',                      'CustomerController@search');

Route::post('/order-slip/empty',                    'OrderSlipHeaderController@storeEmpty');
Route::post('/order-slip/add-new-item',             'OrderSlipHeaderController@addNewItem');
