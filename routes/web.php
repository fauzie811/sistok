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

use Illuminate\Support\Facades\Route;

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::get('profile', 'MeController@showProfile')->name('profile');
Route::post('profile', 'MeController@saveProfile');
Route::get('profile/change-password', 'MeController@showPasswordForm')->name('profile.change-password');
Route::post('profile/change-password', 'MeController@savePassword');

Route::get('products/ajax', 'ProductController@ajax')->name('products.ajax');
Route::resource('products', 'ProductController');
Route::resource('transactions', 'TransactionController');
Route::resource('expenses', 'ExpenseController');
Route::get('reports', 'ReportController@index')->name('reports');