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
        return view('profile', compact('logged_user', 'controller', 'user'));
      }
    }
    else{
      return view('login');
    }
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

  //loading dei post
  public function loadMore(Request $request){

    $id = request("id");
    $user = User::where('id_user', $id)->first();

    //Caricamento dei post degli amici e delle pagine
    $posts = array();
    $list_comments = array();
    $likes = array();

    //inserisco anche i miei posts
    array_push($posts, Post::where('id_author', $user['id_user'])->orderBy('created_at', 'asc')->get());
    array_push($list_comments, CommentU::where('id_author', $user['id_user'])->orderBy('created_at', 'asc')->get());

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
                                                      LikeComment::where('id_user', $user['id_user'])->where('id_comment', $comment['id_comment'])->first()['like'],
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
                                      LikePost::where('id_user', $user['id_user'])->where('id_post', $post['id_post'])->first()['like'],
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
                                      LikePost::where('id_user', $user['id_user'])->where('id_post', $post['id_post'])->first()['like'],
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
  //cambio immagine profilo
  public function formImage(Request $request){
    $file = request("fd");
    if(isset($file["file"]["type"]))
        {
          $validextensions = array("jpeg", "jpg", "png");
          $temporary = explode(".", $file["file"]["name"]);
          $file_extension = end($temporary);
          if ((($file["file"]["type"] == "image/png") || ($file["file"]["type"] == "image/jpg") || ($file["file"]["type"] == "image/jpeg")
            ) && ($file["file"]["size"] < 100000)//Approx. 100kb files can be uploaded.
            && in_array($file_extension, $validextensions)) {
            if ($file["file"]["error"] > 0)
              {
                echo "Return Code: " . $file["file"]["error"] . "<br/><br/>";
              }
            else
              {
              if (file_exists("upload/" . $file["file"]["name"])) {
                echo $file["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                }
              else{
                  $sourcePath = $file['file']['tmp_name']; // Storing source path of the file in a variable
                  $targetPath = "public/assets/images/".$file['file']['name']; // Target path where file is to be stored
                  move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
                  echo "<span id='success'>Image Uploaded Successfully...!!</span><br/>";
                  echo "<br/><b>File Name:</b> " . $file["file"]["name"] . "<br>";
                  echo "<b>Type:</b> " . $file["file"]["type"] . "<br>";
                  echo "<b>Size:</b> " . ($file["file"]["size"] / 1024) . " kB<br>";
                  echo "<b>Temp file:</b> " . $file["file"]["tmp_name"] . "<br>";
                }
              }
            }
          else
            {
              echo "<span id='invalid'>***Invalid file Size or Type***<span>";
            }
        }
  }
}
?>
