<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Cookie;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;
use App\ResetPassword;

use Input;

class LoginController extends Controller{
  //Funzione semplice che verifica la presenza del cookie di login
  //Torna vero se il cookie è presente, falso se non è presente
  //bisogna ovviamente migliorarlo
  public function verify_cookie(){
    if (Cookie::has('session')){
      $id = Cookie::get('session');
      $user = User::where('id_user', '=', $id)->first();
      if(!$user)
        return false;
      else
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
    $errors = new MessageBag;
    //controllo se l'utente esiste
    if(!$user){
      #return redirect('/login'); //e stampo un errore
      $errors = new MessageBag(['password' => ['Email invalida.']]);
      return Redirect::back()->withErrors($errors)->withInput(Input::except('email'));

    }
      #return redirect('/login'); //e stampo un errore

    $pwd = $request->input('password');
    //hashPwd = bcrypt($pwd);


    if(!password_verify($pwd, $user->pwd_hash)){
      #return redirect('/login'); //e stampo un errore
      //controllo se ha richiesto il reset password
      $tmp = ResetPassword::where([['id_user', '=', $user->id_user], ['valid', '=', true]])->first();
      if(!$tmp){
        $errors = new MessageBag(['password' => ['Password invalida.']]);
        return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
      }else{
        if(password_verify($pwd, $tmp->pwd_hash))
          return redirect()->route('resetPassword', ['id_user' => $user->id_user]);
        else{
          $errors = new MessageBag(['password' => ['Password invalida.']]);
          return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
        }
      }
    }

    if(!$user->confirmed)
      return view('confirm'); ///DA METTERE A POSTO

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
