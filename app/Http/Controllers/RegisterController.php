<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use \Datetime;

use App\User;
use App\ResetPassword;

use Cookie;

use App\Mail\ConfirmEmail;
use App\Mail\ForgotPasswordEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Redirect;


class RegisterController extends Controller
{

  protected function verify_cookie(){
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
    $path = route('activeAccount', ['id_user' => $user->id_user]);
      Mail::to($user)->send(new ConfirmEmail($path));
      return redirect('/register/confirm');

  }

  public function confirm(){
    return view('/confirm');
  }

  public function confirmEmail($id_user){
    $user = User::where('id_user', '=', $id_user)->first();
    if(!$user)
      return redirect('/');


    Cookie::queue('session', $user->id_user);
    User::where('id_user', '=', $id_user)->update([ 'confirmed' => true]);

    return redirect('/');
  }


  public function forgotPassword(){
    return view('/forgotPassword');
  }


  public function sendEmailForgotPassword(Request $request){
    $email = $request->input('email');
    $user = User::where('email', '=', $email)->first();
    if($user){
      $tmp = ResetPassword::where('id_user', '=', $user->id_user)->first();
      if(!$tmp || ($tmp->expire_at < date("Y-m-d H:i:s") && !$tmp->valid)){
        $newPassword = $this->generateRandomPassword();
        $resetPassword = new ResetPassword();
        $resetPassword->id_user = $user->id_user;
        $resetPassword->pwd_hash = password_hash($newPassword, PASSWORD_DEFAULT);


        $datetime = new DateTime(date("Y-m-d H:i:s"));
        $datetime->modify('+1 day');
        $date = $datetime->format('Y-m-d H:i:s');

        $resetPassword->expire_at = $date;
        $resetPassword->save();
        Mail::to($user)->send(new ForgotPasswordEmail($newPassword));        
      }

    }
    return response()->json(['message' => 'Operazione completata!']);

  }

  protected function generateRandomPassword(){
    $newPassword = '';
    $passwordLength = 9;
    for ($i=0; $i < $passwordLength; $i++) { 
      $scelta = rand(0, 1);
      if($scelta == 0){ //numero
        $numero = chr(rand(48, 57));
        $newPassword = $newPassword . $numero;
      }else{ //lettera
        $minOrMaiusc = rand(0, 1);
        if($minOrMaiusc == 0){ //maiuscola
          $lettera = chr(rand(65, 90));
          $newPassword = $newPassword . $lettera;
        }else{ //minuscola
          $lettera = chr(rand(97, 122));
          $newPassword = $newPassword . $lettera;
        }
      }
    }
    return $newPassword;
  }

  public function resetPassword($id_user){
    return view('resetPasswordView')->with('id_user', $id_user);
  }

  public function resetPasswordPost(Request $request){
    $newPassword = $request->input('newPwd');
    $rePassword = $request->input('reNewPwd');
    $id_user = $request->input('idUser');
    if($newPassword != $rePassword){
      $errors = new MessageBag(['reNewPwd' => ['Le due password non coincidono.']]);
      return Redirect::back()->withErrors($errors)->withInput(Input::except('reNewPwd'));
    }else{
      $user = User::where('id_user', '=', $id_user)->first();
      if(!$user)
        return redirect('/');
      $pwd_hash = password_hash($newPassword, PASSWORD_DEFAULT);
      User::where('id_user', '=', $id_user)->update(['pwd_hash' => $pwd_hash]);
      ResetPassword::where('id_user', '=', $id_user)->update(['valid' => false]);
      Cookie::queue('session', $id_user);
      return redirect('/');
    }
  }


}
