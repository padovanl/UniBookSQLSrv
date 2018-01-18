<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Post;
use App\Notification;
use App\LikePost;
use App\LikeCommentPage;
use Illuminate\Support\Facades\DB;


class LikeCommentPage extends Model
{
  protected $table = 'pages_like_comments';
  public $timestamps = false;

  public function scopeSetCommentPageReaction($query, $action, $id_comment, $page){
    switch($action){
      case "likecomm":
        $record = LikeCommentPage::where('id_comment', $id_comment)->where('id_page', $page['id_page'])->first();
        if(($record) && ($record['like'] === 1)){
          DB::table('pages_like_comments')->where('id_comment', $id_comment)->where('id_page', $page['id_page'])->delete();
          return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_page' => $page['id_page'], 'status_like' => 'black', 'status_dislike' => 'black'));
        }
        else if(($record) && ($record['like'] === 0)){
          DB::table('pages_like_comments')->where('id_comment', $id_comment)->where('id_page', $page['id_page'])->update(array('like' => 1));
          return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_page' => $page['id_page'], 'status_like' => 'blue', 'status_dislike' => 'black'));
        }
        else{
          $like = new LikeCommentPage();
          $like->id_comment = $id_comment;
          $like->like = 1;
          $like->id_page = $page['id_page'];
          $like->save();
          return(array('type' => 'comm', 'id_comment' => request('id'), 'id_page' => $page['id_page'], 'status_like' => 'blue', 'status_dislike' => 'black'));
        }
        break;

      case "dislikecomm":
        $record = LikeCommentPage::where('id_comment', $id_comment)->where('id_page', $page['id_page'])->first();
        if(($record) && ($record['like'] == 0)){
          DB::table('pages_like_comments')->where('id_comment', $id_comment)->where('id_page', $page['id_page'])->delete();
          return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_page' => $page['id_page'], 'status_like' => 'black', 'status_dislike' => 'black'));
        }
        else if(($record) && ($record['like'] == 1)){
          DB::table('pages_like_comments')->where('id_comment', $id_comment)->where('id_page', $page['id_page'])->update(array('like' => 0));
          return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_page' => $page['id_page'], 'status_like' => 'black', 'status_dislike' => 'red'));
        }
        else{
          $like = new LikeCommentPage();
          $like->id_comment = $id_comment;
          $like->like = 0;
          $like->id_page = $page['id_page'];
          $like->save();
          return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_page' => $page['id_page'], 'status_like' => 'black', 'status_dislike' => 'red'));
        }
        break;
    }
  }
}
