<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


use App\User;
use Cookie;



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
    $user -> pwd_hash = bcrypt("pwd_hash");
    $user -> citta = request("citta");
    $user -> gender = request("gender");
    //$user -> pic_path = 'assets/images/facebook1.jpg';#request("pic_path");
    if(Input::hasFile('file')){
      $file = Input::file('file');
      $file->move('assets/images', $user->id_user . '.jpg');
      $user->pic_path = 'assets/images/' . $user->id_user . '.jpg';
    }else{
      $user->pic_path = 'assets/images/facebook1.jpg';#request("pic_path");
    }

    $user->confirmed = false;
    $user -> save();

    #sarebbe da fare la redirect con l'utente già loggato
    //Daniele: non credo sia una buona idea, dobbiamo mandare una mail e confermare l'utente
    #io farei fare l'auto login e poi una notifica standard che dice di validare account con email
    if ($user = User::where('email', request('email'))->first()){
      Cookie::queue('session', $user->id_user, 10000);
      return redirect('/');
    }
    else{
      return redirect('/login');
    }
  }

}
