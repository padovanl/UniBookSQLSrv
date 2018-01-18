<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Page;
use App\LikeComment;
use App\LikeCommentPage;
use App\CommentViewModel;
use Illuminate\Support\Facades\DB;


class Comment extends Model
{
  protected $table = 'comments';
  public $timestamps = false;


  public function scopeGetCommentsPost($query, $post_comments, $logged, $author, $in_page=null){
    $tmp_comm = array();
    foreach($post_comments as $comment){
      if(!is_numeric($comment['id_author'])){
        $comm_user = User::where('id_user', $comment['id_author'])->first();
        $user_liked = LikeComment::where('id_user', $logged)->where('id_comment', $comment['id_comment'])->first()['like'];
      }
      else{
        $comm_user = Page::where('id_page', $comment['id_author'])->first();
        if($in_page){
          $user_liked = LikeCommentPage::where('id_page', $logged)->where('id_comment', $comment['id_comment'])->first()['like'];
        }
        else{
          $user_liked = LikeComment::where('id_user', $logged)->where('id_comment', $comment['id_comment'])->first()['like'];
        }
      }
      $users_like = LikeComment::GetLikeComment($comment);
      $users_dislike = LikeComment::GetDislikeComment($comment);

      array_push($tmp_comm, new CommentViewModel($comment['id_comment'], $comm_user['name'],
                                                $comm_user['surname'], $comm_user['pic_path'],
                                                $comment['content'], $comment['created_at'], $comment['updated_at'],
                                                $comment['id_post'],
                                                $users_like,
                                                $users_dislike,
                                                $user_liked,
                                                $comment['id_author'], $comm_user['ban']));
    }
    return($tmp_comm);
  }

  public function scopeInsertComment($query, $content, $author, $post_id){
    date_default_timezone_set('Europe/Rome');
    if(!is_numeric($author)){
      $user = User::where('id_user', $author)->first();
      if(!$user['ban']){
        $comment = new Comment();
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->content = $content;
        $comment->id_author = $author;
        $comment->id_post =  $post_id;
        $comment->save();
        //Query di verifica
        $comm_tmp = Comment::where('id_author', $author)->where('content', request('content'))->first();
        DB::table('comments_user')->insert(['id_user' => $user['id_user'], 'id_comment' => $comm_tmp['id_comment']]);
        $comment = new CommentViewModel($comm_tmp['id_comment'], $user['name'], $user['surname'], $user['pic_path'],$comm_tmp['content'], $comm_tmp['created_at'], $comm_tmp['updated_at'], $comm_tmp['id_post'], [], [], NULL, $user['id_user'], $user['ban']);
        return($comment);
      }
      else{
        return(false);
      }
    }
    else if(is_numeric($author)){
      $page = Page::where('id_page', $author)->first();
      if(!$page['ban']){
        $comment = new Comment();
        $comment->created_at = now();
        $comment->updated_at = now();
        $comment->content = $content;
        $comment->id_author = $author;
        $comment->id_post =  $post_id;
        $comment->save();
        //Query di verifica
        $comm_tmp = Comment::where('id_author', $author)->where('content', request('content'))->first();
        DB::table('comments_page')->insert(['id_page' => $page['id_page'], 'id_comment' => $comm_tmp['id_comment']]);
        $comment = new CommentViewModel($comm_tmp['id_comment'], $page['name'], '', $page['pic_path'], $comm_tmp['content'], $comm_tmp['created_at'], $comm_tmp['updated_at'], $comm_tmp['id_post'], [], [], NULL, $page['id_page'], $page['ban']);
        return($comment);
      }
      else{
        return(false);
      }
    }
  }
}
