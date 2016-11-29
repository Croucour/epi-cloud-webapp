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
Route::get('/logout', function () {
    Auth::logout();
    Session::flush();
    return redirect('/login');
});

Route::get('/', 'DashboardController@index');


Route::group(['prefix' => 'vms'], function () {
    Route::get('/', 'VMController@index');
    Route::get('/{id}', 'VMController@show')->where('id', '[0-9]+');
    Route::get('/{id}/edit', 'VMController@edit')->name("vm.edit");
    Route::post('/{id}/update', 'VMController@update')->name("vm.update");

    Route::get('/create', 'VMController@create')->name("vm.create");
    Route::post('/store', 'VMController@store')->name("vm.store");


    Route::get('/{id}/delete', 'VMController@delete');
});
