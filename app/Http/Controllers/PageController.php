<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cookie;
use App\User;
use App\Page;
use App\PostPage;
use App\PostViewModel;
use App\Post;
use App\CommentP;
use App\CommentViewModel;
use App\LikePost;
use App\LikeComment;
use App\PageListViewModel;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    protected function verify_cookie() {
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

   //funzione che compara la data di creazione di un post
   public function cmp($a, $b) {
       if ($a->created_at == $b->created_at) return 0;
       return (strtotime($a->created_at) < strtotime($b->created_at)) ? 1 : -1;
   }
   //torna un array monodimensionale da una collezione di array
   function array_flatten($array) {
     $return = array();
     foreach ($array as $key => $value) {
         if (is_array($value)){
             $return = array_merge($return, array_flatten($value));
         } else {
             $return[$key] = $value;
         }
     }

     return $return;
   }
	public function index(){
		if(!$this->verify_cookie())
    		return response()->json(['message' => 'Loggati!']);
        $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
        $userspages = Page::where('id_user', '=', $logged_user->id_user)->get();
        $temp = collect();
        foreach ($userspages as $u) {
        	$viewModel = new PageListViewModel($u->name, $u->id_user, '/' . $u->pic_path, $u->id_page);
        	$temp->push($viewModel);
        }
        $viewModel = $temp;
        return view('pageIndex', compact('logged_user', 'userspages'));
	}


  //funzione che crea un nuovo post
  public function newPost(Request $request){
    $page = Page::where('id_page', request('id'))->first();
    date_default_timezone_set('Europe/Rome');
    //verifica dei campi
    $post = new Post();
    $post->content = request('content');
    $post->created_at = now();
    $post->updated_at = now();
    $post->fixed = request('is_fixed');
    $post->id_author = $page['id_page'];
    $post->save();
    //chiamata di verifica e di inserimento nella tabella 'posts_user' del record relativo al post
    $post_tmp = Post::where('id_author', $page['id_page'])->where('content', request('content'))->first();
    DB::table('posts_page')->insert(['id_page' => $page['id_page'], 'id_post' => $post_tmp['id_post']]);
    $post = new PostViewModel($post_tmp['id_post'], $page['name'], '', $page['pic_path'], $post_tmp['content'], $post_tmp['created_at'], $post_tmp['updated_at'], $post_tmp['fixed'], $post_tmp['id_author'], [], [], [], [], 0);
    //log
    //$this->log($logged_user['id_user'], 'New Post_' . $post_tmp['id_post']);
    return(json_encode($post));

    }

  //per ogni id post passato, crea una struttura del tipo 'PostViewModel' con all'interno tutti i dettagli di un post
  public function createPost($page, $post_id){
    $tmp_comm = array();
    $post = Post::where('id_post', $post_id)->first();
    $comments = CommentP::where('id_post', $post_id)->get();
    foreach($comments as $comment){
      if(!is_numeric($comment['id_author'])){
        $comm_user = User::where('id_user', $comment['id_author'])->first();
      }
      else{
        $comm_user = Page::where('id_page', $comment['id_author'])->first();
      }
      $dislikes = LikeComment::where('id_comment', $comment['id_comment'])->where('like', 0)->get();
      $users_dislike = array();
      foreach($dislikes as $dislike){
        array_push($users_dislike, User::where('id_user', $dislike['id_user'])->first());
      }
      $likes = LikeComment::where('id_comment', $comment['id_comment'])->where('like', 1)->get();
      $users_like = array();
      foreach($likes as $like){
        array_push($users_like, User::where('id_user', $like['id_user'])->first());
      }

      array_push($tmp_comm, new CommentViewModel($comment['id_comment'], $comm_user['name'],
                                                $comm_user['surname'], $comm_user['pic_path'],
                                                $comment['content'], $comment['created_at'], $comment['updated_at'],
                                                $comment['id_post'], '0',
                                                $users_like,
                                                $users_dislike,
                                                LikeComment::where('id_user', $logged_user['id_user'])->where('id_comment', $comment['id_comment'])->first()['like'],
                                                $comment['id_author'], $comm_user['ban']));
    }

    //Prendo gli user che hanno like
    $post_like = LikePost::where('id_post', $post['id_post'])->where('like', 1)->get();
    $users_like = array();
    foreach($post_like as $like){
      array_push($users_like, User::where('id_user', $like['id_user'])->first());
    }
    //Prendo gli user che hanno dislike
    $post_dislike = LikePost::where('id_post', $post['id_post'])->where('like', 0)->get();
    $users_dislike = array();
    foreach($post_dislike as $dislike){
      array_push($users_dislike, User::where('id_user', $dislike['id_user'])->first());
    }
    $toreturn = new PostViewModel($post_id, $page['name'], $page['surname'], $page['pic_path'],
                      $post['content'], $post['created_at'], $post['updated_at'],
                      $post['is_fixed'], $post['id_author'], $tmp_comm,
                      $users_like,
                      $users_dislike,
                      LikePost::where('id_user', $page['id_page'])->where('id_post', $post['id_post'])->first()['like'],
                      $page['ban']);

    return($toreturn);
  }

  //loading dei post
  public function loadMore(Request $request){
    //MANCANO I CONTROLLI
    $page = Page::where('id_page', request('id'))->first();

    $page_posts = PostPage::where('id_page', $page['id_page'])->get();

    $toreturn = array();
    foreach ($page_posts as $post_id){
      //recupero tutte le informazioni di un post e me le restituisco in un array complesso
      array_push($toreturn, $this->createPost($page, $post_id['id_post']));
    }

    //ordino per data
    usort($toreturn, array($this, 'cmp'));

    if($request->input('post_id') == -1){
      $toreturn = array_slice($toreturn, 0, 7);
      return(json_encode($toreturn));
    }
    else{
      for($i = 0; $i < count($toreturn); $i++){
        if($toreturn[$i]->id_post == $request->input('post_id')){
            $toreturn = array_slice($toreturn, $i + 1, $i + 5);
            return(json_encode($toreturn));
        }
      }
    }
  }

	public function create(Request $request){
		 $logged_user = User::where('id_user', '=', Cookie::get('session'))->first();
		 $input = $request->all();
		 $page = new Page();
		 $page->name = $input['nomePagina'];
		 $page->ban = false;
		 $page->id_user = $logged_user->id_user;
		 $page->pic_path = '/';
		 $page->save();
         //$page->pic_path = 'assets/images/' . $page->id_page . '.jpg';
		 $temp = Page::orderBy('id_page', 'DESC')->get();
		 if(count($temp) > 0){
		 	$pageId = $temp[0]->id_page;
		 }else{
		 	$pageId = 1;
		 }
         $file = Input::file('image');
         $file->move('assets/images', $pageId . '.jpg');
         Page::where('id_page', '=', $pageId)->update(['pic_path' => 'assets/images/' . $pageId . '.jpg']);
         //$page->save();
         return redirect('/page/mypage');
	}
}
