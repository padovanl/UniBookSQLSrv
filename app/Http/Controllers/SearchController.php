<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Users_make_friends;
use App\PostUser;
use App\CommentUser;
use App\CommentU;
use App\LikePost;

use Cookie;

class SearchController extends Controller{

  public function verify_cookie(){
    if (Cookie::has('session')){
      //conrollo che l'id presente nel cookie esista nel db
      return true;
    }
    else{
      return false;
    }
  }

  public function search(){

    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $userprofile = User::where('id_user', request('id'))->first();

      return view('profile', compact('logged_user', 'userprofile'));
    }
    else{
      return view('login');
    }
  }
}
?>
