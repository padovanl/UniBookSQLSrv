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
//Login and Registration Routes
Route::get('/login', 'LoginController@showLogin')->name('login.showLogin');
Route::post('/login/submit', 'LoginController@doLogin');

//Home Routes
Route::get('/', 'HomeController@landing');
Route::post('/post', 'HomeController@newPost');
