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
Route::get('user/profile', 'Profile\ProfileController@show')->name('profile.show')->middleware('auth');
Route::get('user/profile/edit', 'Profile\ProfileController@edit')->name('profile.edit')->middleware('auth');
Route::post('user/profile/update', 'Profile\ProfileController@update')->name('profile.update')->middleware('auth');
Route::get('project/create', 'Project\ProjectController@create')->name('project.create')->middleware('auth');
Route::get('project', 'Project\ProjectController@index')->name('project.index')->middleware('auth');
Route::get('project/my', 'Project\ProjectController@my')->name('project.my')->middleware('auth');
Route::post('project/store', 'Project\ProjectController@store')->name('project.store')->middleware('auth');
Route::get('project/{slug}', ['as' => 'project.show', 'uses' => 'Project\ProjectController@show'])->middleware('auth');
Route::get('project/{slug}/edit', ['as' => 'project.edit', 'uses' => 'Project\ProjectController@edit'])->middleware('auth');
Route::post('project/{slug}/update', ['as' => 'project.update', 'uses' => 'Project\ProjectController@update'])->middleware('auth');
