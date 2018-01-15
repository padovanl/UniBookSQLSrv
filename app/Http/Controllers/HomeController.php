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
use App\PostViewModel;
use App\CommentViewModel;
use App\LikeComment;
use App\LikePost;
use App\Notification;
use App\ReportPost;
use App\ReportComment;

use Illuminate\Support\Facades\DB;

use Cookie;

class HomeController extends Controller{

  //torna un array monodimensionale da una collezione di array
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

  //funzione che compara la data di creazione di un post
  public function cmp($a, $b) {
      if ($a->created_at == $b->created_at) return 0;
      return (strtotime($a->created_at) < strtotime($b->created_at)) ? 1 : -1;
  }

  //verifica l'integrità del login
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

  //per ogni id post passato, crea una struttura del tipo 'PostViewModel' con all'interno tutti i dettagli di un post
  public function createPost($logged_user, $post_id){
    $tmp_comm = array();
    $post = Post::where('id_post', $post_id)->first();
    $post_comments = CommentU::where('id_post', $post_id)->get();
    if(!is_numeric($post['id_author'])){
      $user_post = User::where('id_user', $post['id_author'])->first();
    }
    else{
      $user_post = Page::where('id_page', $post['id_author'])->first();
    }
    foreach($post_comments as $comment){
      if(!is_numeric($comment['id_author'])){
        $comm_user = User::where('id_user', $comment['id_author'])->first();
      }
      else{
        $comm_user = Page::where('id_page', $comment['id_author'])->first();
      }
      array_push($tmp_comm, new CommentViewModel($comment['id_comment'], $comm_user['name'],
                                                $comm_user['surname'], $comm_user['pic_path'],
                                                $comment['content'], $comment['created_at'], $comment['updated_at'],
                                                $comment['id_post'], '0',
                                                LikeComment::where('id_comment', $comment['id_comment'])->where('like', 1)->get()->count(),
                                                LikeComment::where('id_comment', $comment['id_comment'])->where('like', 0)->get()->count(),
                                                LikeComment::where('id_user', $logged_user['id_user'])->where('id_comment', $comment['id_comment'])->first()['like'],
                                                $comment['id_author'], $comm_user['ban']));
    }


    $toreturn = new PostViewModel($post_id, $user_post['name'], $user_post['surname'], $user_post['pic_path'],
                      $post['content'], $post['created_at'], $post['updated_at'],
                      $post['is_fixed'], $post['id_author'], $tmp_comm,
                      LikePost::where('id_post', $post['id_post'])->where('like', 1)->get()->count(),
                      LikePost::where('id_post', $post['id_post'])->where('like', 0)->get()->count(),
                      LikePost::where('id_user', $logged_user['id_user'])->where('id_post', $post['id_post'])->first()['like'],
                      $user_post['ban']);
    return($toreturn);
  }

  //gestione dell'inserimento nella tabella dei log
  public function log($id_user, $action){
    DB::table('log')->insert(['id_user' => $id_user, 'action' => $action, 'created_at' => now()]);
  }

  //loading dei post
  public function loadMore(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();

    $friends = User::friends($logged_user['id_user']);     //Torna un array con gli amici
    $followed_pages_id = Users_follow_pages::where('id_user', $logged_user['id_user'])->get();

    //Caricamento dei post degli amici e delle pagine
    $posts_ids = array();
    $list_comments = array();
    $likes = array();

    //inserisco i miei posts
    array_push($posts_ids, PostUser::where('id_user', $logged_user['id_user'])->pluck('id_post')->toArray());

    //id post delle pagine seguite
    foreach ($followed_pages_id as $id_page){
      array_push($posts_ids, PostPage::where('id_page', $id_page['id_page'])->pluck('id_post')->toArray());
    }

    //ids post amici
    foreach ($friends as $friend){
      array_push($posts_ids, PostUser::where('id_user', $friend['id_user'])->pluck('id_post')->toArray());
    }

    //faccio la flatten dell'array, adesso ho i post tutti uguali
    $posts_ids = array_flatten($posts_ids);
    $toreturn = array();
    foreach ($posts_ids as $post_id){
      //recupero tutte le informazioni di un post e me le restituisco in un array complesso
      array_push($toreturn, $this->createPost($logged_user, $post_id));
    }
    //ordino per data
    usort($toreturn, array($this, 'cmp'));

    if($request->input('post_id') == -1){
      $toreturn = array_slice($toreturn, 0, 7);
      return(json_encode($toreturn));
    }
    else{
      for($i = 0; $i < count($toreturn); $i++){
        if($toreturn[$i]->id_post == $request->input('post_id')){
            $toreturn = array_slice($toreturn, $i + 1, $i + 5);
            return(json_encode($toreturn));
        }
      }
    }
  }

