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

Route::group(['middleware' => ['auth', 'activated']], function(){

    Route::get('/', function(){
        return redirect(route('deposit-index'));
    })->name('index');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard-index');

    Route::get('logout', 'LoginController@logout')->name('logout')->withoutMiddleware('activated');

    Route::get('deposit', 'DepositController@index')->name('deposit-index');
    Route::post('deposit', 'DepositController@store')->name('deposit-store')->middleware(['user.only']);

    Route::get('withdrawal', 'WithdrawalController@index')->name('withdrawal-index');
    Route::post('withdrawal', 'WithdrawalController@store')->name('withdrawal-store')->middleware('user.only');

    Route::get('user', 'UserController@index')->name('user-index')->middleware(['admin.only']);
    Route::get('user/{id_user}', 'UserController@show')->name('user-show')->middleware(['admin.only']);
    Route::post('user/{id_user}/switch', 'UserController@switch')->name('user-switch')->middleware(['admin.only']);
    Route::get('user/{id_user}/destroy', 'UserController@destroy')->name('user-destroy')->middleware(['admin.only']);

    Route::get('loan', 'LoanController@index')->name('loan-index');
    Route::post('loan', 'LoanController@store')->name('loan-store')->middleware('user.only');
    Route::get('loan/{id_loan}', 'LoanController@show')->name('loan-show');
    Route::get('loan/{id_loan}/attachment', 'LoanController@attachment')->name('loan-attachment');
    Route::get('loan/{id_loan}/confirm', 'LoanController@confirm')->name('loan-confirm')->middleware('admin.only');
    Route::get('loan/{id_loan}/reject', 'LoanController@reject')->name('loan-reject')->middleware('admin.only');

    Route::get('profile', 'ProfileController@index')->name('profile-index')->withoutMiddleware('activated');
    Route::post('profile', 'ProfileController@update')->name('profile-update')->withoutMiddleware('activated');

});

Route::group(['middleware' => 'connected'], function(){

    Route::get('login', 'LoginController@login')->name('login');
    Route::post('login', 'LoginController@authenticate')->name('authenticate');
    Route::get('register', 'RegisterController@register')->name('register');
    Route::post('register', 'RegisterController@store')->name('register-store');
});
