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

/*
Companies
*/

Route::prefix('companies')->group(function () {

    Route::get('/', 'CompanyController@index')->name('company.index');
    Route::get('/create', 'CompanyController@create')->name('company.create');
    Route::post('/store', 'CompanyController@store')->name('company.store');
    Route::get('/active', 'CompanyController@active')->name('company.active');

});
