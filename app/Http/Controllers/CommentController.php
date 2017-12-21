<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Comment;

class CommentController extends Controller
{
  public function index() {
    return view('/comment');
  }

  public function store(Request $request){
      $comment = new Comment;
      $comment->content = request('content');
      $comment->id_author = request('id_user');
      $comment->id_post = request('id_post');
      $comment -> save();

      return redirect('/comment');
  }

}
