<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DateTime;
use App\User;
use App\Page;
use App\Post;
use App\Users_make_friends;
use App\Users_follow_pages;
use App\PostUser;
use App\PostPage;
use App\CommentUser;
use App\Comment;
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

  //gestione dell'inserimento nella tabella dei log
  public function log($id_user, $action){
    DB::table('log')->insert(['id_user' => $id_user, 'action' => $action, 'created_at' => now()]);
  }

  //loading dei post
  public function loadMore(Request $request){
    //distinguo il tipo di post che devo caricare: 'home' carica la homepage, 'user' carica il profilo dell'utente, 'page' carica il profilo della pagina
    if(request('home')){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $friends = User::friends($logged_user['id_user']);     //Torna un array con gli amici
      $followed_pages_id = Users_follow_pages::where('id_user', $logged_user['id_user'])->get();
      //Caricamento dei post degli amici e delle pagine
      $posts_ids = array();
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
      //faccio la flatten dell'array
      $posts_ids = array_flatten($posts_ids);
      //Ora prendo i miei post e torna un array ordinato in base all'orario di PostViewModel
      $toreturn = Post::GetPosts($posts_ids, $logged_user['id_user']);
    }
    else if(request('user')){
      $user = User::where('id_user', request('id'))->first();
      $post_ids = PostUser::where('id_user', $user['id_user'])->pluck('id_post')->toArray();
      $toreturn = Post::GetPosts($post_ids, $user['id_user']);
    }
    else if(request('page')){
      $page = Page::where('id_page', request('id'))->first();
      $post_ids = PostPage::where('id_page', $page['id_page'])->pluck('id_post')->toArray();
      $toreturn = Post::GetPosts($post_ids, $page['id_page']);
    }

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

  //funzione richiamata quando viene richiesta la root del nostro sito
  public function landing(){
    if($this->verify_cookie()){
      $logged_user = User::where('id_user', Cookie::get('session'))->first();
      $suggested_friends = User::Suggestedfriends($logged_user['id_user']);
      //log
      return view('home', compact('logged_user', 'suggested_friends'));
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
    if((request('action') == 'like') || (request('action') == 'dislike')){
      $toreturn = LikePost::SetPostReaction(request('action'), request('id'), $logged_user['id_user']);
      return(json_encode($toreturn));
    }
    else{
      $toreturn = LikeComment::SetCommentReaction(request('action'), request('id'), $logged_user['id_user']);
      return(json_encode($toreturn));
    }
  }

  //funzione che crea un nuovo post
  public function newPost(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    if(!request('id_page')){
      $post = Post::InsertPost(request('content'), $logged_user['id_user']);
    }
    else{
      $post = Post::InsertPost(request('content'), request('id_page'));
    }
    if($post){
      //log
      $this->log($logged_user['id_user'], 'New Post_' . $post->id_post);
      return(json_encode($post));
    }
    else{
      $this->log($logged_user['id_user'], 'Banned User Tried to post');
      return(json_encode(["ban" => 1]));
    }
  }

  //funzione che crea un nuovo commento
  public function newComment(Request $request){
    $logged_user = User::where('id_user', Cookie::get('session'))->first();
    if(!request('id_page')){
      $comment = Comment::InsertComment(request('content'), $logged_user['id_user'], request('id_post'));
    }
    else if((request('id_page')) && ($logged_user['id_user'] === Page::where('id_page', request('id_page'))->first()['id_user'])) {
      $comment = Comment::InsertComment(request('content'), request('id_page'), request('id_post'));
    }
    else{
      $comment = Comment::InsertComment(request('content'), $logged_user['id_user'], request('id_post'));
    }
    if($comment){
      if(!is_numeric(Post::where('id_post', request('id_post'))->first()['id_author'])){
        Notification::SendNotification($comment->id_post, $logged_user, "comment", $comment->id_post, null);
      }
      // else{
      //   //mando la notifica all'owner della Pagina
      //   $id_user = Post::where('id_post', request('id_post'))->first()['id_author'];
      //   Notification::SendNotification($comment->id_post, $id_user, "commentpage", $comment->id_post, null);
      // }
      //log
      $this->log($logged_user['id_user'], 'New Comment_' . $comment->id_comment);
      return(json_encode($comment));
    }
    else{
      return(json_encode(['ban'=> 1]));
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

  public function reportPost(Request $request){
    $id = Cookie::get('session');
    $logged_user = User::where('id_user', '=', $id)->first();
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
    $id = Cookie::get('session');
    $logged_user = User::where('id_user', '=', $id)->first();
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
