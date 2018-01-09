<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Page;
use App\Post;
use App\Users_make_friends;
use App\Users_follow_pages;
use App\PostUser;
use App\PostPage;
use App\CommentUser;
use App\CommentU;
use App\CommentP;
use App\LikePost;
use App\LikeComments;
use App\PostViewModel;
use App\CommentViewModel;
use App\LikeComment;

use Illuminate\Support\Facades\DB;

use Cookie;

class HomeController extends Controller{

  function array_flatten($array) {
    $return = array();
    foreach ($array as $key => $value) {
        if (is_array($value)){
            $return = array_merge($return, array_flatten($value));
        } else {
            $return[$key] = $value;
        }
    }

    return $return;
}

  function cmp($a, $b) {
      if ($a['created_at'] == $b['created_at']) return 0;
      return (strtotime($a['created_at']) < strtotime($b['created_at'])) ? 1 : -1;
  }

  public function verify_cookie(){
    if (Cookie::has('session')){
      //conrollo che l'id presente nel cookie esista nel db
      return true;
    }
    else{
      return false;
    }
  }

  //loading dei post
  public function loadMore(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    $friends = $logged_user::friends($logged_user['id_user']);     //Torna un array con gli amici
    $followed_pages_id = Users_follow_pages::where('id_user', $logged_user['id_user'])->get();

    //Caricamento dei post degli amici e delle pagine
    $posts = array();
    $list_comments = array();
    $likes = array();

    //inserisco anche i miei posts
    array_push($posts, Post::where('id_author', $logged_user['id_user'])->orderBy('created_at', 'asc')->get());


    //per ogni elemento di friends devo andare nella tabella post_users e tirare fuori tutti gli id dei post di ogni mio amico
    foreach ($friends as $friend){
      $id_posts = PostUser::where('id_user', $friend['id_user'])->get();
      foreach ($id_posts as $post){
        //post
        array_push($posts, Post::where('id_post', $post['id_post'])->orderBy('created_at','asc')->get());
        //commenti
        array_push($list_comments, CommentU::where('id_post', $post['id_post'])->orderBy('updated_at', 'asc')->get());
      }
    }


    foreach ($followed_pages_id as $id_page){
      $id_page_post = PostPage::where('id_page', $id_page['id_page'])->get();
      foreach ($id_page_post as $post_page){
        array_push($posts, Post::where('id_post', $post_page['id_post'])->get());
      }
    }

    $posts = array_flatten($posts);
    $list_comments = array_flatten($list_comments);

    foreach($posts as $post){
      array_push($likes, LikePost::where('id_post', $post['id_post'])->get());
    }
    $likes = array_flatten($likes);

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
                                                      LikeComment::where('id_user', $comment['id_author'])->where('id_comment', $comment['id_comment'])->get(),
                                                      $comment['id_author']));
          }
          else{
            array_push($tmp_comm, new CommentViewModel($comment['id_comment'], Page::where('id_page', $comment['id_author'])->first()->nome,
                                                      '',
                                                      Page::where('id_page', $comment['id_author'])->first()->pic_path,
                                                      $comment['content'], $comment['created_at'], $comment['updated_at'],
                                                      $comment['id_post'], '0',
                                                      LikeComment::where('id_comment', $comment['id_comment'])->where('like', 1)->get()->count(),
                                                      LikeComment::where('id_comment', $comment['id_comment'])->where('like', 0)->get()->count(),
                                                      LikeComment::where('id_user', $comment['id_author'])->where('id_comment', $comment['id_comment'])->get(),
                                                      $comment['id_author']));
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
                                      LikePost::where('id_user', $post['id_author'])->where('id_post', $post['id_post'])->get()));
      }
      else{
        array_push($toreturn, new PostViewModel($post['id_post'], Page::where('id_page', $post['id_author'])->first()->nome,
                                      '',
                                      Page::where('id_page', $post['id_author'])->first()->pic_path,
                                      $post['content'], $post['created_at'], $post['updated_at'],
                                      $post['is_fixed'], $post['id_author'], $tmp_comm,
                                      LikePost::where('id_post', $post['id_post'])->where('like', 1)->get()->count(),
                                      LikePost::where('id_post', $post['id_post'])->where('like', 0)->get()->count(),
                                      LikePost::where('id_user', $post['id_author'])->where('id_post', $post['id_post'])->get()));
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


  //funzione richiamata quando viene richiesta la root del nostro sito
  public function landing()
  {
    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      return view('home', compact('logged_user'));
    }
    else{
      return redirect('/login');
    }
  }



  public function newPost(Request $request){
    //verifica dei campi
    $id_user = Cookie::get('session');
    $post = new Post;
    $post->id_author = $id_user;
    $post->created_at = now();
    $post->updated_at = now();
    $post->content = request('content');
    $post->fixed = 0;     //ovviamente da verificare
    $post->save();

    $post_tmp = Post::where('id_author', $id_user)->where('content', request('content'))->first();

    DB::table('posts_user')->insert(['id_user' => $id_user, 'id_post' => $post_tmp['id_post']]);

    //che bello ajax qui....
    return redirect('/');
  }

  //prendendo in ingresso un id, restituisce l'utente relativo
  //es. da un post id_author--->id_user
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
