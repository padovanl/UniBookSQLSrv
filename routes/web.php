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
Route::resource('/comment', 'CommentController');
Route::resource('/register', 'RegisterController');
Route::get('/logout', 'LoginController@logout');

//Ricerca
Route::get('/search/{search_term}', 'SearchController@search');

//Profiles
Route::get('/profile/user/{id}', 'ProfileController@show');

//Admin Routes
Route::get('/admin', 'AdminController@dashboard');
Route::get('/admin/dashboard', 'AdminController@dashboard');
//admin ajax request
Route::post('/admin/dashboard/getPostDetails', 'AdminController@getPostDetails');
Route::post('/admin/dashboard/ignoreReportPost', 'AdminController@ignoreReportPost');
Route::post('/admin/dashboard/deletePost', 'AdminController@deletePost');
Route::post('/admin/dashboard/getCommentDetails', 'AdminController@getCommentDetails');
Route::post('/admin/report/post', 'AdminController@listReportPost');
Route::post('/admin/report/comment', 'AdminController@listReportComment');
Route::post('/admin/dashboard/ignoreReportComment', 'AdminController@ignoreReportComment');
Route::post('/admin/dashboard/deleteComment', 'AdminController@deleteComment');
Route::post('/admin/dashboard/user', 'AdminController@listUser');


//prova ajax
Route::get('/test', 'AdminController@testfunction');
Route::post('/test', 'AdminController@testfunction');
//Authentication
#Route::post('register', 'authController@register');
Route::post('login',    'authController@login');
Route::group(['middleware' => 'jwt-auth'], function () {
  Route::post('get_user_details', 'authController@get_user_details');
});

// Route::post('/login',           'loginController@login');
Route::get('/page/{view}', 		 	 'pageController@page');
#Route::get('/registrazione', 		 'utentiController@registrazione');

Route::group(['middleware' => 'jwt-auth'], function () {

  Route::get('/modifica', 			   'utentiController@modifica');
  Route::get('/cancella_utente',   'utentiController@cancella_utente');
});
