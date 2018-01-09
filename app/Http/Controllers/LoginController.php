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
    $user = User::where('email', $request->input('email'))->first();

    //controllo se l'utente esiste
    if(!$user)
      return redirect('/login'); //e stampo un errore

    $pwd = $request->input('password');
    //hashPwd = bcrypt($pwd);

    if(!password_verify($pwd, $user->pwd_hash)){
      return redirect('/login'); //e stampo un errore
    }

    if(!$user->confirmed)
      return view('confirmEmail'); ///DA METTERE A POSTO

    $rem = $request->input('rem');

    //imposto un cookie per la sessione con al suo interno l'id_user.
    //10000 è la validità espressa in minuti
    if($rem)
      Cookie::queue('session', $user->id_user, 10000);
    else
      Cookie::queue('session', $user->id_user);

    return redirect('/');
  }


  #semplice logout che rimuove i cookie, solo come prova!!!!
  public function logout(Request $request) {
    \Cookie::queue(\Cookie::forget('session'));
    return redirect('/login');
  }
}
