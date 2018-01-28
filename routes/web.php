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
Route::get('/register/forgotPassword', 'RegisterController@forgotPassword')->name('forgotPassword');
Route::post('/register/sendEmailForgotPassword', 'RegisterController@sendEmailForgotPassword');
Route::get('/register/resetPassword/{id_user}', 'RegisterController@resetPassword')->name('resetPassword');
Route::post('/register/resetPassword/{id_user}', 'RegisterController@resetPasswordPost');
Route::resource('/register', 'RegisterController');

//General App Routes: messaggi, notifiche, richieste di amicizia
Route::post('/getnotifications', 'GeneralAppController@getNotifications');
Route::post('/getcountNewMessage', 'GeneralAppController@countNewMessage');
Route::post('/getcountNewRequest', 'GeneralAppController@getFriendRequest');

//Home e Profile Routes
Route::get('/', 'HomeController@landing');
Route::post('/home/post', 'HomeController@newPost');
Route::post('/home/comment', 'HomeController@newComment');
Route::post('/home/reaction', 'HomeController@reaction');
Route::get('/logout', 'LoginController@logout');
Route::get('/home/loadmore', 'HomeController@loadMore');

//Ricerca
Route::get('/search', 'SearchController@search');
Route::get('/searchPages', 'SearchController@searchPage');
Route::get('/searchUsers', 'SearchController@searchUsers');


//Profiles
Route::get('/profile/user/{id}', 'ProfileController@ShowUser');
Route::get('/profile/user/{id}/settings', 'ProfileController@Settings');
Route::get('/profile/user/{id}/loadmore', 'HomeController@loadMore');
Route::post('/admin/dashboard/sendMessageUser', 'AdminController@sendMessageUser');
Route::post('/friend/AddFriend', 'FriendshipController@AddFriend');
Route::post('/privacy','ProfileController@Privacy');
Route::post('/formDetails','ProfileController@formDetails');
Route::post('/formImage','ProfileController@formImage');


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
Route::post('/admin/dashboard/page', 'AdminController@listPage');
Route::post('/admin/dashboard/getPageDetails', 'AdminController@getPageDetails');
Route::post('/admin/dashboard/bloccaPage', 'AdminController@bloccaPage');
Route::post('/admin/dashboard/sbloccaPage', 'AdminController@sbloccaPage');

//Messaggi
Route::get('/message', 'MessageController@index');
Route::post('/message/changeChat', 'MessageController@changeChat');
Route::post('/message/newMessage', 'MessageController@newMessage');

//segnalazioni
Route::post('/home/reportPost', 'HomeController@reportPost');
Route::post('/home/reportComment', 'HomeController@reportComment');

//notifiche
Route::get('/notification', 'NotificationController@index');
Route::post('/notification/read', 'NotificationController@read');

//dettagli post (da finire)
Route::get('/post/details/{id}', 'PostController@details');

//amicizie
Route::get('/friend/request', 'FriendshipController@index');
Route::post('/friend/accept', 'FriendshipController@acceptFriend');
Route::post('/friend/decline', 'FriendshipController@declineFriend');
//ancora da implementare
//Route::post('/friend/sendRequest', 'FriendshipController@sendRequest');
Route::post('/friend/remove', 'FriendshipController@removeFriend');

//pagine
Route::get('/page/mypage', 'PageController@index');
Route::post('/page/create', 'PageController@create')->name('createPage');
Route::post('/page/invite', 'PageController@inviteFriends');
Route::post('/page/changeImage', 'PageController@changeImage')->name('changeImage');
Route::get('/page/loadmore', 'PageController@loadmore');
Route::post('/page/newpost', 'PageController@newPost');

Route::get('/profile/page/{id}', 'ProfileController@ShowPage');
Route::post('/profile/page/comment', 'ProfileController@newCommentPage');
Route::post('/profile/page/stopFollow', 'ProfileController@stopFollow');
Route::post('/profile/page/follow', 'ProfileController@follow');

Route::get('/team', function(){ return view('team');});

//se viene richiesta una route che non esiste, torna alla home
Route::any('{query}',
    function() { return redirect('/'); })
    ->where('query', '.*');
