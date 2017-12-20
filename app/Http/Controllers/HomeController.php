<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use Cookie;

class HomeController extends Controller{

  public function verify_cookie(){
    if (Cookie::has('session'))
    {
      return true;
    }
    else{
      return false;
    }
  }

  //funzione richiamata quando viene richiesta la root del nostro sito
  public function landing()
  {
    if($this->verify_cookie()){
      //login
      $id = Cookie::get('session');
      $user = User::where('id_user', $id)->first();

      //Caricamento dei post
      $posts = Post::all();

      return view('home', compact('user', 'posts'));
    }
    else{
      return redirect('/login');
    }
  }

  public function newPost(Request $request){
    //verifica dei campi
    $id_user = Cookie::get('session');
    $post = new Post;
    $post->id_author = $id_user;
    $post->created_at = now();
    $post->updated_at = now();
    $post->content = request('content');
    $post->fixed = 0;     //ovviamente da verificare

    $post->save();
    //che bello ajax qui....
    return redirect('/');

  }

}
