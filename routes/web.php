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

/*
Users
*/

Route::prefix('users')->group(function () {

    Route::get('/', 'UserController@index')->name('users.index');
    Route::get('/create', 'UserController@create')->name('users.create');
    Route::post('/store', 'UserController@store')->name('users.store');
    Route::get('/edit/{id}', 'UserController@edit')->name('users.edit');
    Route::post('/update/{id}', 'UserController@update')->name('users.update');
    Route::get('/delete/{id}', 'UserController@delete')->name('users.delete');

});

/*
Budgets
*/

Route::prefix('budgets')->group(function () {

    Route::get('/', 'BudgetController@index')->name('budgets.index');
    Route::get('/create', 'BudgetController@create')->name('budgets.create');
    Route::post('/store', 'BudgetController@store')->name('budgets.store');
    Route::get('/edit/{id}', 'BudgetController@edit')->name('budgets.edit');
    Route::post('/update/{id}', 'BudgetController@update')->name('budgets.update');
    Route::get('/delete/{id}', 'BudgetController@delete')->name('budgets.delete');

});

/*
Expenses
*/

Route::prefix('expenses')->group(function () {

    Route::get('/', 'ExpenseController@index')->name('expenses.index');
    Route::get('/create', 'ExpenseController@create')->name('expenses.create');
    Route::post('/store', 'ExpenseController@store')->name('expenses.store');
    Route::get('/edit/{id}', 'ExpenseController@edit')->name('expenses.edit');
    Route::post('/update/{id}', 'ExpenseController@update')->name('expenses.update');
    Route::get('/show/{id}', 'ExpenseController@show')->name('expenses.show');
    Route::get('/delete/{id}', 'ExpenseController@delete')->name('expenses.delete');
    Route::post('/updateStatus', 'ExpenseController@updateStatus')->name('expenses.updateStatus');
    Route::post('/editStatus', 'ExpenseController@editStatus')->name('expenses.editStatus');
    Route::post('/search', 'ExpenseController@search')->name('expenses.search');

});