  //funzione che inserisce notifiche nel db
  public function sendNotification($id, $type, $post_id, $is_like){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    switch($type){
      case "likecomment":
        if(($logged_user['id_user']) != (CommentU::where('id_comment', $id)->first()['id_author'])){
          DB::table('notifications')->insert(['created_at' => now(), 'updated_at' => now(), 'content' => $logged_user['name'] . " " . $logged_user['surname'] . " ha messo " . $is_like . " al tuo commento.", 'new' => 1,
                                              'id_user' => CommentU::where('id_comment', $id)->first()['id_author'], 'link' => "/details/post/" . $post_id]);
        }
        break;
      case "likepost":
        if(($logged_user['id_user']) != (Post::where('id_post', $id)->first()['id_author'])){
          DB::table('notifications')->insert(['created_at' => now(), 'updated_at' => now(), 'content' => $logged_user['name'] . " " . $logged_user['surname'] . " ha messo " . $is_like . " al tuo post.", 'new' => 1,
                                              'id_user' => Post::where('id_post', intval($id))->first()['id_author'], 'link' => "/details/post/" . $id]);
        }
        break;
      case "comment":
        if(($logged_user['id_user']) != (Post::where('id_post', $id)->first()['id_author'])){
          DB::table('notifications')->insert(['created_at' => now(), 'updated_at' => now(), 'content' => $logged_user['name'] . " " . $logged_user['surname'] . " ha commentato il al tuo post.", 'new' => 1,
                                              'id_user' => Post::where('id_post', $id)->first()['id_author'], 'link' => "/details/post/" . $post_id]);
        }
        break;
    }
  }

