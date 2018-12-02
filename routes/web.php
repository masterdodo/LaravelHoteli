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

Route::get('/hotels', 'HotelsController@index')->name('hotels');

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('hotels', 'HotelsController');

Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('redirect');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback')->name('callback');

Route::get('users/{user}',  ['as' => 'users.edit', 'uses' => 'UserController@edit']);
Route::patch('users/{user}/update',  ['as' => 'users.update', 'uses' => 'UserController@update']);

Route::get('/hotels',['uses' => 'HotelsController@search','as' => 'search']);