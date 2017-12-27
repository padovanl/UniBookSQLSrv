<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Cookie;


class LoginController extends Controller{
  //Funzione semplice che verifica la presenza del cookie di login
  //Torna vero se il cookie è presente, falso se non è presente
  //bisogna ovviamente migliorarlo
  public function verify_cookie(){
    if (Cookie::has('session')){
      return true;
    }
    else{
      return false;
    }
  }

  public function showLogin(){
    // show the Login
    if ($this->verify_cookie()){
        return redirect('/');
    }
    else{
      return view('/login');
    }
  }

  public function doLogin(Request $request){
    //controlli sui campi username e Password
    $user = User::where('email', request('email'))->first();

    //tutti i controlli del caso su password_hash e così via...
    //imposto un cookie per la sessione con al suo interno l'id_user.
    //10000 è la validità espressa in minuti
    Cookie::queue('session', $user->id_user, 10000);
    return redirect('/');
  }

  #semplice logout che rimuove i cookie, solo come prova!!!!
  public function logout(Request $request) {
    \Cookie::queue(\Cookie::forget('session'));
    return redirect('/login');
  }
}