  //funzione richiamata quando viene richiesta la root del nostro sito
  public function landing(){
    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      //log
      return view('home', compact('logged_user'));
    }
    else{
      //$this->log($logged_user['id_user'], "Try to log in.");
      return redirect('/login');
    }
  }

  //funzione che imposta le reazioni a commenti e post
  public function reaction(Request $request){
    //manca controllo bontà dei parametri
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    switch(request('action')){
      case "like":
        $record = LikePost::where('id_post', request('id'))->where('id_user', Cookie::get('session'))->first();
        if(($record) && ($record['like'] == 1)){
          //se premo di nuovo il pulsante elimino il record ed elimino la notifica
          DB::table('notifications')->where('id_user', Post::where('id_post', request('id'))->first()['id_author'] )->where('link', '/details/post/' . request('id'))->delete();
          DB::table('like_posts')->where('id_post', request('id'))->where('id_user', Cookie::get('session'))->delete();
          //log
          $this->log($logged_user['id_user'], 'Remove Like Post_' . $record['id_post']);
          return(json_encode(array('type' => 'post', 'id_post' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'black')));
        }
        else if(($record) && ($record['like'] == 0)){
          //se il post non è mio, inserisco una notifica
          DB::table('notifications')->where('id_user', Post::where('id_post', request('id'))->first()['id_author'] )->where('link', '/details/post/' . request('id'))->delete();
          $this->sendNotification(request('id'), "likepost", request('id'), 'mipiace');
          DB::table('like_posts')->where('id_post', request('id'))->update(array('like' => 1));
          //log
          $this->log($logged_user['id_user'], 'Change Dislike Post in Like_' . $record['id_post']);
          return(json_encode(array('type' => 'post', 'id_post' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'blue', 'status_dislike' => 'black')));
        }
        else{
          $like = new LikePost();
          $like->id_post = request('id');
          $like->like = 1;
          $like->id_user = Cookie::get('session');
          $like->save();
          //notifica
          $this->sendNotification(request('id'), "likepost", request('id'), 'mi piace');
          //log
          $this->log($logged_user['id_user'], 'Like Post_' . request('id'));
          return(json_encode(array('type' => 'post','id_post' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'blue', 'status_dislike' => 'black')));
        }
        break;

      case "dislike":
        $record = LikePost::where('id_post', request('id'))->where('id_user', Cookie::get('session'))->first();
        if(($record) && ($record['like'] == 0)){
          //se premo di nuovo il pulsante elimino il record ed elimino la notifica!!
          DB::table('notifications')->where('id_user', Post::where('id_post', request('id'))->first()['id_author'] )->where('link', '/details/post/' . request('id'))->delete();
          DB::table('like_posts')->where('id_post', request('id'))->where('id_user', Cookie::get('session'))->delete();
          //log
          $this->log($logged_user['id_user'], 'Remove Dislike Post_' . $record['id_post']);
          return(json_encode(array('type' => 'post', 'id_post' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'black')));
        }
        else if(($record) && ($record['like'] == 1)){
          DB::table('notifications')->where('id_user', Post::where('id_post', request('id'))->first()['id_author'] )->where('link', '/details/post/' . request('id'))->delete();
          $this->sendNotification(request('id'), "likepost", request('id'), 'non mi piace');
          DB::table('like_posts')->where('id_post', request('id'))->update(array('like' => 0));
          //log
          $this->log($logged_user['id_user'], 'Change Like Post in Dislike_' . $record['id_post']);
          return(json_encode(array('type' => 'post','id_post' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'red')));
        }
        else{
          $like = new LikePost();
          $like->id_post = request('id');
          $like->like = 0;
          $like->id_user = Cookie::get('session');
          $like->save();
          $this->sendNotification(request('id'), "likepost", request('id'), 'non mi piace');
          //log
          $this->log($logged_user['id_user'], 'Disike Post_' . request('id'));
          return(json_encode(array('type' => 'post', 'id_post' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'red')));
        }
        break;

      case "likecomm":
        $record = LikeComment::where('id_comment', request('id'))->where('id_user', Cookie::get('session'))->first();
        if(($record) && ($record['like'] == 1)){
          //se premo di nuovo il pulsante elimino il record
          DB::table('notifications')->where('id_user', CommentU::where('id_comment', request('id'))->first()['id_author'])->where('link', '/details/post/' . CommentU::where('id_comment', request('id'))->first()['id_post'])->delete();
          DB::table('like_comments')->where('id_comment', request('id'))->where('id_user', Cookie::get('session'))->delete();
          //log
          $this->log($logged_user['id_user'], 'Remove Comment Like_' . $record['id_comment']);
          return(json_encode(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'black')));
        }
        else if(($record) && ($record['like'] == 0)){
          DB::table('notifications')->where('id_user', CommentU::where('id_comment', request('id'))->first()['id_author'] )->where('link', '/details/post/' . CommentU::where('id_comment', request('id'))->first()['id_post'])->delete();
          $this->sendNotification(request('id'), "likecomment", CommentU::where('id_comment', request('id'))->first()['id_post'], 'mi piace');
          DB::table('like_comments')->where('id_comment', request('id'))->update(array('like' => 1));
          //log
          $this->log($logged_user['id_user'], 'Change Comment Like in Dislike_' . $record['id_comment']);
          return(json_encode(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'blue', 'status_dislike' => 'black')));
        }
        else{
          $like = new LikeComment();
          $like->id_comment = request('id');
          $like->like = 1;
          $like->id_user = Cookie::get('session');
          $like->save();
          $this->sendNotification(request('id'), "likecomment", CommentU::where('id_comment', request('id'))->first()['id_post'], 'mi piace');
          //log
          $this->log($logged_user['id_user'], 'Comment Like_' . request('id'));
          return(json_encode(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'blue', 'status_dislike' => 'black')));
        }
        break;

      case "dislikecomm":
        $record = LikeComment::where('id_comment', request('id'))->where('id_user', Cookie::get('session'))->first();
        if(($record) && ($record['like'] == 0)){
          //se premo di nuovo il pulsante elimino il record
          DB::table('notifications')->where('id_user', CommentU::where('id_comment', request('id'))->first()['id_author'] )->where('link', '/details/post/' . CommentU::where('id_comment', request('id'))->first()['id_post'])->delete();
          DB::table('like_comments')->where('id_comment', request('id'))->where('id_user', Cookie::get('session'))->delete();
          //log
          $this->log($logged_user['id_user'], 'Remove Comment Dislike_' . $record['id_comment']);
          return(json_encode(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'black')));
        }
        else if(($record) && ($record['like'] == 1)){
          DB::table('notifications')->where('id_user', CommentU::where('id_comment', request('id'))->first()['id_author'] )->where('link', '/details/post/' . CommentU::where('id_comment', request('id'))->first()['id_post'])->delete();
          $this->sendNotification(request('id'), "likecomment", CommentU::where('id_comment', request('id'))->first()['id_post'], 'non mi piace');
          DB::table('like_comments')->where('id_comment', request('id'))->update(array('like' => 0));
          //log
          $this->log($logged_user['id_user'], 'Changed Comment Dislike in Like_' . $record['id_comment']);
          return(json_encode(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'red')));
        }
        else{
          $like = new LikeComment();
          $like->id_comment = request('id');
          $like->like = 0;
          $like->id_user = Cookie::get('session');
          $like->save();
          $this->sendNotification(request('id'), "likecomment", CommentU::where('id_comment', request('id'))->first()['id_post'], ' non mi piace');
          //log
          $this->log($logged_user['id_user'], 'Comment Dislike_' . request('id'));
          return(json_encode(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => Cookie::get('session'), 'status_like' => 'black', 'status_dislike' => 'red')));
        }
        break;
    }

  }

  //funzione che crea un nuovo post
  public function newPost(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
      //verifica dei campi
      if($logged_user['ban'] != 1){
        $post = new Post();
        $post->content =  $request->input('content');
        $post->created_at = now();
        $post->updated_at = now();
        $post->fixed = $request->input('is_fixed');
        $post->id_author = $logged_user['id_user'];
        $post->save();
        //chiamata di verifica e di inserimento nella tabella 'posts_user' del record relativo al post
        $post_tmp = Post::where('id_author', $logged_user['id_user'])->where('content', request('content'))->first();
        DB::table('posts_user')->insert(['id_user' => $logged_user['id_user'], 'id_post' => $post_tmp['id_post']]);
        $post = new PostViewModel($post_tmp['id_post'], $logged_user['name'], $logged_user['surname'], $logged_user['pic_path'], $post_tmp['content'], $post_tmp['created_at'], $post_tmp['updated_at'], $post_tmp['fixed'], $post_tmp['id_author'], [], [], [], [], $logged_user['ban']);
        //log
        $this->log($logged_user['id_user'], 'New Post_' . $post_tmp['id_post']);
        return(json_encode($post));
      }
      else{
        return(json_encode(new PostViewModel(null, $logged_user['name'], $logged_user['surname'], $logged_user['pic_path'],null, null, null,  null, null, null, null, null, null, $logged_user['ban'])));
      }
    }

  //funzione che crea un nuovo commento
  public function newComment(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    if($logged_user['ban'] != 1){
      $comment = new CommentU();
      $comment->created_at = now();
      $comment->updated_at = now();
      $comment->content = $request->input('content');
      $comment->id_author = $logged_user['id_user'];
      $comment->id_post =  $request->input('id_post');
      $comment->save();
      //Query di verifica
      $comm_tmp = CommentU::where('id_author', $logged_user['id_user'])->where('content', request('content'))->first();
      DB::table('comments_user')->insert(['id_user' => $logged_user['id_user'], 'id_comment' => $comm_tmp['id_comment']]);
      $this->sendNotification($request->input('id_post'), "comment", $request->input('id_post'), null);
      $comment = new CommentViewModel($comm_tmp['id_comment'], $logged_user['name'], $logged_user['surname'], $logged_user['pic_path'],$comm_tmp['content'], $comm_tmp['created_at'], $comm_tmp['updated_at'], $comm_tmp['id_post'], NULL, [], [], NULL, $logged_user['id_user'], $logged_user['ban']);
      //log
      $this->log($logged_user['id_user'], 'New Comment_' . $comm_tmp['id_comment']);
      return(json_encode($comment));
    }
    else{
      return(json_encode(new CommentViewModel(null, $logged_user['name'], $logged_user['surname'], $logged_user['pic_path'],null, null, null, null, NULL, [], [], NULL, $logged_user['id_user'], $logged_user['ban'])));
    }
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

  public function reportPost(Request $request){
    $id = $request->input('id_post');
    $post = Post::where('id_post', '=', $id)->first();
    if(!$post)
      return response()->json(['message' => 'Post non trovato']);
    $motivo = $request->input('motivo');
    $report = new ReportPost();
    $report->id_post = $id;
    $report->status = "aperta";
    $report->description = $motivo;
    $report->save();
    //log
    $this->log($logged_user['id_user'], 'Report Post_' . $report['id_post']);
    return response()->json(['message' => 'Segnalazione completata!']);
  }

  public function reportComment(Request $request){
    $id = $request->input('id_comment');
    $comment = CommentU::where('id_comment', '=', $id)->first();
    if(!$comment)
      return response()->json(['message' => 'Commento non trovato']);
    $motivo = $request->input('motivo');
    $report = new ReportComment();
    $report->id_comment = $id;
    $report->status = "aperta";
    $report->description = $motivo;
    $report->save();
    //log
    $this->log($logged_user['id_user'], 'Report Comment_' . $report['id_comment']);
    return response()->json(['message' => 'Segnalazione completata!']);
  }
}
