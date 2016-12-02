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

    Route::get('/{id}/start', 'VMController@start')->name("vm.start");
    Route::get('/{id}/stop', 'VMController@stop')->name("vm.stop");

    Route::get('/create', 'VMController@create')->name("vm.create");
    Route::post('/store', 'VMController@store')->name("vm.store");

    Route::get('/{id}/waiting/', 'VMController@waitingShow')->where('id', '[0-9]+');
    Route::get('/{id}/waiting/{status}', 'VMController@statusUpdate')->where('id', '[0-9]+')->name("vm_waiting.update");

    Route::get('/{id}/delete', 'VMController@delete');
});

Route::group(['prefix' => 'roles', 'middleware' => ['role:SysAdmin', 'auth']], function () {
    Route::get('/', 'RolesController@index');
    Route::post('/update/{user_id}/{role_id}', 'RolesController@update');
});
