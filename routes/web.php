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

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::guest()) {
        return view('auth.login');
    }

    if (Auth::check()) {
        return view('home');
    }
});

Route::get('/auth', function () {
    return view('layouts.auth');
});

Route::post('auth/getZones', 'Auth\RegisterController@getZones');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
