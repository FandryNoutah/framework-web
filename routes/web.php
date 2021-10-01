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

Route::get('/', 'IndexController@index')->name('index')->middleware('auth');

Route::get('login', 'LoginController@login')->name('login');
Route::post('login', 'LoginController@authenticate')->name('authenticate');
Route::get('register', 'RegisterController@register')->name('register');
Route::post('register', 'RegisterController@store')->name('register-store');

