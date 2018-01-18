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
    		return redirect('/');
			try{
				$logged_user = User::where('id_user', Cookie::get('session'))->first();
				//se il profilo dell'utente è pubblico allora posso vedere il post
				$post_author = User::where('id_user', Post::where('id_post', $id)->first()['id_author'])->first();
				$logged_user_friends = User::friends($logged_user['id_user']);
				if($post_author->profiloPubblico == 0){
					return view('detailsPost', compact('logged_user'));
				}
				else if($post_author['id_user'] === $logged_user['id_user']){
					return view('detailsPost', compact('logged_user'));
				}
				else if(in_array($post_author, $logged_user_friends)){
					return view('detailsPost', compact('logged_user'));
				}
				else{
					return redirect('/');
				}
			}
			catch(\Exception $e){
				return view('error', compact('e'));
			}
    }
}
