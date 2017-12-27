<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Post;
use App\Users_make_friends;
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

      //Caricamento della lista amici: stato=0->not friends, stato=1->pending, stato=2->ok
      //$friends = Users_make_friends::where('id_request_user', $id)->where('status', 2)->get();

      //foreach ($friend as $friends){

      //}

      //Caricamento dei post degli amici
      //per ogni elemento di friends devo andare nella tabella post_users e tirare fuori tutti gli id dei post di ogni mio amico

      $posts = Post::all();
      //gli passo il controller stesso così posso richiamare le funzioni direttamente dalle views
      $controller = $this;
      return view('home', compact('user', 'posts','controller'));
      
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

  //prendendo in ingresso un id, restituisce l'utente relativo
  //es. da un post id_author--->id_user
  public function ShowUser($param){
    $user = User::where('id_user', $param)->first();
    #$nome = $user->name;
    return $user;

  }

}
