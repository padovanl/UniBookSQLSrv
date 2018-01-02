
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

//Authentication
Route::post('register', 'authController@register');
Route::post('login',    'authController@login');
Route::group(['middleware' => 'jwt-auth'], function () {
  Route::post('get_user_details', 'authController@get_user_details');
});

// Route::post('/login',           'loginController@login');
Route::get('/page/{view}', 		 	 'pageController@page');
Route::get('/registrazione', 		 'utentiController@registrazione');

Route::group(['middleware' => 'jwt-auth'], function () {

  Route::get('/modifica', 			   'utentiController@modifica');
  Route::get('/cancella_utente',   'utentiController@cancella_utente');
});
