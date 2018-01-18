<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;
use App\Notification;
use App\LikePost;
use App\LikePostPage;
use Illuminate\Support\Facades\DB;


class LikePostPage extends Model
{
  protected $table = 'pages_like_posts';
  public $timestamps = false;

  public function scopeSetPagePostReaction($query, $action, $id_post, $liker_id){
    $user = Page::where('id_page', $liker_id)->first();
    switch($action){
      case "like":
        $record = LikePostPage::where('id_post', $id_post)->where('id_page', $liker_id)->first();
        if(($record) && ($record['like'] == 1)){
          DB::table('pages_like_posts')->where('id_post', $id_post)->where('id_page', $liker_id)->delete();
          return(array('type' => 'post', 'id_post' => $id_post, 'id_page' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'black'));
        }
        else if(($record) && ($record['like'] == 0)){
          DB::table('pages_like_posts')->where('id_post', $id_post)->update(array('like' => 1));
          return(array('type' => 'post', 'id_post' => $id_post, 'id_page' => $liker_id, 'status_like' => 'blue', 'status_dislike' => 'black'));
        }
        else{
          $like = new LikePostPage();
          $like->id_post = $id_post;
          $like->like = 1;
          $like->id_page = $liker_id;
          $like->save();
          return(array('type' => 'post','id_post' => $id_post, 'id_page' => $liker_id, 'status_like' => 'blue', 'status_dislike' => 'black'));
        }
        break;

      case "dislike":
        $record = LikePostPage::where('id_post', $id_post)->where('id_page', $liker_id)->first();
        if(($record) && ($record['like'] == 0)){
          DB::table('pages_like_posts')->where('id_post', $id_post)->where('id_page', $liker_id)->delete();
          return(array('type' => 'post', 'id_post' => $id_post, 'id_page' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'black'));
        }
        else if(($record) && ($record['like'] == 1)){
          DB::table('pages_like_posts')->where('id_post', $id_post)->update(array('like' => 0));
          return(array('type' => 'post','id_post' => $id_post, 'id_page' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'red'));
        }
        else{
          $like = new LikePostPage();
          $like->id_post = $id_post;
          $like->like = 0;
          $like->id_page = $liker_id;
          $like->save();

          return(array('type' => 'post', 'id_post' => $id_post, 'id_page' => $liker_id, 'status_like' => 'black', 'status_dislike' => 'red'));
        }
        break;
      }
    }
}
