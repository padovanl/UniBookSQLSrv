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
    $user = User::where('email', $request->input('email'))->first();
    $errors = new MessageBag;
    //controllo se l'utente esiste
    if(!$user){
      $errors = new MessageBag(['password' => ['Email invalida.']]);
      return Redirect::back()->withErrors($errors)->withInput(Input::except('email'));
    }
    $pwd = $request->input('password');
    if(!password_verify($pwd, $user->pwd_hash)){
      //controllo se ha richiesto il reset password
      $list = ResetPassword::where([['id_user', '=', $user->id_user], ['valid', '=', true]])->get();
      $pwdOk = false;
      for($x = 0; $x < count($list) && !$pwdOk; $x++) {
        $tmp = $list[$x];
        if(password_verify($pwd, $tmp->pwd_hash) && ($tmp->expire_at > date("Y-m-d H:i:s")))
          $pwdOk = true;
      }
      if($pwdOk)
        return redirect()->route('resetPassword', ['id_user' => $user->id_user]);
      else{
        $errors = new MessageBag(['password' => ['Password invalida.']]);
        return Redirect::back()->withErrors($errors)->withInput(Input::except('password'));
      }
    }
    if(!$user->confirmed)
      return view('confirm');
    $rem = $request->input('rem');
    //imposto un cookie per la sessione con al suo interno l'id_user.
    //10000 è la validità espressa in minuti
    if($rem)
      Cookie::queue('session', $user->id_user, 10000);
    else
      Cookie::queue('session', $user->id_user);

    return redirect('/');
  }

  public function logout(Request $request) {
    \Cookie::queue(\Cookie::forget('session'));
    return redirect('/login');
  }
}
