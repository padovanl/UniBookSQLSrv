<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\DB;


class Notification extends Model
{
  protected $table = 'notifications';
  public $timestamps = true;

  //questa funzione manda una notifica al destinatario, dato un id(che può essere di un post o commento), l'utente "target", il tipo("likecomment", "likepost", "comment", l'id del post e una descrizione "mi piace" o "non mi piace")
  public function scopeSendNotification($query, $id, $user, $type, $post_id, $descr){
    try{
      if(!is_numeric(Post::where('id_post', $post_id)->first()['id_author'])){
        switch($type){
          case "likecomment":
            if(($user['id_user']) != (Comment::where('id_comment', $id)->first()['id_author'])){
              DB::table('notifications')->insert(['created_at' => now(), 'updated_at' => now(), 'content' => $user['name'] . " " . $user['surname'] . " ha messo " . $descr . " al tuo commento.", 'new' => 1,
                                                  'id_user' => Comment::where('id_comment', $id)->first()['id_author'], 'link' => "/details/post/" . $post_id, 'id_sender' => $user['id_user']]);
            }
            break;
          case "likepost":
            if(($user['id_user']) != (Post::where('id_post', $id)->first()['id_author'])){
              DB::table('notifications')->insert(['created_at' => now(), 'updated_at' => now(), 'content' => $user['name'] . " " . $user['surname'] . " ha messo " . $descr . " al tuo post.", 'new' => 1,
                                                  'id_user' => Post::where('id_post', intval($id))->first()['id_author'], 'link' => "/details/post/" . $id, 'id_sender' => $user['id_user']]);
            }
            break;
          case "comment":
            if(($user['id_user']) != (Post::where('id_post', $id)->first()['id_author'])){
              DB::table('notifications')->insert(['created_at' => now(), 'updated_at' => now(), 'content' => $user['name'] . " " . $user['surname'] . " ha commentato il al tuo post.", 'new' => 1,
                                                  'id_user' => Post::where('id_post', $id)->first()['id_author'], 'link' => "/details/post/" . $post_id, 'id_sender' => $user['id_user']]);
            }
            break;
        }
        return(1);
      }
    }

    catch(Exception $e){
      return($e->getMessage());
    }

  }
}
