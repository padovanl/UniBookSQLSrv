<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Page;
use App\Post;
use App\Comment;
use App\LikePost;
use App\PostViewModel;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
  protected $table = 'posts';
  public $timestamps = false;

  //funzione che compara la data di creazione di un post
  public function cmp($a, $b) {
      if ($a->created_at == $b->created_at) return 0;
      return (strtotime($a->created_at) < strtotime($b->created_at)) ? 1 : -1;
  }

  //per ogni id post passato, crea una struttura del tipo 'PostViewModel' con all'interno tutti i dettagli di un post
  public function createPost($logged, $post_id, $in_page=null){
    $post = Post::where('id_post', $post_id)->first();
    $post_comments = Comment::where('id_post', $post_id)->get();
    if(!is_numeric($post['id_author'])){
      $user_post = User::where('id_user', $post['id_author'])->first();
      $userlikes = LikePost::where('id_user', $logged)->where('id_post', $post['id_post'])->first()['like'];
      $comments = Comment::GetCommentsPost($post_comments, $logged, $user_post, $in_page);
    }
    else{
      $user_post = Page::where('id_page', $post['id_author'])->first();
      if($in_page){
        $userlikes = LikePostPage::where('id_page', $user_post['id_page'])->where('id_post', $post['id_post'])->first()['like'];
        $comments = Comment::GetCommentsPost($post_comments, $user_post['id_page'], $user_post, 1);
      }
      else{
        $userlikes = LikePost::where('id_user', $logged)->where('id_post', $post['id_post'])->first()['like'];
        $comments = Comment::GetCommentsPost($post_comments, $logged, $user_post, $in_page);
      }
    }
    $users_like = LikePost::GetPostLike($post);
    $users_dislike = LikePost::GetPostDislike($post);
    $toreturn = new PostViewModel($post_id, $user_post['name'], $user_post['surname'], $user_post['pic_path'],
                      $post['content'], $post['created_at'], $post['updated_at'],
                      $post['is_fixed'], $post['id_author'], $comments,
                      $users_like,
                      $users_dislike,
                      $userlikes,
                      $user_post['ban']);
    return($toreturn);
  }
  //funzione che, data una lista di id_post e l'utente, torna un array di PostViewModel
  public function scopeGetPosts($query, $id_post_list, $logged_id, $in_page=null){
    $toreturn = array();
    foreach ($id_post_list as $post_id){
      //recupero tutte le informazioni di un post e me le restituisco in un array complesso
      array_push($toreturn, $this->createPost($logged_id, $post_id, $in_page));
    }
    //ordino per data
    usort($toreturn, array($this, 'cmp'));
    return($toreturn);
  }
  //funzione inserimento post sia per utente che per pagina
  public function scopeInsertPost($query, $content, $author_id){
    date_default_timezone_set('Europe/Rome');
    if(!is_numeric($author_id)){
      $user = User::where('id_user', $author_id)->first();
      if(!$user['ban']){
        $post = new Post();
        $post->content =  $content;
        $post->created_at = now();
        $post->updated_at = now();
        $post->id_author = $author_id;
        $post->save();
        //chiamata di verifica e di inserimento nella tabella 'posts_user' del record relativo al post
        $post_tmp = Post::where('id_author', $author_id)->where('content', request('content'))->first();
        DB::table('posts_user')->insert(['id_user' => $user['id_user'], 'id_post' => $post_tmp['id_post']]);
        $post = new PostViewModel($post_tmp['id_post'], $user['name'], $user['surname'], $user['pic_path'], $post_tmp['content'], $post_tmp['created_at'], $post_tmp['updated_at'], $post_tmp['fixed'], $post_tmp['id_author'], [], [], [], [], $user['ban']);
        return($post);
      }
      else{
        return(false);
      }
    }
    else{
      $page = Page::where('id_page', $author_id)->first();
      if(!$page['ban']){
        $post = new Post();
        $post->content =  $content;
        $post->created_at = now();
        $post->updated_at = now();
        $post->id_author = $author_id;
        $post->save();
        //chiamata di verifica e di inserimento nella tabella 'posts_user' del record relativo al post
        $post_tmp = Post::where('id_author', $author_id)->where('content', request('content'))->first();
        DB::table('posts_page')->insert(['id_page' => $page['id_page'], 'id_post' => $post_tmp['id_post']]);
        $post = new PostViewModel($post_tmp['id_post'], $page['name'],'', $page['pic_path'], $post_tmp['content'], $post_tmp['created_at'], $post_tmp['updated_at'], $post_tmp['fixed'], $post_tmp['id_author'], [], [], [], [], $page['ban']);
        return($post);
      }
      else{
        return(false);
      }
    }

  }
}
