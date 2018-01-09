<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


use App\User;
use Cookie;

use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{

  protected function verify_cookie(){
    if (Cookie::has('session')){
      return true;
    }
    else{
      return false;
    }
  }

  public function index() {
    if($this->verify_cookie())
      return redirect('/');
    $error = '';
    return view('/register', compact('error'));
  }

  public function store(Request $request){

    $email = $request->input('email');
    $tmp = User::where('email', '=', $email)->first();
    $error = '';
    if($tmp){
      $error = "Questa email è già presente su UniBook";
      return view('/register', compact('error'));
    }
    $user = new User;
    $user -> id_user = uniqid();
    $user -> name = request("name");
    $user -> surname = request("surname");
    $user -> birth_date = request("birth_date");
    $user -> email = request("email");
    $user->pwd_hash = password_hash($request->input('pwd_hash'), PASSWORD_DEFAULT);
    $user -> citta = request("citta");
    $user -> gender = request("gender");
    $user->confirmed = false;
    if(Input::hasFile('file')){
      $file = Input::file('file');
      $file->move('assets/images', $user->id_user . '.jpg');
      $user->pic_path = 'assets/images/' . $user->id_user . '.jpg';
    }else{
      $user->pic_path = 'assets/images/facebook1.jpg';#request("pic_path");
    }


    $user -> save();

    #sarebbe da fare la redirect con l'utente già loggato
    //Daniele: non credo sia una buona idea, dobbiamo mandare una mail e confermare l'utente
    #io farei fare l'auto login e poi una notifica standard che dice di validare account con email
      //Cookie::queue('session', $user->id_user);
      Mail::to($user)->send(new ConfirmEmail());
      return redirect('/register/confirm');

  }

  public function confirm(){
    return view('/confirm');
  }


}
