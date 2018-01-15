<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\Post;
use App\PostViewModel;
use App\CommentViewModel;
use App\User;
use App\Page;
use App\LikePost;
use App\LikeComment;
use App\CommentU;

class PostController extends Controller
{
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

    public function details($id){
    	if(!$this->verify_cookie())
    		return view('/');
    	$logged_user = User::where('id_user', Cookie::get('session'))->first();
			$post = $this->createPost($logged_user, $id);

    	return view('detailsPost', compact('logged_user', 'post'));
    }
}
