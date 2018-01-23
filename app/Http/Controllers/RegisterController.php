<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use \Datetime;

use App\User;
use App\ResetPassword;
use App\Message;

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
      $error = "Indirizzo e-mail: ".$email.", già in uso.";
      return view('/register', compact('error'));
    }
    $user = new User;
    $user -> id_user = uniqid();
    $user -> name = request("name");
    $user -> surname = request("surname");
    $user -> birth_date = request("birth_date");
    if($user->birth_date > date("Y-m-d")){
      $error = "Sei nato nel futuro?";
      return view('/register', compact('error'));
    }
    $user -> email = request("email");
    $pwd = $request->input('pwd_hash');
    $rePwd = $request->input('re_pwd_hash');
    if($rePwd != $pwd){
      $error = "Le password non coincidono";
      return view('/register', compact('error'));
    }
    $user->pwd_hash = password_hash($request->input('pwd_hash'), PASSWORD_DEFAULT);
    $user -> citta = request("citta");
    $user -> gender = request("gender");
    $user->confirmed = false;
    $user->profiloPubblico = true;
    if(Input::hasFile('file')){
      $file = Input::file('file');
      $ext = pathinfo($file, PATHINFO_EXTENSION);
      $file->move('assets/images', $user->id_user . $ext);
      $user->pic_path = '/assets/images/' . $user->id_user . $ext;
    }else{
      $user->pic_path = '/assets/images/facebook1.jpg';
    }

    $user -> save();

    $path = route('activeAccount', ['id_user' => $user->id_user]);
    Mail::to($user)->send(new ConfirmEmail($path));

    //invio messaggio di benvenuto
    date_default_timezone_set('Europe/Rome');
    $welcomeMess = new Message();
    $welcomeMess->letto = false;
    $welcomeMess->content = 'Benvenuto su UniBook! Sono uno degli amministratori del sito, se hai bisogno di aiuto non esitare a contattarmi in futuro. Buon divertimento su UniBook!';
    $admins = User::where('admin', '=', true)->inRandomOrder()->get();
    $welcomeMess->sender = $admins[0]->id_user;
    $welcomeMess->receiver = $user->id_user;
    $welcomeMess->save();

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
      if(!$tmp || ($tmp->expire_at < date("Y-m-d H:i:s")) || !$tmp->valid){
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
