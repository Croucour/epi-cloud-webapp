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
    return view('welcome');
});

Auth::routes();

// only owners will have access to routes within admin/advanced
//Entrust::routeNeedsRole('/home', 'SysAdmin');

//Entrust::routeNeedsRole('home/', 'SysAdmin', Redirect::to('/homed'));

Route::get('/home', 'HomeController@index')->middleware('role:Employees');
