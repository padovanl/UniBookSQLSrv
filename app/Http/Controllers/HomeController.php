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

class HomeController extends Controller{

  public function verify_cookie(){
    if (Cookie::has('session')){
      //conrollo che l'id presente nel cookie esista nel db
      return true;
    }
    else{
      return false;
    }
  }

  //funzione richiamata quando viene richiesta la root del nostro sito
  public function landing()
  {
    if($this->verify_cookie()){

      //login
      $id = Cookie::get('session');
      $user = User::where('id_user', $id)->first();

      $friends = $user::friends($id);     //Torna un array con gli amici
      $requests = $user::pendingfriends($id);   //Torna un array con le richieste

      //Caricamento dei post degli amici e delle pagine
      $posts = array();
      $list_comments = array();
      $likes = array();

      //per ogni elemento di friends devo andare nella tabella post_users e tirare fuori tutti gli id dei post di ogni mio amico
      foreach ($friends as $friend){
        $id_posts = PostUser::where('id_user', $friend['id_user'])->get();
        foreach ($id_posts as $post){
          //post
          array_push($posts, Post::where('id_post', $post['id_post'])->orderBy('created_at','asc')->get());
          //commenti
          array_push($list_comments, CommentU::where('id_post', $post['id_post'])->orderBy('updated_at', 'asc')->get());
          //likes
          array_push($likes, LikePost::where('id_post', $post['id_post'])->get());
        }
      }


      //TODO: caricamento post pagine

      //gli passo il controller stesso così posso richiamare le funzioni direttamente dalle views
      $controller = $this;
      return view('home', compact('user', 'posts', 'list_comments','controller','friends'));

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
    //che bello ajax qui....
    return redirect('/');

  }

  //prendendo in ingresso un id, restituisce l'utente relativo
  //es. da un post id_author--->id_user
  public function ShowUser($param){
    $user = User::where('id_user', $param)->first();
    #$nome = $user->name;
    return $user;

  }

}
