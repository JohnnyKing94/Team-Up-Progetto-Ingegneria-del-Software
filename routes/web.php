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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('user/profile', 'Profile\ProfileController@show')->name('profile.show');
Route::get('user/profile/edit', 'Profile\ProfileController@edit')->name('profile.edit');
Route::post('user/profile/update', 'Profile\ProfileController@update')->name('profile.update');
