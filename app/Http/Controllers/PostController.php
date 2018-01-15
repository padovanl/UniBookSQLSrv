<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;

use App\Post;
use App\PostViewModel;
use App\User;

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
    		return view('/');
    	$logged_user = User::where('id_user', Cookie::get('session'))->first();
    	return view('detailsPost', compact('logged_user', 'id'));
    }
}
