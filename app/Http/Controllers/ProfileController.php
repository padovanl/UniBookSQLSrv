<?php

namespace App\Http\Controllers;

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



  //Impostazioni account
  public function settings(){
    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      return view('settings', compact('logged_user'));
    }else{
      return view('login');
    }
  }

  //loading dei post
  public function loadMore(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();

    //Caricamento dei post degli amici e delle pagine
    $posts = array();
    $list_comments = array();
    $likes = array();

    //inserisco anche i miei posts
    array_push($posts, Post::where('id_author', $logged_user['id_user'])->orderBy('created_at', 'asc')->get());
    array_push($list_comments, CommentU::where('id_author', $logged_user['id_user'])->orderBy('created_at', 'asc')->get());

    $posts = array_flatten($posts);
    $list_comments = array_flatten($list_comments);

    //ordino per data
    usort($posts, array($this, 'cmp'));
    usort($list_comments, array($this, 'cmp'));

    $toreturn = array();

    foreach($posts as $post){
      $tmp_comm = array();
      foreach($list_comments as $comment){
        if($comment['id_post'] === $post['id_post']){
          if(!is_numeric($comment['id_author'])){
            //TODO:manca is_friend
            array_push($tmp_comm, new CommentViewModel($comment['id_comment'], User::where('id_user', $comment['id_author'])->first()->name,
                                                      User::where('id_user', $comment['id_author'])->first()->surname,
                                                      User::where('id_user', $comment['id_author'])->first()->pic_path,
                                                      $comment['content'], $comment['created_at'], $comment['updated_at'],
                                                      $comment['id_post'], '0',
                                                      LikeComment::where('id_comment', $comment['id_comment'])->where('like', 1)->get()->count(),
                                                      LikeComment::where('id_comment', $comment['id_comment'])->where('like', 0)->get()->count(),
                                                      LikeComment::where('id_user', $logged_user['id_user'])->where('id_comment', $comment['id_comment'])->first()['like'],
                                                      $comment['id_author'], User::where('id_user', $comment['id_author'])->first()['ban']));
          }
          else{
            array_push($tmp_comm, new CommentViewModel($comment['id_comment'], Page::where('id_page', $comment['id_author'])->first()->nome,
                                                      '',
                                                      Page::where('id_page', $comment['id_author'])->first()->pic_path,
                                                      $comment['content'], $comment['created_at'], $comment['updated_at'],
                                                      $comment['id_post'], '0',
                                                      LikeComment::where('id_comment', $comment['id_comment'])->where('like', 1)->get()->count(),
                                                      LikeComment::where('id_comment', $comment['id_comment'])->where('like', 0)->get()->count(),
                                                      null, //bisogna capire se la pagina può mettere like
                                                      $comment['id_author'], User::where('id_user', $comment['id_author'])->first()['ban']));
          }

        }
      }
      if(!is_numeric($post['id_author'])){
        array_push($toreturn, new PostViewModel($post['id_post'], User::where('id_user', $post['id_author'])->first()->name,
                                      User::where('id_user', $post['id_author'])->first()->surname,
                                      User::where('id_user', $post['id_author'])->first()->pic_path,
                                      $post['content'], $post['created_at'], $post['updated_at'],
                                      $post['is_fixed'], $post['id_author'], $tmp_comm,
                                      LikePost::where('id_post', $post['id_post'])->where('like', 1)->get()->count(),
                                      LikePost::where('id_post', $post['id_post'])->where('like', 0)->get()->count(),
                                      LikePost::where('id_user', $logged_user['id_user'])->where('id_post', $post['id_post'])->first()['like'],
                                      User::where('id_user', $post['id_author'])->first()['ban']));
      }
      else{
        array_push($toreturn, new PostViewModel($post['id_post'], Page::where('id_page', $post['id_author'])->first()->nome,
                                      '',
                                      Page::where('id_page', $post['id_author'])->first()->pic_path,
                                      $post['content'], $post['created_at'], $post['updated_at'],
                                      $post['is_fixed'], $post['id_author'], $tmp_comm,
                                      LikePost::where('id_post', $post['id_post'])->where('like', 1)->get()->count(),
                                      LikePost::where('id_post', $post['id_post'])->where('like', 0)->get()->count(),
                                      LikePost::where('id_user', $logged_user['id_user'])->where('id_post', $post['id_post'])->first()['like'],
                                      User::where('id_user', $post['id_author'])->first()['ban']));
      }
    }
    if($request->input('post_id') == '-1'){
      $asd = array_slice($toreturn, 0, 5);
    }
    else{
      for($i = 0; $i < count($toreturn); $i++){
        if($toreturn[$i]->id_post == $request->input('post_id')){
            $asd = array_slice($toreturn, $i + 1, $i + 3);
            return(json_encode($asd));
        }
      }
    }
    return(json_encode($asd));

  }

  function cmp($a, $b) {
      if ($a['created_at'] == $b['created_at']) return 0;
      return (strtotime($a['created_at']) < strtotime($b['created_at'])) ? 1 : -1;
  }
}
?>
