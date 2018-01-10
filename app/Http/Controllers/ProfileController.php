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

class ProfileController extends Controller{

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

  public function show(){

    if($this->verify_cookie()){

      $controller = $this;
      $list_comments = array();
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $userprofile = User::where('id_user', request('id'))->first();
      $posts = Post::where('id_author' , $userprofile['id_user'])->get();
      foreach($posts as $post){
        array_push($list_comments, CommentU::where('id_post', $post['id_post'])->get());
      }
      return view('profile', compact('logged_user', 'list_comments', 'userprofile', 'posts','controller'));
    }
    else{
      return view('login');
    }
  }

  public function ShowUser($id){
    if(is_numeric($id)){
      $user = Page::where('id_page', $id)->first();
    }
    else{
      $user = User::where('id_user', $id)->first();
    }
    return $user;
  }

  public function PrintName($id){
    if(is_numeric($id)){
      $user = Page::where('id_page', $id)->first();
      return ($user['nome']);
    }
    else{
      $user = User::where('id_user', $id)->first();
      return ($user['name'] . ' ' . $user['surname']);
    }

  }
}
?>
