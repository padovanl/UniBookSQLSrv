<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\CommentU;

class CommentController extends Controller
{
  public function index() {
    return view('/comment');
  }

  public function store(Request $request){
      $comment = new CommentU;
      $id_user = Cookie::get('session');
      $comment->content = request('content');
      $comment->id_author = $id_user;
      $comment->id_post = request('id_post');
      $comment -> save();

      return redirect('/comment');
  }

}
