<?php

namespace App;

use App\User;
use App\LikeComment;
use App\Notification;
use App\Comment;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
	protected $table = 'like_comments';
	public $timestamps = false;

	public function scopeGetLikeComment($query, $comment){
		$likes = LikeComment::where('id_comment', $comment['id_comment'])->where('like', 1)->get();
		$page_like = LikeCommentPage::where('id_comment', $comment['id_comment'])->where('like', 1)->get();
		$users_like = array();
		foreach($likes as $like){
			array_push($users_like, User::where('id_user', $like['id_user'])->first());
		}
		foreach($page_like as $like){
			array_push($users_like, Page::where('id_page', $like['id_page'])->first());
		}
		return($users_like);
	}

	public function scopeGetDislikeComment($query, $comment){
		$dislikes = LikeComment::where('id_comment', $comment['id_comment'])->where('like', 0)->get();
		$page_dislike = LikeCommentPage::where('id_comment', $comment['id_comment'])->where('like', 0)->get();
		$users_dislike = array();
		foreach($dislikes as $dislike){
			array_push($users_dislike, User::where('id_user', $dislike['id_user'])->first());
		}
		foreach($page_dislike as $like){
			array_push($users_dislike, Page::where('id_page', $like['id_page'])->first());
		}
		return($users_dislike);
	}

	public function scopeSetCommentReaction($query, $action, $id_comment, $user){
		$id_author = Comment::where('id_comment', $id_comment)->first()['id_author'];
		switch($action){
			case "likecomm":
				$record = LikeComment::where('id_comment', $id_comment)->where('id_user', $user['id_user'])->first();
				if(($record) && ($record['like'] === 1)){
					//se premo di nuovo il pulsante elimino il record
					DB::table('notifications')->where('id_sender', $user['id_user'])->where('link', '/details/post/' . Comment::where('id_comment', $id_comment)->first()['id_post'])->delete();
					DB::table('like_comments')->where('id_comment', $id_comment)->where('id_user', $user['id_user'])->delete();
					return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_user' => $user['id_user'], 'status_like' => 'black', 'status_dislike' => 'black'));
				}
				else if(($record) && ($record['like'] === 0)){
					DB::table('notifications')->where('id_user', Comment::where('id_comment', $id_comment)->first()['id_author'] )->where('link', '/details/post/' . Comment::where('id_comment', $id_comment)->first()['id_post'])->delete();
					DB::table('like_comments')->where('id_comment', $id_comment)->where('id_user', $user['id_user'])->update(array('like' => 1));
					if(!is_numeric(Comment::where('id_comment', $id_comment)->first()['id_author'])){
						Notification::SendNotification($id_comment, $user, "likecomment", Comment::where('id_comment', $id_comment)->first()['id_post'], 'mi piace');
					}
					return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_user' => $user['id_user'], 'status_like' => 'blue', 'status_dislike' => 'black'));
				}
				else{
					$like = new LikeComment();
					$like->id_comment = $id_comment;
					$like->like = 1;
					$like->id_user = $user['id_user'];
					$like->save();
					if(!is_numeric(Comment::where('id_comment', $id_comment)->first()['id_author'])){
						Notification::SendNotification($id_comment, $user, "likecomment", Comment::where('id_comment', $id_comment)->first()['id_post'], 'mi piace');
					}
					return(array('type' => 'comm', 'id_comment' => request('id'), 'id_user' => $user['id_user'], 'status_like' => 'blue', 'status_dislike' => 'black'));
				}
				break;

			case "dislikecomm":
				$record = LikeComment::where('id_comment', $id_comment)->where('id_user', $user['id_user'])->first();
				if(($record) && ($record['like'] == 0)){
					//se premo di nuovo il pulsante elimino il record
					DB::table('notifications')->where('id_user', Comment::where('id_comment', $id_comment)->first()['id_author'] )->where('link', '/details/post/' . Comment::where('id_comment', $id_comment)->first()['id_post'])->delete();
					DB::table('like_comments')->where('id_comment', $id_comment)->where('id_user', $user['id_user'])->delete();
					return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_user' => $user['id_user'], 'status_like' => 'black', 'status_dislike' => 'black'));
				}
				else if(($record) && ($record['like'] == 1)){
					DB::table('notifications')->where('id_user', Comment::where('id_comment', $id_comment)->first()['id_author'] )->where('link', '/details/post/' . Comment::where('id_comment', $id_comment)->first()['id_post'])->delete();
					DB::table('like_comments')->where('id_comment', $id_comment)->where('id_user', $user['id_user'])->update(array('like' => 0));
					if(!is_numeric(Comment::where('id_comment', $id_comment)->first()['id_author'])){
						Notification::SendNotification($id_comment, $user, "likecomment", Comment::where('id_comment', $id_comment)->first()['id_post'], 'non mi piace');
					}
					return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_user' => $user['id_user'], 'status_like' => 'black', 'status_dislike' => 'red'));
				}
				else{
					$like = new LikeComment();
					$like->id_comment = $id_comment;
					$like->like = 0;
					$like->id_user = $user['id_user'];
					$like->save();
					if(!is_numeric(Comment::where('id_comment', $id_comment)->first()['id_author'])){
						Notification::SendNotification($id_comment, $user, "likecomment", Comment::where('id_comment', $id_comment)->first()['id_post'],' non mi piace');
					}
					return(array('type' => 'comm', 'id_comment' => $id_comment, 'id_user' => $user['id_user'], 'status_like' => 'black', 'status_dislike' => 'red'));
				}
				break;
		}
	}
}
