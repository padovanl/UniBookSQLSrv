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
Route::get('/register/confirm', 'RegisterController@confirm');
Route::get('/register/confirmEmail/{id_user}', 'RegisterController@confirmEmail')->name('activeAccount');
Route::resource('/register', 'RegisterController');


//Home Routes
Route::get('/', 'HomeController@landing');
Route::resource('/comment', 'CommentController');

Route::get('/logout', 'LoginController@logout');
Route::get('/home/loadmore', 'HomeController@loadMore');

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
Route::post('/admin/dashboard/getUserDetails', 'AdminController@getUserDetails');
Route::post('/admin/dashboard/promuoviUser', 'AdminController@promuoviUser');
Route::post('/admin/dashboard/retrocediUser', 'AdminController@retrocediUser');
Route::post('/admin/dashboard/bloccaUser', 'AdminController@bloccaUser');
Route::post('/admin/dashboard/sbloccaUser', 'AdminController@sbloccaUser');
Route::post('/admin/dashboard/sendMessageUser', 'AdminController@sendMessageUser');

//Messaggi
Route::get('/message', 'MessageController@index');
Route::post('/message/changeChat', 'MessageController@changeChat');
Route::post('/message/newMessage', 'MessageController@newMessage');


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
