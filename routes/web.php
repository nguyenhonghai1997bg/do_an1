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

    // Route::get('/foo', 'ProductController@searchByPrice');


Auth::routes();
Route::get('/', 'HomeController@index')->name('home')->middleware('authUser');
Route::get('/home', 'HomeController@index')->middleware('authUser');
Route::get('/logout', 'Auth\LoginController@logout')->middleware('auth')->name('users.logout');
Route::group(['prefix' => '/', 'middleware' => ['authUser', 'locale']], function() {
    Route::get('products/{id}/{slug}', 'ProductController@show')->name('frontend.products.show');
    Route::resource('reviews', 'ReviewController');
    // cart
    Route::post('carts', 'CartController@store');
    Route::delete('carts/{id}/destroy', 'CartController@destroy');
    Route::get('carts/checkout', 'CartController@checkout')->name('carts.checkout');
    Route::patch('carts/update', 'CartController@update')->name('carts.update');
    Route::post('orders', 'OrderController@store')->name('orders.store');
    Route::get('orders/done', 'OrderController@orderDone')->name('orders.done');

    Route::get('orders/list', 'OrderController@listOrderByUser')->middleware('auth')->name('users.show.list-order');
    Route::get('orders/list/deleted', 'OrderController@listOrderByUserDeleted')->middleware('auth')->name('users.show.list-order-deleted');
    Route::get('orders/{id}/detail', 'OrderController@detailOrder')->middleware('auth')->name('users.orders.detail');
    Route::delete('orders/{id}/destroy', 'OrderController@destroy')->middleware('auth')->name('users.orders.delete');
    Route::get('products/sales', 'ProductController@listSale')->name('products.sale');

    Route::get('category/products/', 'ProductController@search')->name('users.search');
    Route::get('products/search-by-price', 'ProductController@searchByPrice');
    Route::post('notifies/seen/{id}', 'Admin\NotifyController@seen');
    Route::get('notifies/users', 'NotifyController@allNotifies')->name('users.allNotifies');

});

Route::group(['prefix' => 'admin', 'middleware' => ['authAdmin', 'locale'], 'namespace' => 'Admin'], function(){
    Route::get('/', 'HomeController@index')->name('admin.home');
    Route::group(['prefix' => 'manager'], function(){
        Route::resources([
            'catalogs' => 'CatalogController',
            'categories' => 'CategoryController',
            'paymethods' => 'PaymethodController',
            'products' => 'ProductController',
        ]);
        Route::post('notifies/seen/{id}', 'NotifyController@seen');
        Route::get('notifies/', 'NotifyController@index')->name('admin.notifies.index');
        Route::get('orders/waiting', 'OrderController@listOrderWaiting')->name('admin.orders.waiting');
        Route::get('orders/process', 'OrderController@listOrderProcess')->name('admin.orders.process');

        Route::get('orders/detail/{id}', 'OrderController@show')->name('admin.orders.show');
        Route::get('orders/done', 'OrderController@listOrderDone')->name('admin.orders.done');
        Route::get('orders/deleted', 'OrderController@listOrderDeleted')->name('admin.orders.deleted');
        Route::post('orders/do/done', 'OrderController@orderDone');
        Route::post('orders/do/waiting', 'OrderController@orderWaiting');
        Route::post('orders/do/process', 'OrderController@orderProcess');
        Route::delete('orders/{id}/destroy', 'OrderController@orderDestroy');
        Route::delete('images/{id}/destroy', 'ImageController@destroy');
        Route::post('products/{id}/change-status', 'ProductController@changeStatus');

        Route::get('all-orders-done', 'OrderController@getAllOrdersDone');
        Route::get('count-order', 'OrderController@getDataDoughnut');

        Route::get('downloadExcel/{type}', 'OrderController@downloadExcel');
    });
    Route::group(['prefix' => 'setting'], function(){
        Route::resources([
            'roles' => 'RoleController',
            'users' => 'UserController',
        ]);
        Route::get('list-new-users', 'UserController@listNewUsers')->name('users.listNewUsers');
    });
});

// Route::get('/', function () {
//     return view('admin.index');
// });

Route::group(['prefix' => 'setLocale'], function() {
    Route::get('/{locale}', 'LocaleController@change_language')->name('set_locale');
});