<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Page;
use App\Users_make_friends;
use App\PostUser;
use App\CommentUser;
use App\CommentU;
use App\CommentViewModel;
use App\LikeComment;
use App\LikePost;
use App\PostViewModel;
use App\Users_follow_pages;

use Illuminate\Support\Facades\DB;
use Cookie;

class ProfileController extends Controller{

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

  public function ShowUser($id){
    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $controller = $this;
      $user = User::where('id_user', $id)->first();
      $friends_array = User::friends($user["id_user"]);
      if($user->id_user != $logged_user->id_user && $user->profiloPubblico == 0){
        $user->gender = null;
        $user->citta = null;
        $user->ban = null;
        $user->email = null;
        $user->birth_date = null;
        $user->admin = null;
        $user->pwd_hash = null;
        return view('profile', compact('logged_user', 'controller', 'user'));
      }
      else{
        return view('profile', compact('logged_user', 'controller', 'user','friends_array'));
      }
    }
    else{
      return view('login');
    }
  }

  //profilo pagina
  public function ShowPage($id){
    if(!$this->verify_cookie())
      return view('/');
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    $page = Page::where('id_page', '=', $id)->first();
    $alreadyFollow = Users_follow_pages::where([['id_user', '=', $logged_user->id_user], ['id_page', '=', $page->id_page]])->first();
    if($alreadyFollow)
      $alreadyFollow = true;
    else
      $alreadyFollow = false;
    $tot_followers = Users_follow_pages::where('id_page', '=', $page->id_page)->count();
    return view('profilePage', compact('logged_user', 'id', 'page', 'alreadyFollow', 'tot_followers'));

  }

  public function follow(Request $request){
    $id_page = $request->input('id_page');
    $id_user = $request->input('id_user');

    $newRecord = new Users_follow_pages();
    $newRecord->id_user = $id_user;
    $newRecord->id_page = $id_page;
    $newRecord->save();
    $tot_followers = Users_follow_pages::where('id_page', '=', $id_page)->count();
    return response()->json(['message' => 'Operazione completata!', 'tot_followers' => $tot_followers]);
  }

  public function stopFollow(Request $request){
    $id_page = $request->input('id_page');
    $id_user = $request->input('id_user');
    Users_follow_pages::where([['id_user', '=', $id_user], ['id_page', '=', $id_page]])->delete();
    $tot_followers = Users_follow_pages::where('id_page', '=', $id_page)->count();
    return response()->json(['message' => 'Operazione completata!', 'tot_followers' => $tot_followers]);
  }
  //Impostazioni account
  public function settings($id){
    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $controller = $this;
      if($logged_user->id_user == $id){//se sono sul mio profilo accedo alle impostazioni
        return view('settings', compact('logged_user', 'controller'));
      }
      else{//se non sono sul mio profilo non accedo alle impostazioni
        return back();
      }
    }
    else{
      return view('login');
    }
  }
  //cambio di privacy della pagina utente
  public function Privacy(Request $request){
    $data = request("privacy");
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    DB::table('users')->where('id_user','=',$logged_user->id_user)->update(['profiloPubblico' => $data]);
    return response()->json(['message' => 'Done']);
  }
  //cambio dati utente
  public function formDetails(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    $name = request("name");
    $surname = request("surname");
    $citta = request("citta");

    DB::table('users')->where('id_user','=',$logged_user->id_user)->update(['name' => $name,'surname' => $surname,'citta' => $citta]);

    return response()->json(['message' => 'Done']);

    }

  public function formImage(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    if(Input::hasFile('file')){
      $file = Input::file('file');
      $file->move('assets/images', $logged_user->id_user . '.jpg');
      $picture = '/assets/images/' . $logged_user->id_user . '.jpg';
      DB::table('users')->where('id_user','=',$logged_user->id_user)->update(['pic_path' => $picture]);
      return response()->json(['message' => 'Done']);
      }
    else{return response()->json(['message' => 'Wrong']);}
      }
}
?>
