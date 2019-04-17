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

/*
Categories
*/

Route::prefix('categories')->group(function () {

    Route::get('/create', 'CategoryController@create')->name('category.create');
    Route::post('/update/{id}', 'CategoryController@update')->name('category.update');
    Route::get('/delete/{id}', 'CategoryController@delete')->name('category.delete');
    Route::post('/store', 'CategoryController@store')->name('category.store');
//    Route::get('/index', 'CategoryController@index')->name('category.index');
    Route::get('/edit/{id}', 'CategoryController@edit')->name('category.edit');

});

/*
Periods
*/

Route::prefix('periods')->group(function () {

    Route::get('/create', 'PeriodController@create')->name('period.create');
    Route::post('/update/{id}', 'PeriodController@update')->name('period.update');
    Route::get('/delete/{id}', 'PeriodController@delete')->name('period.delete');
    Route::post('/store', 'PeriodController@store')->name('period.store');
//    Route::get('/index', 'PeriodController@index')->name('period.index');
    Route::get('/edit/{id}', 'PeriodController@edit')->name('period.edit');

});

/*
Periods & Categories
*/

Route::get('categories-periods', 'CategoriesPeriodsController@index')->name('categories_periods.index');
