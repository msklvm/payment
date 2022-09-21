<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index');
Route::get('payform', 'PayController@index')->name('pay-index');
//Route::get('payclient', 'PayController@payClient')->name('pay-client');
Route::group(['prefix' => 'pay'], function () {
    Route::get('', 'PayController@pay')->name('pay');
    Route::get('checkout', 'PayController@checkout')->name('checkout');

    Route::post('details', 'PayController@details')->name('pay.details');
});

Route::group(['prefix' => ''], function () {
    Route::resource('shop', 'Shop\ShopController');
    Route::get('logo/{id}', 'Shop\ShopController@logo')->name('shop.logo');

    Route::get('shop/form-template/{shop}', 'Shop\ShopController@form')->name('shop.form');
    Route::post('shop/form-template/{shop}', 'Shop\ShopController@form_update')->name('shop.form_update');
});

Route::resource('product', 'Shop\ProductController');

Route::group(['prefix' => 'admin'], function () {
    Route::resource('user', 'Admin\UserController');
    Route::put('user/password/{user}', 'Admin\UserController@password')->name('user.password');

    Route::resource('role', 'Admin\RoleController');
});

Route::resource('order', 'Shop\OrderController');

Route::get('notifications', function () {
    return view('pages.notifications.index');
});

Route::group(['prefix' => 'error-pages'], function () {
    Route::get('error-404', function () {
        return view('pages.error-pages.error-404');
    });
    Route::get('error-500', function () {
        return view('pages.error-pages.error-500');
    });
});

// For Clear cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}', function () {
    return View::make('pages.error-pages.error-404');
})->where('page', '.*');
