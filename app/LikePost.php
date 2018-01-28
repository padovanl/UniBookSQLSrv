<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;
use App\Notification;
use App\LikePost;
use Illuminate\Support\Facades\DB;


class LikePost extends Model
{
  protected $table = 'like_posts';
  public $timestamps = false;

  public function scopeGetPostLike($query, $post){
    //Prendo gli user che hanno like
    $post_like = LikePost::where('id_post', $post['id_post'])->where('like', 1)->get();
    $page_like = LikePostPage::where('id_post', $post['id_post'])->where('like', 1)->get();
    $users_like = array();
    foreach($post_like as $like){
      array_push($users_like, User::where('id_user', $like['id_user'])->first());
    }
    foreach($page_like as $like){
      array_push($users_like, Page::where('id_page', $like['id_page'])->first());
    }
    return($users_like);
  }

  public function scopeGetPostDislike($query, $post){
    //Prendo gli user che hanno dislike
    $post_dislike = LikePost::where('id_post', $post['id_post'])->where('like', 0)->get();
    $page_dislike = LikePostPage::where('id_post', $post['id_post'])->where('like', 0)->get();
    $users_dislike = array();
    foreach($post_dislike as $dislike){
      array_push($users_dislike, User::where('id_user', $dislike['id_user'])->first());
    }
    foreach($page_dislike as $dislike){
      array_push($users_dislike, Page::where('id_page', $dislike['id_page'])->first());
    }
    return($users_dislike);
  }

  public function scopeSetPostReaction($query, $action, $id_post, $liker_id){
    $user = User::where('id_user', $liker_id)->first();
    switch($action){
      case "like":
        $record = LikePost::where('id_post', $id_post)->where('id_user', $liker_id)->first();
        if(($record) && ($record['like'] == 1)){
          //se premo di nuovo il pulsante elimino il record ed elimino la notifica
          DB::table('notifications')->where('id_user', Post::where('id_post', $id_post)->first()['id_author'])->where('link', '/details/post/' . $id_post)->delete();
          DB::table('like_posts')->where('id_post', $id_post)->where('id_user', $liker_id)->delete();
          return(array('type' => 'post', 'id_post' => $id_post, 'id_user' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'black'));
        }
        else if(($record) && ($record['like'] == 0)){
          //se il post non è mio, inserisco una notifica
          DB::table('notifications')->where('id_user', Post::where('id_post', $id_post)->first()['id_author'] )->where('link', '/details/post/' . $id_post)->delete();
          if(!is_numeric(Post::where('id_post', $id_post)->first()['id_author'])){
            Notification::SendNotification($id_post, $user, "likepost", $id_post, 'mipiace');
          }
          DB::table('like_posts')->where('id_post', $id_post)->where('id_user', $user['id_user'])->update(array('like' => 1));
          return(array('type' => 'post', 'id_post' => $id_post, 'id_user' => $liker_id, 'status_like' => 'blue', 'status_dislike' => 'black'));
        }
        else{
          $like = new LikePost();
          $like->id_post = $id_post;
          $like->like = 1;
          $like->id_user = $liker_id;
          $like->save();
          //notifica
          if(!is_numeric(Post::where('id_post', $id_post)->first()['id_author'])){
            Notification::SendNotification($id_post, $user, "likepost", $liker_id, 'mi piace');
          }
          return(array('type' => 'post','id_post' => $id_post, 'id_user' => $liker_id, 'status_like' => 'blue', 'status_dislike' => 'black'));
        }
        break;

      case "dislike":
        $record = LikePost::where('id_post', $id_post)->where('id_user', $liker_id)->first();
        if(($record) && ($record['like'] == 0)){
          //se premo di nuovo il pulsante elimino il record ed elimino la notifica!!
          DB::table('notifications')->where('id_user', Post::where('id_post', $liker_id)->first()['id_author'] )->where('link', '/details/post/' . $id_post)->delete();
          DB::table('like_posts')->where('id_post', $id_post)->where('id_user', $liker_id)->delete();
          return(array('type' => 'post', 'id_post' => $id_post, 'id_user' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'black'));
        }
        else if(($record) && ($record['like'] == 1)){
          DB::table('notifications')->where('id_user', Post::where('id_post', $id_post)->first()['id_author'] )->where('link', '/details/post/' . $id_post)->delete();
          if(!is_numeric(Post::where('id_post', $id_post)->first()['id_author'])){
            Notification::SendNotification($id_post, $user, "likepost", $id_post, 'non mi piace');
          }
          DB::table('like_posts')->where('id_post', $id_post)->where('id_user', $user['id_user'])->update(array('like' => 0));
          return(array('type' => 'post','id_post' => $id_post, 'id_user' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'red'));
        }
        else{
          $like = new LikePost();
          $like->id_post = $id_post;
          $like->like = 0;
          $like->id_user = $liker_id;
          $like->save();
          if(!is_numeric(Post::where('id_post', $id_post)->first()['id_author'])){
            Notification::SendNotification($id_post, $user, "likepost", $id_post, 'non mi piace');
          }
          return(array('type' => 'post', 'id_post' => $id_post, 'id_user' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'red'));
        }
        break;
      }
    }
}
