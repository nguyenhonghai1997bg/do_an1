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

Auth::routes();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => '/', 'middleware' => 'locale'], function() {
    Route::get('products/{id}/{slug}', 'ProductController@show')->name('frontend.products.show');
    Route::resource('reviews', 'ReviewController');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'authAdmin', 'locale'], 'namespace' => 'Admin'], function(){
    Route::get('/', 'HomeController@index');
    Route::group(['prefix' => 'manager'], function(){
        Route::resources([
            'catalogs' => 'CatalogController',
            'categories' => 'CategoryController',
            'paymethods' => 'PaymethodController',
            'products' => 'ProductController',
        ]);
        Route::delete('images/{id}/destroy', 'ImageController@destroy');
        Route::post('products/{id}/change-status', 'ProductController@changeStatus');
    });
    Route::group(['prefix' => 'setting'], function(){
        Route::resources([
            'roles' => 'RoleController',
            'users' => 'UserController',
        ]);
    });
});

// Route::get('/', function () {
//     return view('admin.index');
// });

Route::group(['prefix' => 'setLocale'], function() {
    Route::get('/{locale}', 'LocaleController@change_language')->name('set_locale');
});